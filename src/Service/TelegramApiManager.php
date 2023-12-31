<?php

namespace App\Service;

use App\Model\GuzzleClientFactory\GuzzleClientFactoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class TelegramApiManager
{
    private const WEBHOOK_TOKEN = 'd7OseZ2pViJL1vCls5rnb95dxHU1OQcR';
    
    /**
     * @param RouterInterface              $router
     * @param GuzzleClientFactoryInterface $clientFactory
     * @param Environment                  $twig
     * @param string                       $telegramBotToken
     * @param string                       $adminChatId
     */
    public function __construct(
        private RouterInterface $router,
        private GuzzleClientFactoryInterface $clientFactory,
        private Environment $twig,
        private string $telegramBotToken,
        private string $adminChatId,
        private string $baseHost,
    ) {
    
    }
    
    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function setupWebhook(): string
    {
        $url      = 'https://' . $this->baseHost . $this->router->generate('webhook_telegram', [
                'token' => self::WEBHOOK_TOKEN,
            ]);
        $client   = $this->getClient();
        $response = $client->post($this->getFullEndpointUrl('/setWebhook'), [
            'body'    => json_encode([
                'url' => $url,
            ], JSON_THROW_ON_ERROR),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
        $result   = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    
        return $result['description'];
    }
    
    /**
     * @param array<string, mixed> $update
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function handleStart(array $update): void
    {
        $text = $update['message']['text'] ?? '';
        
        if ('/start' !== $text) {
            return;
        }
        
        $chatId = $update['message']['chat']['id'] ?? throw new BadRequestException('Не удалось получить ID чата');
        
        $this->sendMessage($chatId, sprintf('ID чата: <strong>%s</strong>', $chatId));
    }
    
    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendMessage(?string $chatId, string $text): void
    {
        if (null === $chatId) {
            return;
        }
        $client = $this->getClient();
        
        $client->request('POST', $this->getFullEndpointUrl('/sendMessage'), [
            'body'    => json_encode([
                'chat_id'                  => $chatId,
                'text'                     => $text,
                'parse_mode'               => 'HTML',
                'disable_web_page_preview' => true,
            ], JSON_THROW_ON_ERROR),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }
    
    public function sendAdminMessage(string $templateName, array $data): void
    {
        $text = $this->twig->render($templateName, $data);
        $this->sendMessage($this->adminChatId, $text);
    }
    
    private function getClient(): Client
    {
        return $this->clientFactory->create();
    }
    
    public function verifyWebhookToken(string $token): void
    {
        if ($token !== self::WEBHOOK_TOKEN) {
            throw new AccessDeniedHttpException();
        }
    }
    
    private function getFullEndpointUrl(string $relativeUri): string
    {
        $relativeUri = ltrim($relativeUri, '/');
        
        return sprintf("https://api.telegram.org/bot%s/%s", $this->telegramBotToken, $relativeUri);
    }
    
}