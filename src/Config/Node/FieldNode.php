<?php

namespace Kyoushu\Conjuration\Config\Node;

class FieldNode extends AbstractConfigNode
{

    const REGEX_TYPE_ASSOC = '/^(?<type>(?<from>one|many)\-to\-(?<to>one|many)):(?<model_name>.+)$/';

    const ASSOC_TYPE_ONE_TO_ONE = 'one-to-one';
    const ASSOC_TYPE_ONE_TO_MANY = 'one-to-many';
    const ASSOC_TYPE_MANY_TO_MANY = 'many-to-many';
    const ASSOC_TYPE_MANY_TO_ONE = 'many-to-one';

    /**
     * @var string|null
     */
    protected $hash;

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getPropertyName(): string
    {
        $propertyName = $this->getName();
        $propertyName = preg_replace_callback('/_([^_])/', function(array $match){
            return strtoupper($match[1]);
        }, $propertyName);
        return $propertyName;
    }

    public function getClassNamePrefix(): string
    {
        return ucfirst($this->getPropertyName());
    }

    public function getMethodSuffix(): string
    {
        return $this->getClassNamePrefix();
    }

    public function getLabel(): string
    {
        return $this->data['label'];
    }

    public function getType(): string
    {
        return $this->data['type'];
    }

    public function isRequired(): bool
    {
        return $this->data['required'];
    }

    public function isAssociation(): bool
    {
        return preg_match(self::REGEX_TYPE_ASSOC, $this->getType());
    }

    public function getAssociationType(): ?string
    {
        if(!preg_match(self::REGEX_TYPE_ASSOC, $this->getType(), $match)) return null;
        return $match['type'];
    }

    public function getAssociationFrom(): ?string
    {
        if(!preg_match(self::REGEX_TYPE_ASSOC, $this->getType(), $match)) return null;
        return $match['from'];
    }

    public function getAssociationTo(): ?string
    {
        if(!preg_match(self::REGEX_TYPE_ASSOC, $this->getType(), $match)) return null;
        return $match['to'];
    }

    public function getAssociationModelName(): ?string
    {
        if(!preg_match(self::REGEX_TYPE_ASSOC, $this->getType(), $match)) return null;
        return $match['model_name'];
    }

    public function getHash(): string
    {
        if($this->hash) return $this->hash;
        $this->hash = md5(serialize($this->data));
        return $this->hash;
    }

}