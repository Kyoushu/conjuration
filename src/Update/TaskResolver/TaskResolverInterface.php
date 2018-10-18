<?php

namespace Kyoushu\Conjuration\Update\TaskResolver;

use Kyoushu\Conjuration\Update\Task\TaskInterface;

interface TaskResolverInterface
{

    /**
     * @return TaskInterface[]
     */
    public function resolveTasks(): array;

}