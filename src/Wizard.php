<?php

namespace Kyoushu\Conjuration;

use Kyoushu\Conjuration\Config\Config;
use Kyoushu\Conjuration\Exception\ConjurationException;
use Kyoushu\Conjuration\Update\Task\TaskInterface;
use Kyoushu\Conjuration\Update\TaskResolver\FrameworkTaskResolver;
use Kyoushu\Conjuration\Update\TaskResolver\FrontControllerTaskResolver;
use Kyoushu\Conjuration\Update\TaskResolver\TaskResolverInterface;
use Kyoushu\Conjuration\Config\Exception\ConfigException;

class Wizard
{

    const CONFIG_FILENAME = 'conjuration.yaml';

    /**
     * @var string
     */
    protected $projectDir;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(string $projectDir, Config $config = null)
    {
        if($config === null){
            $configPath = sprintf('%s/%s', $projectDir, self::CONFIG_FILENAME);
            $config = new Config($configPath);
        }

        if(!file_exists($projectDir)) throw new ConjurationException(sprintf('%s does not exist', $projectDir));
        $this->projectDir = realpath($projectDir);
        $this->config = $config;
    }

    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

    /**
     * @return string
     * @throws ConfigException
     */
    public function getPublicDir(): string
    {
        return sprintf('%s/%s', $this->projectDir, $this->config->getPublicDir());
    }

    /**
     * @return string
     * @throws ConfigException
     */
    public function getCacheDir(): string
    {
        return sprintf('%s/%s', $this->projectDir, $this->config->getCacheDir());
    }

    /**
     * @return string
     * @throws ConfigException
     */
    public function getLogDir(): string
    {
        return sprintf('%s/%s', $this->projectDir, $this->config->getLogDir());
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return TaskResolverInterface[]
     */
    protected function getUpdateTaskResolvers()
    {
        return [
            new FrontControllerTaskResolver($this),
            new FrameworkTaskResolver($this)
        ];
    }

    /**
     * @return TaskInterface[]
     */
    public function resolveUpdateTasks(): array
    {
        $tasks = [];
        foreach($this->getUpdateTaskResolvers() as $taskResolver){
            $tasks = array_merge(
                $tasks,
                array_values($taskResolver->resolveTasks())
            );
        }
        return $tasks;
    }

    public function createKernel(string $environment, bool $debug): ConjurationKernel
    {
        $kernel = new ConjurationKernel($environment, $debug);
        $kernel->setWizard($this);
        return $kernel;
    }

}