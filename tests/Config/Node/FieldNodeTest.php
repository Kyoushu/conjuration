<?php

namespace Tests\Kyoushu\Conjuration\Config\Node;

use Kyoushu\Conjuration\Config\Node\FieldNode;
use PHPUnit\Framework\TestCase;

class FieldNodeTest extends TestCase
{

    public function testGetters()
    {

        $node = new FieldNode([
            'name' => 'foo',
            'label' => 'Foo',
            'type' => 'string',
            'required' => true
        ]);

        $this->assertEquals('foo', $node->getName());
        $this->assertEquals('Foo', $node->getLabel());
        $this->assertEquals('string', $node->getType());
        $this->assertTrue($node->isRequired());


    }

}