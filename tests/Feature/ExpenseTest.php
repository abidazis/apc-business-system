<?php

namespace Tests\Feature;

use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
    }

    public function test_expense_can_be_created(): void
    {
        $category = ExpenseCategory::create(['name' => 'Bahan', 'slug' => 'bahan']);

        $this->actingAs($this->admin())
            ->post('/admin/expenses', [
                'date' => now()->format('Y-m-d'),
                'expense_category_id' => $category->id,
                'description' => 'Pembelian bahan baku',
                'amount' => 500000,
                'payment_method' => 'cash',
            ])
            ->assertRedirect('/admin/expenses');

        $this->assertDatabaseHas('expenses', ['description' => 'Pembelian bahan baku', 'amount' => 500000]);
    }

    public function test_expense_amount_must_be_positive(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/expenses', [
                'date' => now()->format('Y-m-d'),
                'description' => 'Test',
                'amount' => -100,
                'payment_method' => 'cash',
            ])
            ->assertSessionHasErrors('amount');
    }

    public function test_expense_category_can_be_created(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/expense-categories', [
                'name' => 'Marketing',
                'slug' => 'marketing',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('expense_categories', ['slug' => 'marketing']);
    }
}
