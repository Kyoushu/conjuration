<?php

namespace Kyoushu\Conjuration\Update\Task;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface TaskInterface
{

    public function getDescription(): string;

    public function getOptions(): array;

    public function execute(InputInterface $input, OutputInterface $output);

}