<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::withoutForeignKeyConstraints(function () {
            DB::table('users')->truncate();
            DB::table('categories')->truncate();
            DB::table('tags')->truncate();
            DB::table('posts')->truncate();
            DB::table('post_tag')->truncate();
            DB::table('images')->truncate();
        });

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            PostTagSeeder::class,
            ImageSeeder::class,
        ]);
    }
}
