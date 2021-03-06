<?php

namespace Kyoushu\Conjuration\Config;

use Kyoushu\Conjuration\Config\Exception\ConfigException;
use Kyoushu\Conjuration\Config\Node\ModelNode;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

class Config
{

    /**
     * @var bool
     */
    protected $loaded;

    /**
     * @var string
     */
    protected $configPath;

    /**
     * @var array|null
     */
    protected $config;

    /**
     * @var ModelNode[]
     */
    protected $models;

    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
        $this->loaded = false;
    }

    /**
     * @throws ConfigException
     */
    public function load()
    {
        if($this->loaded) return;

        if(!file_exists($this->configPath)){
            throw new ConfigException(sprintf('%s does not exist', $this->configPath));
        }

        $yaml = new Yaml();
        $rawConfig = $yaml->parseFile($this->configPath);

        $configuration = new Configuration();
        $processor = new Processor();

        $this->config = $processor->processConfiguration($configuration, $rawConfig);
    }

    /**
     * @return string
     * @throws ConfigException
     */
    public function getAppNamespace(): string
    {
        $this->load();
        return $this->config['app_namespace'];
    }

    /**
     * @return string
     * @throws ConfigException
     */
    public function getPublicDir(): string
    {
        $this->load();
        return $this->config['public_dir'];
    }

    /**
     * @return string
     * @throws ConfigException
     */
    public function getCacheDir(): string
    {
        $this->load();
        return $this->config['cache_dir'];
    }

    /**
     * @return string
     * @throws ConfigException
     */
    public function getLogDir(): string
    {
        $this->load();
        return $this->config['log_dir'];
    }

    /**
     * @return string
     * @throws ConfigException
     */
    public function getLocale(): string
    {
        $this->load();
        return $this->config['locale'];
    }

    /**
     * @return array
     * @throws ConfigException
     */
    public function getConfigData(): array
    {
        $this->load();
        return $this->config;
    }

    /**
     * @return ModelNode[]
     * @throws ConfigException
     */
    public function getModels(): array
    {
        if($this->models !== null) return $this->models;
        $this->load();

        $nodes = [];
        foreach($this->config['model'] as $data){
            $nodes[] = new ModelNode($data);
        }

        $this->models = $nodes;
        return $nodes;
    }

    /**
     * @param string $name
     * @return ModelNode
     * @throws ConfigException
     */
    public function findModelByName(string $name): ModelNode
    {
        foreach($this->models as $model){
            if($model->getName() === $name) return $model;
        }
        throw new ConfigException(sprintf('Model "%s" not defined in %s', $name, static::class));
    }

}