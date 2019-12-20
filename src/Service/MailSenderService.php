<?php

namespace App\Service;

use Swift_Attachment;
use Swift_Mailer;
use Twig\Environment;

class MailSenderService
{
    /**
     * @var Swift_Mailer
     */
    protected $mailer;
    /**
     * @var Environment
     */
    protected $twig;
    
    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        
        $this->mailer = $mailer;
        $this->twig   = $twig;
    }
    
    /**
     * @param array|string $to
     * @param string       $subject
     * @param string       $template
     * @param array        $data
     * @param null         $from
     * @param array        $attachments
     *
     * @return int
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendMail($to, string $subject, string $template, array $data, $from=null,$attachments=[])
    {
        
        $message = (new \Swift_Message($subject))
            ->setTo($to)
            ->setBody(
                $this->twig->render(
                    $template,
                    $data
                ),
                'text/html'
            );
        if ( ! empty($from)) {
            $message->setFrom($from);
        }
        if (!empty($attachments)) {
            foreach ($attachments as $file) {
                $message->attach(Swift_Attachment::fromPath($file->getRealPath())->setFilename($file->getClientOriginalName()));
            }
        }
        return $this->mailer->send($message);
    }
}