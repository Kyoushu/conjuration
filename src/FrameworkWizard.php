<?php

namespace Kyoushu\Conjuration;

class FrameworkWizard
{

    protected $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

}