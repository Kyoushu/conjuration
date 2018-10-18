<?php

namespace Kyoushu\Conjuration\Update\TaskResolver;

use Kyoushu\Conjuration\Config\Exception\ConfigException;
use Kyoushu\Conjuration\Update\Task\CreateDirTask;
use Kyoushu\Conjuration\Update\Task\GenerateFrontControllerTask;
use Kyoushu\Conjuration\Update\Task\TaskInterface;

class FrontControllerTaskResolver extends AbstractTaskResolver
{

    /**
     * @return TaskInterface[]
     * @throws ConfigException
     */
    public function resolveTasks(): array
    {
        $tasks = [];

        $wizard = $this->getWizard();

        $publicDir = $wizard->getPublicDir();
        $indexPath = sprintf('%s/index.php', $publicDir);

        if(!file_exists($publicDir)){
            $tasks[] = new CreateDirTask($publicDir);
        }

        $tasks[] = new GenerateFrontControllerTask($this->getWizard(), ['path' => $indexPath]);

        return $tasks;
    }

}