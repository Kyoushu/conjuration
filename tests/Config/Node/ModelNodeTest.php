<?php

namespace Tests\Kyoushu\Conjuration\Config\Node;

use Kyoushu\Conjuration\Config\Node\ModelNode;
use PHPUnit\Framework\TestCase;

class ModelNodeTest extends TestCase
{

    public function testGetters()
    {
        $node = new ModelNode([
            'name' => 'foo',
            'label' => 'Foo',
            'url_prefix' => '/foo',
            'single' => false,
            'fields' => [
                [
                    'name' => 'bar',
                    'type' => 'string',
                    'label' => 'Bar',
                    'required' => true
                ]
            ]
        ]);

        $this->assertEquals('foo', $node->getName());
        $this->assertEquals('Foo', $node->getLabel());
        $this->assertEquals('/foo', $node->getUrlPrefix());
        $this->assertEquals(false, $node->isSingle());
        $this->assertCount(1, $node->getFields());
    }

}