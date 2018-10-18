<?php

namespace Kyoushu\Conjuration\Update\TaskResolver;

use Kyoushu\Conjuration\Wizard;

abstract class AbstractTaskResolver implements TaskResolverInterface
{

    /**
     * @var Wizard
     */
    private $wizard;

    public function __construct(Wizard $wizard)
    {
        $this->wizard = $wizard;
    }

    public function getWizard(): Wizard
    {
        return $this->wizard;
    }

}