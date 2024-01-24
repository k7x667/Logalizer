<?php


namespace App\Service;

use App\Entity\Log;
use Doctrine\Persistence\ManagerRegistry;

class TestLogalizer
{
    /**
     * Parse logs and return structured data.
     *
     * @param array $logs Raw log data
     *
     * @return array|null Array of parsed logs or null if invalid log entry
     */
    public function parseLogs(array $logs): ?array
    {
        foreach ($logs as $log) {
            $logs = array_filter(explode("\n", $log));
        }

        $logs = array_map(function ($log) {

            $log = str_replace(['[', ',', ']'], '', $log);
            $log = explode(" ", $log);

            $patterns = [
                'date'          => '/\d{2}\/\w{3}\/\d{4}:\d{2}:\d{2}:\d{2}/',
                'type'          => '/\b(?:access|info|error|warn)\b/',
                'ip'            => '/(?:[0-9]{1,3}\.){3}[0-9]{1,3}(?:\])?/',
                'method'        => '/\b(GET |POST |PUT |DELETE |HEAD |OPTIONS |PATCH |CONNECT )/',
                'return_code'   => '/\b\d{3}\b/',
                'response_time' => '/(?<=\b\d{3}\b\s)\b\d+\b/',
            ];

            

            $elements = [];
            foreach ($patterns as $key => $pattern)
            {
                if (preg_match($pattern, implode(" ", $log), $matches))
                {
                    $elements[$key] = $matches[0];
                    
                    if (in_array($key, ['date', 'type', 'ip']))
                    {
                        $log = str_replace($matches[0], '', $log);
                    }
                }
            }

            $elements['message'] = trim(
                str_replace(['client'], '', implode(" ", $log))
            );

            $requiredElements = ['date', 'type', 'ip', 'message'];
            foreach ($requiredElements as $requiredElement)
            {
                if ( ! array_key_exists($requiredElement, $elements))
                {
                    return NULL;
                }
            }

            dd($elements);

            $defaultOrder = [
                'date'          => '',
                'type'          => '',
                'ip'            => '',
                'message'       => '',
                'method'        => NULL,
                'return_code'   => NULL,
                'response_time' => NULL,
            ];

            $reorderedLog = array_replace($defaultOrder, $elements);

            $reorderedLog['message'] = trim(
                str_replace(
                    [
                        '"',
                        $reorderedLog['method'],
                        $reorderedLog['return_code'],
                        $reorderedLog['response_time'],
                    ],
                    '',
                    $reorderedLog['message']
                )
            );

            $reorderedLog['method'] = trim($reorderedLog['method']);

        
        }, []);

        return [];
    }
}