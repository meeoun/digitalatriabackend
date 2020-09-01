<?php

use App\Author;
use App\Collaborator;
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
        factory(Collaborator::class, 100)->create();
        $this->tagAuthors(15);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }


    

    public function tagAuthors(int $count)
    {
        for($i=0; $i< $count; $i++)
        {
            $author = Author::whereDoesntHave('tags')->first();
            $tags = Tag::inRandomOrder()->pluck('id')->take(rand(1,6))->toArray();
            $author->tags()->sync($tags);
        }
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
        Collaborator::truncate();
        DB::table('taggables')->truncate();

    }
}
