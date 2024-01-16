<?php

namespace App\Service;

/**
 * Class LogDeserializerService
 *
 * This service class provides methods to format and deserialize log data.
 */
class LogDeserializerService
{
    /**
     * Format log data by extracting individual log entries.
     *
     * @param string $rawData The raw log data to be formatted.
     *
     * @return array An array containing individual log entries.
     */
    public function formatLogEntries(string $rawData): array
    {
        preg_match_all('/\[.*?\] \[.*?\] \[.*?\] .*/', $rawData, $matches);

        return $matches[0];
    }

    /**
     * Deserialize formatted log data into a structured array.
     *
     * @param array $formattedLogs The formatted log entries to be deserialized.
     *
     * @return array An array of deserialized log entries.
     */
    public function deserializeLogs(array $formattedLogs): array
    {
        $deserializedLogs = [];

        foreach ($formattedLogs as $log) {
            if (preg_match('/\[(.*?)\] \[(.*?)\] \[client (.*?)\] (.*)/', $log, $matches)) {
                $deserializedLogs[] = [
                    'timestamp' => $matches[1] ?? null,
                    'level' => $matches[2] ?? null,
                    'client_ip' => $matches[3] ?? null,
                    'message' => isset($matches[4]) ? trim($matches[4]) : null,
                ];
            } else {
                trigger_error("Failed to match log entry: $log", E_USER_WARNING);
            }
        }

        return $deserializedLogs;
    }

}
