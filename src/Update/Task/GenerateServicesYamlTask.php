<?php

namespace Kyoushu\Conjuration\Update\Task;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenerateServicesYamlTask extends AbstractYamlGeneratorTask
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['path']);
    }

    public function getDescription(): string
    {
        return sprintf('Generate "%s"', $this->getOptions()['path']);
    }

    protected function createConfig(): array
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

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->getOptions()['path'];
        $config = $this->createConfig();
        $this->writeYamlFile($config, $path);
    }


}