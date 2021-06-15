<?php


namespace App\Console\Commands;


use App\Exceptions\ApiErrorException;
use App\Services\Main\MainService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JsonMapper_Exception;

class UpdateStockInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kiwoom:update {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update kiwoom stock data';

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
     * @param MainService $service
     * @return int
     * @throws FileNotFoundException
     * @throws JsonMapper_Exception
     */
    public function handle(MainService $service): int
    {
        $this->info('update:' . $this->argument('type'));
        $type = $this->argument('type');

        $list = [];
        if ($type == 'theme') {
            $list = config('themes.kospi.themes_raw');
        } else if ($type == 'sector') {
            $list = config('sectors.kospi.sectors_raw');
        } else {
            $this->error('type is enum(theme, sector)');
            return 1;
        }

        foreach (array_keys($list) as $code) {
            $service->updateStockInfo($type, $code);

            try {
                $service->updateOpenDart($type, $code);
            } catch (\Throwable $e) {
                $this->error($e->getMessage());
            }
            $this->info("$type: $code");
        }

        $this->info('success update!');
        return 0;
    }
}
