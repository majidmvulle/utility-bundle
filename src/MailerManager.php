<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class MailerManager.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class MailerManager
{
    /**
     * @var string
     */
    private $env;

    /**
     * @var
     */
    private $templating;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $fromSenderEmailAddress;

    /**
     * @var string
     */
    private $fromSenderName;

    public function __construct(KernelInterface $kernel, TwigEngine $templating, \Swift_Mailer $mailer, $fromSenderEmail, $fromSenderName)
    {
        $this->env = $kernel->getEnvironment();
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->fromSenderEmailAddress = $fromSenderEmail;
        $this->fromSenderName = $fromSenderName;
    }

    /**
     * @param string|array $to
     * @param string       $subject
     * @param string       $template
     * @param array        $parameters
     * @param mixed        $mimeType
     *
     * @throws \Exception
     * @throws \Twig_Error
     */
    public function sendByTemplate(mixed $to, $subject, $template, $parameters = [], $mimeType = 'text/html'): void
    {
        $this->send($to, $subject, $this->templating->render($template, $parameters), $mimeType);
    }

    public function send($to, $subject, $content, $mimeType = 'text/plain'): void
    {
        if ('prod' !== $this->env) {
            return;
        }

        if (!is_array($to)) {
            $to = [$to];
        }

        $message = new \Swift_Message();
        $message->setSubject($subject)
            ->setFrom([$this->fromSenderEmailAddress], [$this->fromSenderName])
            ->setTo($to)
            ->setBody($content, $mimeType);

        $this->mailer->send($message);
    }
}
