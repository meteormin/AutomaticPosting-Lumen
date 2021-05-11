<?php

namespace App\Services\Kiwoom;

use App\Services\Service;
use App\Response\ErrorCode;
use Illuminate\Support\Collection;
use App\Exceptions\ApiErrorException;

class Windows extends Service
{
    /**
     * @var array
     */
    protected $sshConfig;

    public function __construct()
    {
        $this->sshConfig = config('winssh');
    }

    /**
     * Undocumented function
     *
     * @param string $where
     * @param array $options
     *
     * @return array
     */
    public function run(string $where, array $options)
    {
        $option = $this->validate($where, $options);

        $ssh = "ssh -i {$this->sshConfig['public_key']} {$this->sshConfig['host']} ";

        $python = "'{$this->sshConfig['command']} {$option}'";

        $output = null;

        exec($ssh . $python, $output);

        return $output;
    }

    /**
     * Undocumented function
     *
     * @param string $where
     * @param array $options
     *
     * @return string|void
     *
     * @throws ApiErrorException
     */
    protected function validate(string $where, array $options)
    {
        $options = collect($options);

        if ($where == 'sector') {
            if ($options->has('market') && $options->has('sector')) {
                return $this->makeOption($where, $options);
            }

            $this->throw(self::VALIDATION_FAIL, ['market' => ['required'], 'sector' => ['required']]);
        }

        if ($where == 'theme') {
            if ($options->has('theme')) {
                return $this->makeOption($where, $options);
            }

            $this->throw(self::VALIDATION_FAIL, ['theme' => ['required']]);
        }
    }

    /**
     * Undocumented function
     *
     * @param string $where
     * @param Collection $options
     *
     * @return string
     */
    protected function makeOption(string $where, Collection $options)
    {
        if ($where == 'sector') {
            return "-m {$options->get('market')} -s {$options->get('sector')}";
        }

        if ($where == 'theme') {
            return "-t {$options->get('theme')}";
        }
    }
}
