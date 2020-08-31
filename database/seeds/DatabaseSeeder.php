<?php

use App\User;
use App\Post;
use App\Tag;
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

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->dropTables();
        factory(User::class,30)->create();
        factory(Post::class,500)->create();
        factory(Tag::class, 50)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function dropTables(){
        User::truncate();
        Post::truncate();
        Tag::truncate();
    }
}
