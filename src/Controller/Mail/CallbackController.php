<?php

namespace App\Controller\Mail;

use App\Request\CallbackFormRequest;
use App\Response\MailJsonResponse;
use App\Service\TelegramApiManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/callback", name="callback_")
 */
class CallbackController extends AbstractController
{
    /**
     * @var MailJsonResponse
     */
    protected $response;
    /**
     * @var Environment
     */
    protected $twig;
    
    public function __construct(
        MailJsonResponse $response,
        Environment $twig,
        private TelegramApiManager $telegramApiManager,
    ) {
        $this->response   = $response;
        $this->twig    = $twig;
    }
    
    /**
     * @Route("/consultation", name="consultation",methods={"POST"})
     */
    public function consultation(CallbackFormRequest $request)
    {
        if (!$this->isCsrfTokenValid('consultation', $request->token)) {
            return $this->response->fail(['Обновите страницу и повторите отправку']);
        }
    
        $this->telegramApiManager->sendAdminMessage('telegram/callback/consultation.html.twig', (array)$request);
    
        return $this->response->success("Спасибо, отправлено!");
    }
    
    /**
     * @Route("/order", name="order", methods={"POST"})
     */
    public function order(CallbackFormRequest $request)
    {
        if (!$this->isCsrfTokenValid('consultation', $request->token)) {
            return $this->response->fail(['Обновите страницу и повторите отправку']);
        }
    
        $this->telegramApiManager->sendAdminMessage('telegram/callback/order.html.twig', (array)$request);
    
        return $this->response->success("Спасибо, отправлено!");
    }
}
