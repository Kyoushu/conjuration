<?php

namespace Kyoushu\Conjuration\CodeGenerator\Doctrine;

use Kyoushu\Conjuration\CodeGenerator\Exception\CodeGeneratorException;
use Kyoushu\Conjuration\CodeGenerator\GeneratorInterface;
use Kyoushu\Conjuration\Config\Config;
use Kyoushu\Conjuration\Config\Exception\ConfigException;
use Kyoushu\Conjuration\Config\Node\FieldNode;
use Tests\Kyoushu\Conjuration\CodeGenerator\Doctrine\PropertyGenerator;

class TraitGenerator implements GeneratorInterface
{

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var FieldNode[]|null
     */
    protected $traitFields;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return FieldNode[]
     * @throws ConfigException
     */
    public function getAllFields(): array
    {
        $fields = [];

        foreach($this->config->getModels() as $model){
            $fields = array_merge(
                $fields,
                array_values($model->getFields())
            );
        }

        return $fields;
    }

    /**
     * @param string $name
     * @return FieldNode
     * @throws CodeGeneratorException
     * @throws ConfigException
     */
    public function findTraitFieldByName(string $name): FieldNode
    {
        foreach($this->resolveTraitFields() as $traitField){
            if($traitField->getName() === $name) return $traitField;
        }
        throw new CodeGeneratorException(sprintf('"%s" is not a trait field', $name));
    }

    /**
     * @return FieldNode[]
     * @throws ConfigException
     */
    public function resolveTraitFields(): array
    {
        if($this->traitFields) return $this->traitFields;

        $fields = $this->getAllFields();

        $encounteredFieldHashes = [];
        $traitFieldHashes = [];

        $traitFields = [];

        foreach($fields as $field){
            $fieldHash = $field->getHash();
            if(in_array($fieldHash, $encounteredFieldHashes) && !in_array($fieldHash, $traitFieldHashes)){
                $traitFields[] = $field;
                $traitFieldHashes[] = $fieldHash;
            }
            $encounteredFieldHashes[] = $fieldHash;
        }

        $this->traitFields = $traitFields;
        return $traitFields;
    }

    /**
     * @param FieldNode $field
     * @return bool
     * @throws ConfigException
     */
    public function isFieldTrait(FieldNode $field): bool
    {
        foreach($this->resolveTraitFields() as $traitField){
            if($traitField->getHash() === $field->getHash()) return true;
        }
        return false;
    }

    /**
     * @param FieldNode $field
     * @return string
     */
    public function resolveTraitClassName(FieldNode $field): string
    {
        return sprintf('%sTrait', $field->getClassNamePrefix());
    }

    /**
     * @return string
     * @throws ConfigException
     */
    public function getTraitNamespace(): string
    {
        return sprintf('%s\\Entity\\Traits', $this->config->getAppNamespace());
    }

    /**
     * @param string $fieldName
     * @return string
     * @throws CodeGeneratorException
     * @throws ConfigException
     */
    public function generate(string $fieldName): string
    {
        $field = $this->findTraitFieldByName($fieldName);

        $source = [];

        $source[] = '<?php';
        $source[] = '';

        $source[] = sprintf('namespace %s;', $this->getTraitNamespace());
        $source[] = '';

        $source[] = sprintf('trait %s', $this->resolveTraitClassName($field));
        $source[] = '{';
        $source[] = '';

        $propertyGenerator = new PropertyGenerator($this->config);

        $source[] = $propertyGenerator->generateProperty($field);
        $source[] = '';

        $source[] = $propertyGenerator->generateGettersSetters($field);
        $source[] = '';

        $source[] = '}';
        $source[] = '';

        return implode("\n", $source);
    }

}