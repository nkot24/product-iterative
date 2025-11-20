<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_index_displays_all_products()
    {
        $products = Product::factory()->count(5)->create();

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    /** @test */
    public function test_create_displays_form()
    {
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertSee('Jauns produkts');
    }

    /** @test */
    public function test_store_creates_a_product()
    {
        $data = [
            'name' => 'Test Produkts',
            'description' => 'Apraksts',
            'price' => 10.5,
            'quantity' => 5,
            'expiration_date' => now()->addMonth()->toDateString(),
            'status' => 'available',
        ];

        $response = $this->post(route('products.store'), $data);

        $this->assertDatabaseHas('products', ['name' => 'Test Produkts']);
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function test_show_displays_product_details()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function test_edit_displays_product_edit_form()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.edit', $product));

        $response->assertStatus(200);
        $response->assertSee('Rediģēt produktu');
        $response->assertSee($product->name);
    }

    /** @test */
    public function test_update_modifies_existing_product()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => 'Updated Produkts',
            'description' => 'Jauns apraksts',
            'price' => 20,
            'quantity' => 10,
            'expiration_date' => now()->addMonth()->toDateString(),
            'status' => 'unavailable',
        ];

        $response = $this->put(route('products.update', $product), $data);

        $this->assertDatabaseHas('products', ['name' => 'Updated Produkts']);
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');
    }

    /** @test */
    public function test_destroy_deletes_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');
    }
}
