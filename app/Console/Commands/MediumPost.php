<?php


namespace App\Console\Commands;

use App\Services\Medium\MediumService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JsonMapper_Exception;

class MediumPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medium {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto store post to medium';

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
     * @param MediumService $service
     * @return int
     */
    public function handle(MediumService $service): int
    {
        if (is_null($this->argument('name'))) {
            $this->error('name parameter is requried');
            return 1;
        }

        $this->info('auto post: ' . $this->argument('name'));

        try {
            $res = $service->autoPost($this->argument('name'));
            $this->info('success post...');
            $this->info('response: ' . json_encode($res));
            return 0;

        } catch (FileNotFoundException | JsonMapper_Exception $e) {
            $this->error($e->getMessage());
        }

       return 1;
    }
}
