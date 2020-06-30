<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('tags')->insert([
            ['name' => 'books'],
            ['name' => 'audio-books'],
            ['name' => 'articles'],
            ['name' => 'podcasts'],
            ['name' => 'films'],
            ['name' => 'serials'],
            ['name' => 'video-self-dev'],
            ['name' => 'anime'],
        ]);
    }
}
