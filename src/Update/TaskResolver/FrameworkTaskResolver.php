<?php

namespace Kyoushu\Conjuration\Update\TaskResolver;

use Kyoushu\Conjuration\Config\Exception\ConfigException;
use Kyoushu\Conjuration\Update\Task\CreateDirTask;
use Kyoushu\Conjuration\Update\Task\GenerateServicesYamlTask;
use Kyoushu\Conjuration\Update\Task\TaskInterface;

class FrameworkTaskResolver extends AbstractTaskResolver
{

    /**
     * @return TaskInterface[]
     * @throws ConfigException
     */
    public function resolveTasks(): array
    {
        $wizard = $this->getWizard();

        $tasks = [];

        $cacheDir = $wizard->getCacheDir();
        if(!file_exists($cacheDir)) $tasks[] = new CreateDirTask($cacheDir);

        $logDir = $wizard->getLogDir();
        if(!file_exists($logDir)) $tasks[] = new CreateDirTask($logDir);

        $configDir = $wizard->getConfigDir();
        if(!file_exists($configDir)) $tasks[] = new CreateDirTask($configDir);

        $servicesYamlPath = sprintf('%s/services.yaml', $wizard->getConfigDir());
        $tasks[] = new GenerateServicesYamlTask($wizard, [
            'path' => $servicesYamlPath
        ]);

        return $tasks;
    }

}