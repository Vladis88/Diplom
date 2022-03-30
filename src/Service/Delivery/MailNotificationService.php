<?php

namespace App\Service\Delivery;

use App\Model\TransferInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MailNotificationService
 */
class MailNotificationService implements DeliveryInterface
{
    /**
     * @var string
     */
    public const LOCAL_SERVICE_TAG = 'delivery.mail.service';

    /**
     * @var \Swift_Mailer
     */
    private \Swift_Mailer $mailer;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * MailNotificationService constructor.
     * @param \Swift_Mailer $mailer
     * @param ContainerInterface $container
     */
    public function __construct(
        \Swift_Mailer      $mailer,
        ContainerInterface $container
    )
    {
        $this->mailer = $mailer;
        $this->container = $container;
    }

    /**
     * @param TransferInterface $transfer
     */
    public function transfer(TransferInterface $transfer): void
    {
//        $user = $transfer->getUser();
//        $post = $transfer->getPost();
//
//        $swiftMessage = new \Swift_Message();
//        $swiftMessage
//            ->setFrom('feedback@rutasochi.ru')
//            ->setTo($user->getEmail())
//            ->setBody(
//                $this->container->get('twig')->render(
//                    'mail-notification.twig.html',
//                    \compact('post')
//                )
//            )
//            ->setContentType('text/html');
//
//        $this->mailer->send($swiftMessage);
    }
}
