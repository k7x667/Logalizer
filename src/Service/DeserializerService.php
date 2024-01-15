<?php

namespace App\Service;

class DeserializerService {

    public function formatter(string $data) : array {
        $pattern = '/\[.*?\] \[.*?\] \[.*?\] .*/';

        preg_match_all($pattern, $data, $matches);
        
        $logEntries = array();
        
        foreach ($matches[0] as $logEntry) {
            $logEntries[] = $logEntry;
        }
        
        return $logEntries;
    }

    public function deserializer(array $data) : array {
        $pattern = '/\[(.*?)\] \[(.*?)\] \[client (.*?)\] (.*)/';
        $arr = [];
        foreach ($data as $log) {
            preg_match($pattern, $log, $matches);
            $arr[] = $matches;
        }

        foreach ($arr as $log) {
            $output = [
                'timestamp' => $log[1],
                'level' => $log[2],
                'client_ip' => $log[3],
                'message' => trim($log[4]),
            ];
            $logClearAndFormatted[] = $output;
            $output = [];
        }
        
        return $output;
    }
}