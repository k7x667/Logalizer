<?php

namespace App\Service;

class MessageParserService
{
    /**
     * Parses Apache logs based on predefined patterns.
     *
     * @param string $logs The Apache log lines.
     *
     * @return array Parsed log entries.
     */
    public function parseLogs($logs)
    {
        $logLines = explode("\n", $logs);
        $parsedLogs = [];

        foreach ($logLines as $logLine) {
            $parsedLogs[] = $this->parseLogLine($logLine);
        }

        return $parsedLogs;
    }

    /**
     * Parses a single Apache log line based on predefined patterns.
     *
     * @param string $logLine The Apache log line.
     *
     * @return array Parsed log entry.
     */
    public function parseLogLine($logLine)
    {
        $patterns = [
            '/^"(?P<method>GET) (?P<page_request>\/\S+) HTTP\/\d\.\d" (?P<status_code>\d+) (?P<latency>\d+)$/' => 'request',
            '/^"(?P<method>POST) (?P<page_request>\/\S+) HTTP\/\d\.\d" (?P<status_code>\d+) (?P<latency>\d+)$/' => 'request',
            '/^Server: (?P<service_name>.+) (?P<action>starting|stopping|restarted)$/' => 'server_action',
        ];

        foreach ($patterns as $pattern => $type) {
            if (preg_match($pattern, $logLine, $matches)) {
                return ['type' => $type, 'data' => $matches];
            }
        }

        // If no pattern matches, return the original log line
        return ['type' => 'unknown', 'data' => $logLine];
    }
}
