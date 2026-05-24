<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class PromptService
{
    public function buildSchemaPrompt(string $databaseName)
    {
        $schema = self::introspect($databaseName);
        $lines = [
            "Database: {$schema['name']} ({$schema['dialect']})",
            'Only query tables listed below. Table names are exact — include the store_ prefix.',
            '',
        ];

        foreach ($schema['tables'] as $table) {
            $lines[] = "Table: {$table['name']}";

            foreach ($table['columns'] as $column) {
                $parts = [$column['name'].': '.$column['type']];

                if ($column['key'] === 'PRI') {
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

    private function introspect(string $databaseName): array
    {
        $config = config('ai.databases.' . $databaseName);
        $connection = $config['connection'];
        $schema = DB::connection($connection)->getDatabaseName();

        $tables = DB::connection($connection)->select(
            'SELECT TABLE_NAME AS name
             FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = ? AND TABLE_NAME LIKE ?
             ORDER BY TABLE_NAME',
            [$schema, '%']
        );

        $result = [
            'databaseName' => $databaseName,
            'name' => $config['name'],
            'dialect' => 'MySQL',
            'tables' => [],
        ];

        foreach ($tables as $table) {
            $tableName = $table->name;

            $columns = DB::connection($connection)->select(
                'SELECT COLUMN_NAME AS name, DATA_TYPE AS type, IS_NULLABLE AS nullable, COLUMN_KEY AS column_key
                 FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
                 ORDER BY ORDINAL_POSITION',
                [$schema, $tableName]
            );

            $foreignKeys = DB::connection($connection)->select(
                'SELECT COLUMN_NAME AS column_name,
                        REFERENCED_TABLE_NAME AS references_table,
                        REFERENCED_COLUMN_NAME AS references_column
                 FROM information_schema.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL',
                [$schema, $tableName]
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
                    'key' => $col->column_key !== '' ? $col->column_key : null,
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
}