<?php

namespace App\Services\Telegram;

use App\Enums\Telegram\TelegramMethodEnum;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Validator;

class TelegramService
{
    /**
     * In config `bots`
     *
     * @var string|null
     */
    protected ?string $bot = null;

    /**
     * @var string|null
     */
    protected ?string $token = null;

    /**
     * @param Client $client
     */
    public function __construct(
        protected Client $client
    ) {
        $this->bot = config('telegram.default');
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return object|null
     * @throws Exception
     */
    public function __call(string $name, array $arguments = [])
    {
        $method = TelegramMethodEnum::tryFrom($name);

        if (is_null($method)) {
            throw new Exception('Method not found');
        }

        Validator::make($arguments[0] ?? [],
            $method->validateRules(),
        )->validate();

        return $this->request($method->getMethod(), $arguments[0] ?? []);
    }

    /**
     * @param string $method
     * @param array  $body
     * @return object|null
     */
    protected function request(string $method, array $body = []): ?object
    {
        try {
            $response = $this->client->request('POST',
                'https://api.telegram.org/bot' . $this->getToken() . '/' . $method, [
                    RequestOptions::FORM_PARAMS => $body,
                    RequestOptions::TIMEOUT => 2,
                ]);

            return json_decode($response->getBody()->getContents(), false);
        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), false);
        } catch (Exception|GuzzleException $e) {
            report($e);

            return null;
        }
    }

    /**
     * @return string
     */
    protected function getToken(): string
    {
        return $this->token ?? $this->config('token');
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param string|null $key
     * @param mixed|null  $default
     * @return mixed
     */
    public function config(?string $key = null, mixed $default = null): mixed
    {
        return config('telegram.bots.' . $this->bot . (!empty($key) ? ('.' . $key) : ''), $default);
    }

    /**
     * @return string
     */
    public function getBot(): string
    {
        if (is_null($this->bot)) {
            $this->setBot(config('telegram.default'));
        }

        return $this->bot;
    }

    /**
     * @param string $bot
     * @return $this
     */
    public function setBot(string $bot): self
    {
        $this->bot = $bot;

        return $this;
    }
}