<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::factory()->count(10)->has(Ticket::factory()->has(Category::factory()->count(2))->has(Label::factory()->count(2))->count(5), 'ticketsUser')->create();
        User::factory()->count(5)->create(['role'=>'agent']);
        User::factory()->count(1)->create(['role'=>'admin']);
    }
}
