<?php

namespace Kyoushu\Conjuration;

use Kyoushu\Conjuration\Exception\ConjurationException;
use phpDocumentor\Reflection\Types\Static_;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class ConjurationKernel extends Kernel
{

    /**
     * @var Wizard|null
     */
    protected $wizard;

    /**
     * @param Wizard $wizard
     * @return $this
     */
    public function setWizard(Wizard $wizard): self
    {
        $this->wizard = $wizard;
        return $this;
    }

    /**
     * @return Wizard
     * @throws ConjurationException
     */
    public function getWizard(): Wizard
    {
        if(!$this->wizard) throw new ConjurationException(sprintf('%s not associated with %s', Wizard::class, static::class));
        return $this->wizard;
    }

    /**
     * @return array|iterable|\Symfony\Component\HttpKernel\Bundle\BundleInterface[]
     */
    public function registerBundles()
    {
        $bundles = [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle()
        ];

        return $bundles;
    }

    /**
     * @return array
     * @throws ConjurationException
     */
    protected function getKernelParameters()
    {
        return [
            'kernel.charset' => 'UTF-8',
            'kernel.secret' => 'thisismysecret', // @todo make this better
            'kernel.debug' => $this->isDebug(),
            'kernel.root_dir' => $this->getWizard()->getProjectDir() . '/src',
            'kernel.project_dir' => $this->getWizard()->getProjectDir(),
            'kernel.public_dir' => $this->getWizard()->getPublicDir(),
            'kernel.name' => 'src',
            'kernel.environment' => $this->getEnvironment(),
            'kernel.cache_dir' => $this->getCacheDir(),
            'kernel.logs_dir' => $this->getLogDir(),
            'kernel.container_class' => $this->getContainerClass(),
            'kernel.locale' => $this->getWizard()->getLocale()
        ];
    }

    /**
     * @return string
     * @throws ConjurationException
     */
    public function getCacheDir()
    {
        return sprintf('%s/%s', $this->getWizard()->getCacheDir(), $this->getEnvironment());
    }

    /**
     * @return string
     * @throws Config\Exception\ConfigException
     * @throws ConjurationException
     */
    public function getLogDir()
    {
        return $this->getWizard()->getLogDir();
    }

    /**
     * @todo implement
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }

}