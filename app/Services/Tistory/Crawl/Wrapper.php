<?php


namespace App\Services\Tistory\Crawl;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class Wrapper
{
    /**
     * @var RemoteWebDriver
     */
    protected RemoteWebDriver $driver;

    public function __construct()
    {
        $des = DesiredCapabilities::chrome();
        $opt = new ChromeOptions();
        $opt->addArguments(['headless']);
        $des->setCapability(ChromeOptions::CAPABILITY, $opt);
        $this->driver = RemoteWebDriver::create('http://localhost:4444', $des);
    }

    /**
     * @return RemoteWebDriver
     */
    public function driver(): RemoteWebDriver
    {
        return $this->driver;
    }

    /**
     * @return RemoteWebDriver
     */
    public static function newDriver(): RemoteWebDriver
    {
        return (new static())->driver;
    }

}
