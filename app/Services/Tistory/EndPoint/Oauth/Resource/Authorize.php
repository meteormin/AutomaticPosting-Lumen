<?php


namespace App\Services\Tistory\EndPoint\Oauth\Resource;


use App\Services\Tistory\Crawl\Wrapper;
use Exception;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Miniyus\RestfulApiClient\Api\EndPoint\AbstractSubClient;

class Authorize extends AbstractSubClient
{
    /**
     * @param string $clientId
     * @param string $redirectUri
     * @param string $responseType
     * @param string $state
     * @return array|mixed|string|null
     * @throws Exception
     */
    public function request(string $clientId, string $redirectUri, string $responseType, string $state)
    {
        $driver = Wrapper::newDriver();
        Log::info('start webdriver');

        $driver->get($this->url . '?' . Arr::query([
                'client_id' => $clientId, 'redirect_uri' => $redirectUri, 'response_type' => $responseType, 'state' => $state
            ]));

        try {
            $element = $driver->findElement(WebDriverBy::className(config('webdriver.kakao_login.confirm_btn.className')));
            $element->click();
            $url = $driver->getCurrentURL();
        } catch (NoSuchElementException $e) {
            Log::warning('no such' . config('webdriver.kakao_login.confirm_btn.className') . ': ' . $driver->getCurrentURL());
        }

        try {
            $driver->findElement(WebDriverBy::className(config('webdriver.kakao_login.link_kakao_id.className')))->click();
            Log::info('redirect kakao login: ' . $driver->getCurrentURL());
        } catch (NoSuchElementException $e) {
            Log::warning('fail redirect kakao login: ' . $driver->getCurrentURL());
        }

        try {
            $driver->get($driver->getCurrentURL());

            Log::info('req: ' . $driver->getCurrentURL());
        } catch (NoSuchElementException | TimeoutException $e) {
            Log::warning($e->getMessage());
        }

        Log::info('sleep 3s');
        sleep(3);

        $driver->findElement(WebDriverBy::id(config('webdriver.kakao_login.email_input.id')))
            ->sendKeys(config('webdriver.kakao_login.email_input.parameter'));
        Log::info('input email');
        Log::info('sleep 3s');
        sleep(3);

        $driver->findElement(WebDriverBy::id(config('webdriver.kakao_login.pass_input.id')))
            ->sendKeys(config('webdriver.kakao_login.pass_input.parameter'));
        Log::info('input password');
        Log::info('sleep 3s');
        sleep(3);

        $driver->findElement(WebDriverBy::className(config('webdriver.kakao_login.login_submit.className')))->click();
        Log::info('submit login form');
        Log::info('sleep 3s');
        sleep(3);

        try {
            $driver->findElement(WebDriverBy::className(config('webdriver.kakao_login.confirm_btn.className')))->click();
            Log::info('success login: ' . $driver->getCurrentURL());
        } catch (NoSuchElementException $e) {
            Log::warning('fail login: ' . $driver->getCurrentURL());
        }

        $url = $driver->getCurrentURL();

        $driver->close();
        Log::info('close webdriver');

        return $this->response(Http::get($url));
    }

}
