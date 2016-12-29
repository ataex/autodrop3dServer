<?php

use App\Group;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new Post();
        $post->title = 'First Post in the Electronics Area';
        $post->body = 'This is the first post EVER on the new Spark website. You\'ll notice that everything is now well integrated and functional! You can see everything going on at Spark in the calendar and see what\'s happening in your favorite group! That\'s all for now.';
        $post->owner()->associate(User::whereUsername('johnsucks')->first());
        $post->post_time = time();
        $post->save();
        $post->groups()->attach(Group::whereName('Electronics')->first());

        $post = new Post();
        $post->title = 'Other Post';
        $post->body = 'This is NOT the first post EVER on the new Spark website.';
        $post->owner()->associate(User::whereUsername('mikesucks')->first());
        $post->post_time = time();
        $post->save();
        $post->groups()->attach(Group::whereName('3D Printing')->first());
    }
}