<?php

namespace Tests\Kyoushu\Conjuration\Config;

use Kyoushu\Conjuration\Config\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{

    protected function processConfig(array $config): array
    {
        $configuration = new Configuration();
        $processor = new Processor();
        return $processor->processConfiguration($configuration, [$config]);
    }

    public function testModelConfig()
    {
        $config = $this->processConfig([
            'model' => [
                [
                    "name" => "foo"
                ]
            ]
        ]);

        $this->assertEquals([
            'model' => [
                [
                    "name" => "foo",
                    "single" => false
                ]
            ]
        ], $config);
    }

}