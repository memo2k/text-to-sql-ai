<?php

namespace App\Services;

class SqlValidator
{
    private const MAX_LENGTH = 16_384;

    private const FORBIDDEN_PATTERN = '/\b(DELETE|DROP|UPDATE|INSERT|REPLACE|TRUNCATE|ALTER|CREATE|GRANT|REVOKE|CALL|EXEC(?:UTE)?|LOCK|UNLOCK|RENAME|LOAD|KILL)\b/i';

    /** @var list<string> */
    private const FORBIDDEN_PHRASES = [
        'INTO OUTFILE',
        'INTO DUMPFILE',
        'LOAD_FILE',
        'FOR UPDATE',
        'LOCK IN SHARE MODE',
    ];

    /**
     * @return array{sql: string}|array{error: string}
     */
    public function validate(string $sql): array
    {
        $sql = trim($sql);

        if ($sql === '') {
            return $this->reject('No SQL query was generated. Try rephrasing your question.');
        }

        if (strlen($sql) > self::MAX_LENGTH) {
            return $this->reject('Generated SQL is too long.');
        }

        $check = trim($this->stripComments($sql));

        if ($check === '' || ! preg_match('/^\s*(WITH|SELECT)\b/i', $check)) {
            return $this->reject('Only a single SELECT query is allowed.');
        }

        if (str_contains(rtrim($this->maskLiterals($check), " \t\n\r;"), ';')) {
            return $this->reject('Only a single SELECT query is allowed.');
        }

        if (preg_match(self::FORBIDDEN_PATTERN, $check) === 1) {
            return $this->reject('Only read-only SELECT queries are allowed.');
        }

        $upper = strtoupper($check);

        foreach (self::FORBIDDEN_PHRASES as $phrase) {
            if (str_contains($upper, $phrase)) {
                return $this->reject('Only read-only SELECT queries are allowed.');
            }
        }

        $masked = $this->maskLiterals($check);

        if ($this->referencesForbiddenSchema($masked)) {
            return $this->reject('Query may only use tables from the demo store schema.');
        }

        if ($this->referencesExcludedTable($masked)) {
            return $this->reject('Query may only use tables from the demo store schema.');
        }

        return ['sql' => $this->enforceLimit($sql)];
    }

    /**
     * @return array{error: string}
     */
    private function reject(string $message): array
    {
        return ['error' => $message];
    }

    private function enforceLimit(string $sql): string
    {
        $sql = rtrim($sql, " \t\n\r;");
        $maxRows = max(1, (int) config('ai.limits.max_rows', 1000));

        if (preg_match('/\bLIMIT\s+(\d+)\s*,\s*(\d+)\s*$/i', $sql, $matches) === 1) {
            $offset = (int) $matches[1];
            $count = min((int) $matches[2], $maxRows);

            return preg_replace(
                '/\bLIMIT\s+\d+\s*,\s*\d+\s*$/i',
                'LIMIT '.$offset.', '.$count,
                $sql
            ) ?? $sql;
        }

        if (preg_match('/\bLIMIT\s+(\d+)\s+OFFSET\s+(\d+)\s*$/i', $sql, $matches) === 1) {
            $count = min((int) $matches[1], $maxRows);
            $offset = (int) $matches[2];

            return preg_replace(
                '/\bLIMIT\s+\d+\s+OFFSET\s+\d+\s*$/i',
                'LIMIT '.$count.' OFFSET '.$offset,
                $sql
            ) ?? $sql;
        }

        if (preg_match('/\bLIMIT\s+(\d+)\s*$/i', $sql, $matches) === 1) {
            $count = min((int) $matches[1], $maxRows);

            return preg_replace(
                '/\bLIMIT\s+\d+\s*$/i',
                'LIMIT '.$count,
                $sql
            ) ?? $sql;
        }

        return $sql.' LIMIT '.$maxRows;
    }

    private function stripComments(string $sql): string
    {
        $sql = preg_replace('/--[^\n]*/', '', $sql) ?? $sql;

        return preg_replace('/\/\*.*?\*\//s', '', $sql) ?? $sql;
    }

    private function maskLiterals(string $sql): string
    {
        $sql = preg_replace("/'([^'\\\\]|\\\\.)*'/", "''", $sql) ?? $sql;
        $sql = preg_replace('/"([^"\\\\]|\\\\.)*"/', '""', $sql) ?? $sql;

        return preg_replace('/`([^`\\\\]|\\\\.)*`/', '``', $sql) ?? $sql;
    }

    private function referencesForbiddenSchema(string $sql): bool
    {
        foreach (config('ai.forbidden_schemas', []) as $schema) {
            $quoted = preg_quote($schema, '/');
            $pattern = '/\b`?'.$quoted.'`?(\s*\.\s*|\b)/i';

            if (preg_match($pattern, $sql) === 1) {
                return true;
            }
        }

        return false;
    }

    private function referencesExcludedTable(string $sql): bool
    {
        foreach (config('ai.excluded_tables', []) as $table) {
            $pattern = '/\b`?'.preg_quote($table, '/').'`?\b/i';

            if (preg_match($pattern, $sql) === 1) {
                return true;
            }
        }

        return false;
    }
}
