<?php

namespace App\Tests;

use App\Service\DeserializerService;
use PHPUnit\Framework\TestCase;

class DeserializerServiceTest extends TestCase
{
    public function __construct() {
        $this->deserializerService = new DeserializerService();
    }

    public function testDeserializerServiceExist(): void
    {
$this->assertInstanceOf(DeserializerService::class, $this->deserializerService);
    }
}
