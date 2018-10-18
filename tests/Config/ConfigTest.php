<?php

namespace Tests\Kyoushu\Conjuration\Config;

use Kyoushu\Conjuration\Config\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    /**
     * @throws \Kyoushu\Conjuration\Config\Exception\ConfigException
     */
    public function testGetConfigData()
    {
        $config = new Config(__DIR__ . '/../Resources/config/minimal_config.yaml');
        $data = $config->getConfigData();

        $this->assertEquals([
            'model' => []
        ], $data);
    }

}