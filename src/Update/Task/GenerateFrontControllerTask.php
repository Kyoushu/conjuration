<?php

namespace Kyoushu\Conjuration\Update\Task;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenerateFrontControllerTask extends AbstractTask
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['path']);
    }

    public function getDescription(): string
    {
        return sprintf('Generate "%s"', $this->getOptions()['path']);
    }

    protected function createSource(): string
    {
        $source = [];

        $source[] = '<?php';
        $source[] = '';

        $source[] = 'use Kyoushu\Conjuration\Wizard;';
        $source[] = 'use Symfony\Component\HttpFoundation\Request;';
        $source[] = '';

        $source[] = 'require_once(__DIR__ . \'/../vendor/autoload.php\');';
        $source[] = '';

        // @todo umask(0000) and Debug::enable()

        $source[] = '$wizard = new Wizard(__DIR__ . \'/..\');';
        $source[] = '$kernel = $wizard->createKernel(\'dev\', true);'; // @todo create kernel using env var
        $source[] = '$kernel->boot();';
        $source[] = '';

        $source[] = '$request = Request::createFromGlobals();';
        $source[] = '$response = $kernel->handle($request);';
        $source[] = '$response->send();';
        $source[] = '$kernel->terminate($request, $response);';
        $source[] = '';

        return implode("\n", $source);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->getOptions()['path'];
        $source = $this->createSource();
        file_put_contents($path, $source);

    }

}