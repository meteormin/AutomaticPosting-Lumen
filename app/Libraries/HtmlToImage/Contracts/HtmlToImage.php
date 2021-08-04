<?php


namespace App\Libraries\HtmlToImage\Contracts;

interface HtmlToImage
{
    /**
     * @param string $host
     * @return HtmlToImage
     */
    public function host(string $host): HtmlToImage;

    /**
     * @param int $port
     * @return HtmlToImage
     */
    public function port(int $port): HtmlToImage;

    /**
     * @param string $path
     * @return HtmlToImage
     */
    public function path(string $path): HtmlToImage;

    /**
     * @param string $saveFile
     * @return HtmlToImage
     */
    public function saveFile(string $saveFile): HtmlToImage;

    /**
     * @param string $command
     * @return HtmlToImage
     */
    public function command(string $command): HtmlToImage;

    /**
     * @return string
     */
    public function getCommand(): string;

    /**
     * @return string
     */
    public function getHost(): string;

    /**
     * @return int
     */
    public function getPort(): int;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getSaveFile(): string;
}
