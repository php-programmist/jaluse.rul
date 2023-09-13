<?php

namespace App\Controller\Mail;

use App\Request\CallbackFormRequest;
use App\Response\MailJsonResponse;
use App\Service\ConfigService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

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
    /**
     * @var Environment
     */
    protected $twig;
    private $recipients;
    private $headers;
    
    public function __construct(MailerInterface $mailer, ConfigService $config, MailJsonResponse $response,Environment $twig )
    {
        $this->mailer     = $mailer;
        $this->recipients = $config->get('mail.recipients', '');
        $from             = $config->get('mail.from', '');
        $this->response   = $response;
        $this->email      = (new TemplatedEmail())->from($from);
        if (strpos($this->recipients, ',') !== false) {
            $recipients = explode(',', $this->recipients);
            $recipients = array_map('trim', $recipients);
            $this->email->to(...$recipients);
        } else {
            $this->email->to($this->recipients);
        }
        $this->twig    = $twig;
        $this->headers = 'MIME-Version: 1.0' . "\r\n";
        $this->headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    }
    
    /**
     * @Route("/consultation", name="consultation",methods={"POST"})
     */
    public function consultation(CallbackFormRequest $request)
    {
        // $body = $this->twig->render('mail/callback/consultation.html.twig',(array)$request);
        // if (mail($this->recipients,"Заявка на консультацию",$body,$this->headers)) {
        //     return $this->response->success("Спасибо, отправлено!");
        // }
        //
        // return $this->response->fail(error_get_last());
    
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
        // $body = $this->twig->render('mail/callback/order.html.twig',(array)$request);
        // mail($this->recipients,"Новый заказ",$body,$this->headers);
        // return $this->response->success("Спасибо, отправлено!");
        $this->email
            ->subject("Новый заказ")
            ->htmlTemplate('mail/callback/order.html.twig')
            ->context((array)$request);
    
        $this->mailer->send($this->email);
    
        return $this->response->success("Спасибо, отправлено!");
    }
}
