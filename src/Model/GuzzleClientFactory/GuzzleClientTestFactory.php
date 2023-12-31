<?php

namespace App\Model\GuzzleClientFactory;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use JsonException;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

class GuzzleClientTestFactory implements GuzzleClientFactoryInterface
{
    /**
     * @var array<int, Response|BadResponseException>
     */
    public static array $responses = [];
    
    /**
     * @var array<int, array<string, mixed>>
     */
    public static array $transactions = [];
    
    /**
     * @param array<string, string> $config
     *
     * @return Client
     */
    public function create(array $config = []): Client
    {
        $callable     = static fn($value) => array_shift(self::$responses);
        $history      = Middleware::history(self::$transactions);
        $mock         = new MockHandler(self::$responses, $callable, $callable);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);
        $config = array_merge($config, ['handler' => $handlerStack]);
        
        return new Client($config);
    }
    
    public static function shiftRequest(): Request
    {
        $transaction = array_shift(self::$transactions);
        
        return $transaction['request'] ?? throw new RuntimeException('Запрос отсутствует');
    }
    
    public static function clearTransactions(): void
    {
        self::$transactions = [];
    }
    
    /**
     * @param int                                      $status  Код ответа
     * @param array<string, string|string[]>           $headers Заголовки ответа. Если не указан заголовок Content-Type, то будет установлен со значением application/json
     * @param StreamInterface|string|array<mixed>|null $body    Тело ответа
     *
     * @throws JsonException
     */
    public static function addResponse(
        int $status = 200,
        array $headers = [],
        StreamInterface|string|array $body = null,
    ): void {
        if (is_array($body)) {
            $body = json_encode($body, JSON_THROW_ON_ERROR);
        }
        $headers['Content-Type'] ??= 'application/json';
        self::$responses[]       = new Response($status, $headers, $body);
    }
    
    public static function addBadResponse(
        int $status,
        string $message = 'Bad Response',
    ): void {
        self::$responses[] = new BadResponseException($message, new Request('GET', 'https://test.com'),
            new Response($status, [], $message));
    }
}