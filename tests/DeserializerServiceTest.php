<?php

namespace App\Tests;

use App\Service\DeserializerService;
use PHPUnit\Framework\TestCase;

class DeserializerServiceTest extends TestCase
{
    
    public function testDeserializerServiceExist(): void
    {
        $service = new DeserializerService();
        $rawData = "[2024-01-17] [INFO] [App] This is a log entry.\n[2024-01-17] [ERROR] [App] Error occurred.";

        $result = $service->formatLog($rawData);

        $expectedResult = [
            "[2024-01-17] [INFO] [App] This is a log entry.",
            "[2024-01-17] [ERROR] [App] Error occurred."
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function testFormatLogInvalidData()
    {
        $service = new DeserializerService();

        $invalidRawData = "This is not a valid log entry.";

        $this->expectException(\InvalidArgumentException::class);

        $service->formatLog($invalidRawData);
    }

    public function testFormatLogEmptyData()
    {
        $deserializerService = new DeserializerService();

        $emptyRawData = "";

        $this->expectException(\Exception::class);

        $result = $deserializerService->formatLog($emptyRawData);

        $this->assertEquals([], $result);
    }

    public function testFormatLogSingleEntry()
    {
        $deserializerService = new DeserializerService();

        $singleEntryRawData = "[2024-01-17] [INFO] [App] This is a single log entry.";

        $result = $deserializerService->formatLog($singleEntryRawData);

        $expectedResult = [
            "[2024-01-17] [INFO] [App] This is a single log entry."
        ];

        $this->assertEquals($expectedResult, $result);
    }

    

    public function testFormatLogWithMultipleEmptyLines()
    {
        $deserializerService = new DeserializerService();

        $rawDataWithEmptyLines = "[2024-01-17] [INFO] [App] This is a log entry.\n\n\n[2024-01-17] [ERROR] [App] Another log entry.";

        $result = $deserializerService->formatLog($rawDataWithEmptyLines);

        $expectedResult = [
            "[2024-01-17] [INFO] [App] This is a log entry.",
            "[2024-01-17] [ERROR] [App] Another log entry."
        ];

        $this->assertEquals($expectedResult, $result);
    }


}
