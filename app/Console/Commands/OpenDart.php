<?php

namespace App\Console\Commands;

use App\Services\OpenDart\OpenDartService;
use Illuminate\Console\Command;

class OpenDart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opendart:corp-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'store open-dart corpCodes';

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
     * @param OpenDartService $openDart
     * @return int
     */
    public function handle(OpenDartService $openDart): int
    {
        $this->info('get corp-codes...');
        $openDart->saveCorpCodes();

        $this->info('success save corp-codes!');
        return 0;
    }
}
