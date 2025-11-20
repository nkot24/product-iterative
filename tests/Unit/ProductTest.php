<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class ProductTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_increase_quantity()
    {
        $product = Product::factory()->create(['quantity' => 5]);

        $product->increaseQuantity(3);

        $this->assertEquals(8, $product->quantity);
    }

    #[Test]
    public function it_can_decrease_quantity_and_not_go_below_zero()
    {
        $product = Product::factory()->create(['quantity' => 5]);

        $product->decreaseQuantity(3);
        $this->assertEquals(2, $product->quantity);

        $product->decreaseQuantity(5);
        $this->assertEquals(0, $product->quantity); // Should not go negative
    }
}
