<?php

namespace Tests\Kyoushu\Conjuration\CodeGenerator\Doctrine;

use Kyoushu\Conjuration\CodeGenerator\Doctrine\TraitGenerator;
use Kyoushu\Conjuration\Config\Config;
use PHPUnit\Framework\TestCase;

class TraitGeneratorTest extends TestCase
{

    /**
     * @throws \Kyoushu\Conjuration\Config\Exception\ConfigException
     */
    public function testResolveTraitFields()
    {
        $config = new Config(__DIR__ . '/../../Resources/config/simple_model_config.yaml');
        $traitGenerator = new TraitGenerator($config);

        $fields = $traitGenerator->resolveTraitFields();
        $this->assertCount(1, $fields);
    }

    /**
     * @throws \Kyoushu\Conjuration\CodeGenerator\Exception\CodeGeneratorException
     * @throws \Kyoushu\Conjuration\Config\Exception\ConfigException
     */
    public function testGenerateStringTrait()
    {
        $config = new Config(__DIR__ . '/../../Resources/config/simple_model_config.yaml');
        $traitGenerator = new TraitGenerator($config);

        $source = $traitGenerator->generate('title');

        $source = explode("\n", $source);

        $this->assertEquals('namespace App\\Entity\\Traits;', $source[2]);
        $this->assertEquals('trait TitleTrait', $source[4]);

        $this->assertEquals('    public function getTitle(): ?string', $source[13]);
        $this->assertEquals('    public function setTitle(string $title = null): self', $source[18]);

    }

}