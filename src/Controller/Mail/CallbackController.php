<?php

namespace App\Controller\Mail;

use App\Request\CallbackFormRequest;
use App\Response\MailJsonResponse;
use App\Service\ConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @Route("/callback", name="callback_")
 */
class CallbackController extends AbstractController
{
    /**
     * @var MailerInterface
     */
    protected $mailer;
    /**
     * @var MailJsonResponse
     */
    protected $response;
    /**
     * @var TemplatedEmail
     */
    protected $email;
    
    public function __construct(MailerInterface $mailer, ConfigService $config, MailJsonResponse $response)
    {
        $this->mailer   = $mailer;
        $recipients     = $config->get('mail.recipients', '');
        $from           = $config->get('mail.from', '');
        $this->response = $response;
        $this->email    = (new TemplatedEmail())->from($from);
        if (strpos($recipients, ',') !== false) {
            $recipients = explode(',', $recipients);
            $recipients = array_map('trim', $recipients);
            $this->email->to(...$recipients);
        } else {
            $this->email->to($recipients);
        }
        
    }
    
    /**
     * @Route("/consultation", name="consultation",methods={"POST"})
     */
    public function consultation(CallbackFormRequest $request)
    {
        
        $this->email
            ->subject("Заявка на консультацию")
            ->htmlTemplate('mail/callback/consultation.html.twig')
            ->context((array)$request);
        
        $this->mailer->send($this->email);
        
        return $this->response->success("Спасибо, отправлено!");
    }
    
    /**
     * @Route("/order", name="order", methods={"POST"})
     */
    public function order(CallbackFormRequest $request)
    {
        $this->email
            ->subject("Новый заказ")
            ->htmlTemplate('mail/callback/order.html.twig')
            ->context((array)$request);
        
        $this->mailer->send($this->email);
        
        return $this->response->success("Спасибо, отправлено!");
    }
}
