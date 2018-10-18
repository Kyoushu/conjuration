<?php

namespace Kyoushu\Conjuration\Update\Task;

class GenerateServicesYamlTask extends AbstractConfigYamlGeneratorTask
{

    public function getDescription(): string
    {
        return sprintf('Generate "%s"', $this->getOptions()['path']);
    }

    public function createConfig(): array
    {
        $config = ['services' => []];

        $config['services']['_defaults'] = [
            'autowire' => true,
            'autoconfigure' => true,
            'public' => false
        ];

        $config['services']['App\\'] = [
            'resource' => '../src/*',
            'exclude' => '../src/{DependencyInjection,Entity,Migrations,Tests,Kernel.php}'
        ];

        $config['services']['App\\Controller\\'] = [
            'resource' => '../src/Controller',
            'tags' => ['controller.service_arguments']
        ];

        return $config;
    }

}