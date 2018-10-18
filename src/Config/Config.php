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
    protected $modelNodes;

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
    public function getModelNodes(): array
    {
        if($this->modelNodes !== null) return $this->modelNodes;
        $this->load();

        $nodes = [];
        foreach($this->config['model'] as $data){
            $nodes[] = new ModelNode($data);
        }

        $this->modelNodes = $nodes;
        return $nodes;
    }

}