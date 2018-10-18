<?php

namespace Tests\Kyoushu\Conjuration\CodeGenerator\Doctrine;

use Kyoushu\Conjuration\CodeGenerator\GeneratorInterface;
use Kyoushu\Conjuration\Config\Config;
use Kyoushu\Conjuration\Config\Node\FieldNode;

class PropertyGenerator implements GeneratorInterface
{

    /**
     * @var Config
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    protected function resolveTypes(FieldNode $field): array
    {
        $types = [];
        if($field->getAssociationTo() === 'many'){
            $types[] = 'Collection';
        }
        else{
            $types[] = $field->getType();
            $types[] = 'null';
        }
        return $types;
    }

    protected function resolveAnnotations(FieldNode $field): array
    {
        $annotations = [];
        $types = $this->resolveTypes($field);

        $annotations[] = sprintf('@var %s', implode('|', $types));

        if(!$field->isAssociation()){
            $annotations[] = sprintf('@ORM\\Column(type="%s", nullable=true)', $field->getType());
        }

        return $annotations;
    }

    public function generateProperty(FieldNode $field): string
    {
        $source = [];

        $annotations = $this->resolveAnnotations($field);

        $source[] = sprintf('%s/**', self::SOURCE_INDENTATION);
        foreach($annotations as $annotation){
            $source[] = sprintf('%s * %s', self::SOURCE_INDENTATION, $annotation);
        }
        $source[] = sprintf('%s */', self::SOURCE_INDENTATION);
        $source[] = sprintf('%sprotected $%s;', self::SOURCE_INDENTATION, $field->getPropertyName());

        return implode("\n", $source);
    }

    public function generateGettersSetters(FieldNode $field): string
    {
        $source = [];

        $source[] = sprintf(
            '%spublic function get%s(): ?%s',
            self::SOURCE_INDENTATION,
            $field->getMethodSuffix(),
            $field->getType()
        );

        $source[] = sprintf('%s{', self::SOURCE_INDENTATION);
        $source[] = sprintf('%sreturn $this->%s;', str_repeat(self::SOURCE_INDENTATION, 2), $field->getPropertyName());
        $source[] = sprintf('%s}', self::SOURCE_INDENTATION);
        $source[] = '';

        if($field->getAssociationTo() === 'many'){
            throw new \LogicException('code generation for add/remove not implemented');
        }
        else{
            $source[] = sprintf(
                '%spublic function set%s(%s $%s = null): self',
                self::SOURCE_INDENTATION,
                $field->getMethodSuffix(),
                $field->getType(),
                $field->getPropertyName()
            );

            $source[] = sprintf('%s{', self::SOURCE_INDENTATION);
            $source[] = sprintf('%s$this->%s = $%s;', str_repeat(self::SOURCE_INDENTATION, 2), $field->getPropertyName(), $field->getPropertyName());
            $source[] = sprintf('%sreturn $this;', str_repeat(self::SOURCE_INDENTATION, 2));
            $source[] = sprintf('%s}', self::SOURCE_INDENTATION);
        }

        return implode("\n", $source);
    }

}