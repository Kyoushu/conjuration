<?php

namespace Kyoushu\Conjuration\Config\Node;

class FieldNode extends AbstractConfigNode
{

    public function getName(): string
    {
        return $this->data['name'];
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

}