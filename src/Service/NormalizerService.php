<?php

namespace App\Service;

class NormalizerService {
    private $regex = '/\[(.*?)\] \[(.*?)\] \[client (.*?)\] (.*)/';
    private $patterns = [
        '/^"(?P<method>GET) (?P<page_request>\/\S+) HTTP\/\d\.\d" (?P<status_code>\d+) (?P<latency>\d+)$/' => 'request',
        '/^"(?P<method>POST) (?P<page_request>\/\S+) HTTP\/\d\.\d" (?P<status_code>\d+) (?P<latency>\d+)$/' => 'request',
        '/^Server: (?P<service_name>.+) (?P<action>starting|stopping|restarted)$/' => 'server_action',
    ];

    /**
     * Format log data by extracting individual log entries.
     *
     * @param string $rawData The raw log data to be formatted.
     *
     * @return array An array containing individual log entries.
     */
    public function formatLogEntries(array $rawData): array
    {
        preg_match_all('/\[.*?\] \[.*?\] \[.*?\] .*/', $rawData[0], $matches);

        return $matches[0];
    }

    /**
     * Deserialize formatted log data into a structured array.
     *
     * @param array $formattedLogs The formatted log entries to be deserialized.
     *
     * @return array An array of deserialized log entries.
     */
    public function parseLog(array $formattedLogs): array
    {
        $deserializedLogs = [];

        foreach ($formattedLogs as $log) {
            if (preg_match($this->regex, $log, $matches)) {

                $dateConverterService = new DateConverterService();
                $dateConverted = $dateConverterService->convertToTimestamp($matches[1]);

                $dataFormatted = $dateConverterService->convertToFormattedDate($dateConverted);

                $deserializedLogs[] = [
                    'timestamp' => $dataFormatted ?? null,
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

    public function parseLogMessage(string $log): array {
        foreach ($this->patterns as $pattern => $type) {
            if (preg_match($pattern, $log, $matches)) {
                return [
                    'type' => $type, 
                    'data' => $matches
                ];
            }
        }

        return [
            'data' => $log
        ];
    }
}