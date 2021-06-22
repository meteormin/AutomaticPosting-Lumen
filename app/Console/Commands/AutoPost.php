<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\WordPress\WpPostService;
use Illuminate\Console\Command;
use App\Services\Main\PostsService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JsonMapper_Exception;

class AutoPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autopost {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto store post';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param PostsService $posts
     * @return int
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function handle(PostsService $posts): int
    {
        if (is_null($this->argument('name'))) {
            $this->error('name parameter is requried');
            return 1;
        }

        $name = $this->argument('name');

        // basic
        $this->info('[Basic] auto post: ' . $name);
        $user = User::find(1);
        $postId = $posts->autoPost($name, $user->id, $user->email);
        $this->info('success post...');
        $this->info('post id: ' . $postId);

        return 0;
    }
}
