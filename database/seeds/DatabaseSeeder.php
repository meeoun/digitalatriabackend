<?php

use App\User;
use App\Post;
use App\Tag;
use App\Image;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    public $imageCount;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->dropTables();
        $this->countImages();
        factory(User::class,30)->create();
        factory(Post::class,500)->create();
        factory(Tag::class, 50)->create();
        factory(Image::class,$this->imageCount)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }


    public function countImages()
    {
        $this->imageCount = \Illuminate\Support\Facades\File::files(public_path().'/upload/news-posts/');
        $this->imageCount = count($this->imageCount);
    }

    public function dropTables(){
        User::truncate();
        Post::truncate();
        Tag::truncate();
        Image::truncate();

    }
}
