<?php

namespace App\Console\Commands;

use App\Services\OpenDart\OpenDartService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class OpenDart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kiwoom:get {where: sector or theme} {--theme: theme code} {--sector: sector code} {--market: market name}';

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
     * @return mixed
     */
    public function handle(OpenDartService $opendart)
    {
        $where = $this->argument('where');

        if ($where == 'sector') {
            $sector = $this->option('sector');
            $market = $this->options('market');
            if (is_null($sector)) {
                $this->error('options sector is required');
                return 1;
            }

            if (is_null($market)) {
                $market = 'kospi';
            }

            $command = "python main.py -m {$market} -s {$sector}";
        }

        if ($where == 'theme') {
            $theme = $this->option('theme');
            if (is_null($theme)) {
                $this->error('options theme is required');
                return 1;
            }

            $command = "python main.py -t {$theme}";
        }

        $this->info("get {$where}...");
    }
}
