<?php

namespace Kyoushu\Conjuration\Config\Node;

class ModelNode extends AbstractConfigNode
{

    protected $fields;

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getLabel(): string
    {
        return $this->data['label'];
    }

    public function getUrlPrefix(): ?string
    {
        return $this->data['url_prefix'];
    }

    public function isSingle(): bool
    {
        return $this->data['single'];
    }

    /**
     * @return FieldNode[]
     */
    public function getFields(): array
    {
        if($this->fields !== null) return $this->fields;

        $fields = [];
        foreach($this->data['fields'] as $data){
            $fields[] = new FieldNode($data);
        }
        $this->fields = $fields;
        return $fields;
    }

}