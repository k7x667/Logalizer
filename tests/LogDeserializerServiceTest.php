<?php

namespace App\Tests\Service;

use App\Service\LogDeserializerService;
use PHPUnit\Framework\TestCase;

class LogDeserializerServiceTest extends TestCase
{
    /**
     * @var LogDeserializerService
     */
    private $logDeserializerService;

    protected function setUp(): void
    {
        // Initialisation du service avant chaque test
        $this->logDeserializerService = new LogDeserializerService();
    }

    public function testFormatLogEntries(): void
    {
        $rawData = "[2022-01-01] [INFO] [client 127.0.0.1] Log entry 1\n[2022-01-02] [ERROR] [client 192.168.1.1] Log entry 2";

        $formattedLogs = $this->logDeserializerService->formatLogEntries($rawData);

        $this->assertCount(2, $formattedLogs);

        $this->assertStringContainsString('[2022-01-01] [INFO] [client 127.0.0.1] Log entry 1', $formattedLogs[0]);
        $this->assertStringContainsString('[2022-01-02] [ERROR] [client 192.168.1.1] Log entry 2', $formattedLogs[1]);
    }


    public function testDeserializeLogs(): void
    {
        $formattedLogs = [
            '[2022-01-01] [INFO] [client 127.0.0.1] Log entry 1',
            '[2022-01-02] [ERROR] [client 192.168.1.1] Log entry 2',
        ];

        $deserializedLogs = $this->logDeserializerService->deserializeLogs($formattedLogs);

        $this->assertCount(2, $deserializedLogs);

        $this->assertEquals([
            'timestamp' => '2022-01-01',
            'level' => 'INFO',
            'client_ip' => '127.0.0.1',
            'message' => 'Log entry 1',
        ], $deserializedLogs[0]);

        $this->assertEquals([
            'timestamp' => '2022-01-02',
            'level' => 'ERROR',
            'client_ip' => '192.168.1.1',
            'message' => 'Log entry 2',
        ], $deserializedLogs[1]);
    }

    
}
