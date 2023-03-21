<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        User::factory(4)->create();        
        $user = User::factory()->create([            
            'name'=> 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('123456'),
        ]);        

        $category = Category::factory()->create(['name' => 'CAT-1']);   
        

        Todo::factory(3)->create([
            'user_id' => $user->id,         
            'category_id' => $category->id,
        ]);

        $category = Category::factory()->create(['name' => 'CAT-2']);
        Todo::factory(4)->create([
            
            'user_id' => $user->id,         
            'category_id' => $category->id,
        ]);

        $category = Category::factory()->create(['name' => 'CAT-3']);
        Todo::factory(5)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }
}
