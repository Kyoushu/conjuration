<?php

namespace Kyoushu\Conjuration\Update\Task;

use Symfony\Component\Yaml\Yaml;

abstract class AbstractYamlGeneratorTask extends AbstractTask
{

    protected function writeYamlFile(array $data, string $path)
    {
        $yaml = (new Yaml())->dump($data, 4, 4);
        file_put_contents($path, $yaml);
    }

}