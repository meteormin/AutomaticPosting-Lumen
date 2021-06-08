<?php

namespace App\Console\Commands;

use App\Services\Kiwoom\Windows;
use Illuminate\Console\Command;

class Kiwoom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kiwoom:get {where : sector or theme} {--theme= : theme code} {--sector= : sector code} {--market= : market name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get stock info';

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
     * @return mixed
     */
    public function handle(Windows $runner)
    {
        $where = $this->argument('where');
        $options = json_encode($this->options(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $this->info("get stockinfo by {$where}: {$options}");

        $this->info('running...');

        $output = $runner->run($this->argument('where'), $this->options());

        $this->info(json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return 0;
    }
}
