<?php

namespace Kyoushu\Conjuration\Update\Task;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractConfigYamlGeneratorTask extends AbstractYamlGeneratorTask
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['path']);
    }

    abstract public function createConfig(): array;

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->getOptions()['path'];
        $config = $this->createConfig();
        $this->writeYamlFile($config, $path);
    }

}