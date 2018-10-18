<?php

namespace Kyoushu\Conjuration\Update\Task;

use Kyoushu\Conjuration\Wizard;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractTask implements TaskInterface
{

    /**
     * @var Wizard
     */
    private $wizard;

    /**
     * @var array
     */
    private $options;

    public function __construct(Wizard $wizard, array $options)
    {
        $this->wizard = $wizard;

        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    abstract public function configureOptions(OptionsResolver $resolver);

    public function getWizard(): Wizard
    {
        return $this->wizard;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

}