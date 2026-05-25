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

        if (preg_match('/\bLIMIT\s+\d+/i', $sql) === 1) {
            return ['sql' => $sql];
        }

        $maxRows = config('ai.limits.max_rows', 1000);

        return ['sql' => rtrim($sql, " \t\n\r;").' LIMIT '.$maxRows];
    }

    /**
     * @return array{error: string}
     */
    private function reject(string $message): array
    {
        return ['error' => $message];
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
}
