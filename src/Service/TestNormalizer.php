<?php

// this is replica avec TestLogalizer 

namespace App\Service;

class TestNormalizer
{
    public function parse(array $logs): array 
    {

        foreach ($logs as $log) {
            $logs = array_filter(explode("\n", $log));
        }

        

        return [];
    }
}