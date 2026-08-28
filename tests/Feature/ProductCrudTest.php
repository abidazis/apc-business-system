<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
    }

    public function test_super_admin_can_create_product(): void
    {
        $cat = Category::create(['name' => 'Seragam', 'slug' => 'seragam']);
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post('/admin/products', [
                'name' => 'PDL Paskibra',
                'category_id' => $cat->id,
                'sku' => 'TEST-001',
                'short_description' => 'PDL latihan',
                'price_type' => 'contact',
                'is_published' => 1,
                'is_featured' => 1,
            ])
            ->assertRedirect('/admin/products')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('products', ['name' => 'PDL Paskibra', 'sku' => 'TEST-001']);
    }

    public function test_product_slug_is_generated(): void
    {
        $cat = Category::create(['name' => 'Atribut', 'slug' => 'atribut']);
        $this->actingAs($this->admin())
            ->post('/admin/products', [
                'name' => 'Topi Paskibra',
                'category_id' => $cat->id,
                'price_type' => 'contact',
                'is_published' => 1,
            ]);

        $this->assertDatabaseHas('products', ['slug' => 'topi-paskibra']);
    }

    public function test_product_can_be_soft_deleted(): void
    {
        $cat = Category::create(['name' => 'X', 'slug' => 'x']);
        $p = Product::create([
            'name' => 'Test', 'slug' => 'test', 'sku' => 'T-1',
            'price_type' => 'contact', 'category_id' => $cat->id,
        ]);
        $this->actingAs($this->admin())
            ->delete("/admin/products/{$p->id}")
            ->assertRedirect('/admin/products');

        $this->assertSoftDeleted('products', ['id' => $p->id]);
    }
}
