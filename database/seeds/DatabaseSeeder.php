<?php

use App\Author;
use App\Collaborator;
use App\User;
use App\Post;
use App\Tag;
use App\Image;
use App\Partner;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    public $imageCount;
    public $users = 30;
    public $posts = 500;
    public $tags = 50;

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
        factory(Collaborator::class, (int)($this->users/2))->create();
        factory(Partner::class, (int)($this->users/3))->create();
        $this->tagAuthors((int)($this->users/2));
        $this->tagPosts((int)($this->posts/2));
        $this->imageAuthors();
        $this->imagePosts();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function imagePosts()
    {
        $posts = Post::all();
        $carousel = Image::where('name', '=', '770_380.jpg')->first();
        $gallery = Image::where('name', '=', '185_160.jpg')->first();
        $side = Image::where('name', '=', '80_70.jpg')->first();
        $front_one = Image::where('name', '=', '400_430.jpg')->first();
        $front_two = Image::where('name', '=', '270_200.jpg')->first();
        $banner = Image::where('name', '=', '770_380.jpg')->first();
        foreach($posts as $post)
        {
            for($i=0; $i< rand(1,5); $i++)
            {
                $post->images()->save($carousel,['position'=>'carousel']);
            }

            for($i=0; $i< rand(1,9); $i++)
            {
                $post->images()->save($gallery,['position'=>'gallery']);
            }
            $post->images()->save($side,['position'=>'sidebar']);
            $post->images()->save($front_one,['position'=>'front carousel one']);
            $post->images()->save($front_two,['position'=>'front carousel two']);
            $post->images()->save($banner,['position'=>'banner']);
        }
    }


    public function imageAuthors()
    {
        $image = Image::where('name', '=', '100_100.jpg')->first();
        $authors = Author::all();
        foreach($authors as $author) {
            $author->images()->sync($image, ['position'=>'avatar']);
        }
    }


    public function tagPosts($count)
    {
        for($i=0; $i< $count; $i++)
        {
            $post = Post::whereDoesntHave('tags')->first();
            $tags = Tag::inRandomOrder()->pluck('id')->take(rand(1,8))->toArray();
            $post->tags()->sync($tags);
        }
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
        Partner::truncate();
        DB::table('taggables')->truncate();
        DB::table('imageables')->truncate();

    }
}
