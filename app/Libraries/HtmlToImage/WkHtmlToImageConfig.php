<?php


namespace App\Libraries\HtmlToImage;


use App\Libraries\HtmlToImage\Contracts\HtmlToImage;
use Illuminate\Support\Str;

class WkHtmlToImageConfig implements HtmlToImage
{
    protected string $command;

    protected string $host;

    protected int $port;

    protected string $path;

    protected string $saveFile;

    /**
     * WkHtmlToImageConfig constructor.
     */
    public function __construct(array $config = [])
    {
        $this->setFromArray($this->defaultConfig());

        $this->setFromArray($config);
    }

    public function setFromArray(array $config): WkHtmlToImageConfig
    {
        if (empty($config)) {
            $config = $this->defaultConfig();
        }

        foreach ($config as $key => $value) {
            $method = Str::studly($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getSaveFile(): string
    {
        return $this->saveFile;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function host(string $host): WkHtmlToImageConfig
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @param int $port
     * @return $this
     */
    public function port(int $port): WkHtmlToImageConfig
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function path(string $path): WkHtmlToImageConfig
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param string $saveFile
     * @return $this
     */
    public function saveFile(string $saveFile): WkHtmlToImageConfig
    {
        $this->saveFile = $saveFile;
        return $this;
    }

    /**
     * @param string $command
     * @return $this
     */
    public function command(string $command): WkHtmlToImageConfig
    {
        $this->command = $command;
        return $this;
    }

    /**
     * @return array
     */
    protected function defaultConfig(): array
    {
        return [
            'command' => 'wkthmltoimage',
            'host' => 'http://localhost',
            'port' => 80,
            'path' => '/',
            'save_file' => ''
        ];
    }
}
