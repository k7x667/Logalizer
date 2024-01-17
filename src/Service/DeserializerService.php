<?php

namespace App\Service;

class DeserializerService {

    /**
     * Format log data by extracting individual log entries.
     *
     * @param string $rawData The raw log data to be formatted.
     *
     * @return array An array containing individual log entries.
     *
     * @throws \InvalidArgumentException If the log data format is invalid.
     */
    public function formatLog(string $rawData): array
    {
        $pattern = '/\[.*?\] \[.*?\] \[.*?\] .*/';

        preg_match_all($pattern, $rawData, $matches);
        
        if ($matches[0] == "") {
            throw new \Exception('No log found');
        }

        if (empty($matches[0])) {
            throw new \InvalidArgumentException('Invalid log data format');
        }

        return $matches[0];
    }
}