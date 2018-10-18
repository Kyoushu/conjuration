<?php

namespace Kyoushu\Conjuration\Config\Node;

class ModelNode extends AbstractConfigNode
{

    protected $fields;

    /**
     * @var ControllerNode|null
     */
    protected $controller;

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
     * @return ControllerNode
     */
    public function getController(): ControllerNode
    {
        if($this->controller) return $this->controller;
        $this->controller = new ControllerNode($this->data['controller']);
        return $this->controller;
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