<?php

namespace Kyoushu\Conjuration\Config\Node;

abstract class AbstractConfigNode
{

    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

}