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

    public function testAssociationGetters()
    {
        $node = new FieldNode([
            'name' => 'foo',
            'label' => 'Foo',
            'type' => 'one-to-one:bar'
        ]);

        $this->assertTrue($node->isAssociation());
        $this->assertEquals(FieldNode::ASSOC_TYPE_ONE_TO_ONE, $node->getAssociationType());
        $this->assertEquals('bar', $node->getAssociationModelName());
    }

    public function testGetPropertyName()
    {
        $node = new FieldNode(['name' => 'foo_bar_baz']);
        $this->assertEquals('fooBarBaz', $node->getPropertyName());
    }

    public function testGetClassNamePrefix()
    {
        $node = new FieldNode(['name' => 'foo_bar_baz']);
        $this->assertEquals('FooBarBaz', $node->getClassNamePrefix());
    }

}