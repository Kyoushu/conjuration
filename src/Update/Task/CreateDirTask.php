<?php

namespace Kyoushu\Conjuration\Update\Task;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDirTask implements TaskInterface
{

    /**
     * @var string
     */
    protected $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function getDescription(): string
    {
        return sprintf('Create directory "%s"', $this->dir);
    }

    public function getOptions(): array
    {
        return [];
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if(file_exists($this->dir)){
            $output->writeln(sprintf('"%s" already exists', $this->dir));
            return;
        }

        mkdir($this->dir, 0777, true);
    }


}