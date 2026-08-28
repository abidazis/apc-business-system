<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders(): void
    {
        $this->get('/')->assertOk()->assertSee('APC');
    }

    public function test_products_page_renders(): void
    {
        $cat = Category::create(['name' => 'Seragam', 'slug' => 'seragam']);
        Product::create([
            'name' => 'Topi Test',
            'slug' => 'topi-test',
            'sku' => 'T-1',
            'price_type' => 'contact',
            'category_id' => $cat->id,
            'is_published' => true,
        ]);

        $this->get('/produk')->assertOk()->assertSee('Topi Test');
    }

    public function test_product_detail_renders_with_whatsapp_link(): void
    {
        $cat = Category::create(['name' => 'C', 'slug' => 'c']);
        $p = Product::create([
            'name' => 'Test Product',
            'slug' => 'test-product',
            'sku' => 'T-1',
            'price_type' => 'contact',
            'category_id' => $cat->id,
            'is_published' => true,
        ]);

        $this->get('/produk/test-product')
            ->assertOk()
            ->assertSee('Test Product')
            ->assertSee('wa.me', false);
    }

    public function test_draft_products_not_visible_publicly(): void
    {
        Product::create([
            'name' => 'Draft Product',
            'slug' => 'draft-product',
            'sku' => 'D-1',
            'price_type' => 'contact',
            'is_published' => false,
        ]);

        $this->get('/produk/draft-product')->assertNotFound();
    }

    public function test_about_faq_contact_pages_render(): void
    {
        $this->get('/tentang')->assertOk();
        $this->get('/faq')->assertOk();
        $this->get('/kontak')->assertOk();
    }
}
