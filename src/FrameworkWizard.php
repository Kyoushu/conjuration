<?php

namespace Kyoushu\Conjuration;

class FrameworkWizard
{

    protected $projectDir;

    public function __construct(string $projectDir, string $configPath)
    {
        $this->projectDir = $projectDir;
    }

    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

}