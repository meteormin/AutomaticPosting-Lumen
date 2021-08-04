<?php


namespace App\Libraries\HtmlToImage;


use App\Libraries\HtmlToImage\Contracts\Capture;
use App\Libraries\HtmlToImage\Contracts\HtmlToImage;

class WkHtmlToImage implements Capture
{
    protected HtmlToImage $config;

    protected array $response;

    /**
     * @param array $config
     * @return HtmlToImage|WkHtmlToImageConfig
     */
    public function config(array $config = [])
    {
        if (empty($config)) {
            return $this->config;
        }

        return $this->config->setFromArray($config);
    }

    /**
     * @param array $config
     * @return static
     */
    public static function newInstance(array $config = []): WkHtmlToImage
    {
        return new static($config);
    }

    /**
     * WkHtmlToImage constructor.
     */
    public function __construct(array $config = [])
    {
        $this->config = new WkHtmlToImageConfig($config);
    }

    public function capture(): array
    {
        $this->response['response'] = [];
        $command = $this->makeCommand([
            $this->config->getCommand(),
            $this->config->getHost(),
            $this->config->getPort(),
            $this->config->getPath(),
            $this->config->getSaveFile()
        ]);

        exec($command, $response, $code);

        $this->response = [
            'code' => $code,
            'response' => $response
        ];

        return $this->response;
    }

    protected function makeCommand(array $command): string
    {
        $rs = '';
        foreach ($command as $v) {
            $rs .= $v . ' ';
        }

        return trim($rs);
    }
}
