<?php

namespace Kyoushu\Conjuration\Config\Node;

class ControllerNode extends AbstractConfigNode
{

    public function isIndexEnabled(): bool
    {
        return $this->data['index'];
    }

    public function isShowEnabled(): bool
    {
        return $this->data['show'];
    }

}