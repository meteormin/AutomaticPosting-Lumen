<?php

namespace App\Services\Kiwoom;

use App\Services\Service;
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
     * @return array|null
     */
    public function run(string $where, array $options): ?array
    {
        $option = $this->validate($where, $options);
        if(!is_null($this->sshConfig['password'])){
            $ssh = "sshpass -p {$this->sshConfig['password']} ssh -o StrictHostKeyChecking=no {$this->sshConfig['host']}";
        }else {
            $ssh = "ssh -i {$this->sshConfig['public_key']} {$this->sshConfig['host']} ";
        }

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
     * @return string
     *
     * @throws ApiErrorException
     */
    protected function validate(string $where, array $options): string
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
    protected function makeOption(string $where, Collection $options): string
    {
        if ($where == 'sector') {
            return "-m {$options->get('market')} -s {$options->get('sector')}";
        }

        if ($where == 'theme') {
            return "-t {$options->get('theme')}";
        }
    }
}
