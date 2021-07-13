<?php

namespace App\Services\WordPress;

use App\Data\DataTransferObjects\WpMedia;
use App\Data\DataTransferObjects\WPosts;
use App\Libraries\Client;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WpClient extends Client
{
    /**
     * @var string|array|mixed|null
     */
    protected ?string $host;

    /**
     * MediumClient constructor.
     */
    public function __construct()
    {
        parent::__construct(config('wordpress.host'));
    }

    /**
     * @return array|string
     */
    public function auth()
    {
        $response = Http::post($this->getHost() . '/wp-json/jwt-auth/v1/token', [
            'username' => config('wordpress.id'),
            'password' => config('wordpress.pwd')
        ]);

        return $this->response($response);
    }

    /**
     * @param WPosts $input
     * @return array|string
     */
    public function posts(WPosts $input)
    {
        $auth = $this->auth();

        $response = $this->response(Http::withToken($auth['token'])->post($this->getHost() . '/wp-json/wp/v2/posts', $input->toArray()));

        if (is_null($response)) {
            return $this->getError();
        }

        return $response;
    }

    /**
     * @param WpMedia $input
     * @return array|string|null
     * @throws FileNotFoundException
     */
    public function uploadMedia(WpMedia $input)
    {
        $auth = $this->auth();
        $attach = $input->getContent();

        $response = $this->response(
            Http::withHeaders([
            'Content-Disposition' => 'attachment; filename=' . $input->getTitle() . Carbon::now()->timestamp . '.png'
        ])
            ->withToken($auth['token'])
            ->withBody(Storage::disk('local')->get($attach), 'image/png')
            ->post($this->getHost() . '/wp-json/wp/v2/media')
        );

        if (is_null($this->response)) {
            return $this->getError();
        }

        return $response;
    }
}
