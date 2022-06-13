<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Turnover\Base\Traits\HasTransformerTrait;

class HasTransformerTraitTest extends TestCase {

    use HasTransformerTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_has_transformer_trait_without_content()
    {
        $this->assertNull($this->applyTransform(null, false));
        $this->assertEquals(['data' => []], $this->applyTransform(null));
    }
}
