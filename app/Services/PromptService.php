<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class PromptService
{
    public function buildSchemaPrompt(string $databaseName): string
    {
        $schema = $this->introspect($databaseName);
        $lines = [
            "Database: {$schema['name']} ({$schema['dialect']})",
            'Only query tables listed below. Table names are exact.',
            '',
        ];

        foreach ($schema['tables'] as $table) {
            $lines[] = "Table: {$table['name']}";

            foreach ($table['columns'] as $column) {
                $parts = [$column['name'].': '.$column['type']];

                if ($column['primary']) {
                    $parts[] = 'PRIMARY KEY';
                }

                if (! $column['nullable']) {
                    $parts[] = 'NOT NULL';
                }

                $lines[] = '  - '.implode(', ', $parts);
            }

            foreach ($table['foreign_keys'] as $fk) {
                $lines[] = "  - FK: {$fk['column']} → {$fk['references_table']}.{$fk['references_column']}";
            }

            if ($table['sample_rows'] !== []) {
                $lines[] = '  Sample rows: '.json_encode($table['sample_rows'], JSON_UNESCAPED_UNICODE);
            }

            $lines[] = '';
        }

        return implode("\n", $lines);
    }

    /**
     * @return array{
     *     databaseName: string,
     *     name: string,
     *     dialect: string,
     *     tables: list<array{
     *         name: string,
     *         columns: list<array{name: string, type: string, nullable: bool, primary: bool}>,
     *         sample_rows: list<array<string, mixed>>,
     *         foreign_keys: list<array{column: string, references_table: string, references_column: string}>
     *     }>
     * }
     */
    private function introspect(string $databaseName): array
    {
        $config = config('ai.databases.'.$databaseName);
        $connection = $config['connection'];
        $schemaName = $config['schema'] ?? 'public';
        $excluded = $this->excludedTables($databaseName);

        $sql = 'SELECT table_name AS name
                FROM information_schema.tables
                WHERE table_schema = ? AND table_type = \'BASE TABLE\'';
        $bindings = [$schemaName];

        if ($excluded !== []) {
            $placeholders = implode(', ', array_fill(0, count($excluded), '?'));
            $sql .= " AND table_name NOT IN ({$placeholders})";
            $bindings = array_merge($bindings, $excluded);
        }

        $sql .= ' ORDER BY table_name';

        $tables = DB::connection($connection)->select($sql, $bindings);

        $result = [
            'databaseName' => $databaseName,
            'name' => $config['name'],
            'dialect' => $config['dialect'] ?? 'PostgreSQL',
            'tables' => [],
        ];

        foreach ($tables as $table) {
            $tableName = $table->name;

            $columns = DB::connection($connection)->select(
                'SELECT column_name AS name, data_type AS type, is_nullable AS nullable
                 FROM information_schema.columns
                 WHERE table_schema = ? AND table_name = ?
                 ORDER BY ordinal_position',
                [$schemaName, $tableName]
            );

            $primaryKeys = DB::connection($connection)->select(
                'SELECT kcu.column_name
                 FROM information_schema.table_constraints tc
                 JOIN information_schema.key_column_usage kcu
                   ON tc.constraint_schema = kcu.constraint_schema
                  AND tc.constraint_name = kcu.constraint_name
                 WHERE tc.table_schema = ?
                   AND tc.table_name = ?
                   AND tc.constraint_type = \'PRIMARY KEY\'',
                [$schemaName, $tableName]
            );

            $primaryKeyColumns = array_column($primaryKeys, 'column_name');

            $foreignKeys = DB::connection($connection)->select(
                'SELECT kcu.column_name,
                        ccu.table_name AS references_table,
                        ccu.column_name AS references_column
                 FROM information_schema.table_constraints tc
                 JOIN information_schema.key_column_usage kcu
                   ON tc.constraint_schema = kcu.constraint_schema
                  AND tc.constraint_name = kcu.constraint_name
                 JOIN information_schema.constraint_column_usage ccu
                   ON ccu.constraint_schema = tc.constraint_schema
                  AND ccu.constraint_name = tc.constraint_name
                 WHERE tc.table_schema = ?
                   AND tc.table_name = ?
                   AND tc.constraint_type = \'FOREIGN KEY\'',
                [$schemaName, $tableName]
            );

            $sampleRows = DB::connection($connection)
                ->table($tableName)
                ->limit(2)
                ->get()
                ->map(fn ($row) => (array) $row)
                ->all();

            $result['tables'][] = [
                'name' => $tableName,
                'columns' => array_map(fn ($col) => [
                    'name' => $col->name,
                    'type' => $col->type,
                    'nullable' => $col->nullable === 'YES',
                    'primary' => in_array($col->name, $primaryKeyColumns, true),
                ], $columns),
                'sample_rows' => $sampleRows,
                'foreign_keys' => array_map(fn ($fk) => [
                    'column' => $fk->column_name,
                    'references_table' => $fk->references_table,
                    'references_column' => $fk->references_column,
                ], $foreignKeys),
            ];
        }

        return $result;
    }

    /**
     * @return list<string>
     */
    private function excludedTables(string $databaseName): array
    {
        $global = config('ai.excluded_tables', []);
        $perDatabase = config("ai.databases.{$databaseName}.excluded_tables", []);

        return array_values(array_unique([...$global, ...$perDatabase]));
    }
}
