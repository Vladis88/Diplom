<?php

namespace App\DataFixtures\User;

use App\Entity\User\SubscriptionService;
use App\Service\Delivery\DeliveryInterface;
use App\Service\Delivery\MailNotificationService;
use App\Service\Delivery\PushNotificationService;
use App\Service\Delivery\SmsNotificationService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SubscriptionServicesFixture
 * @package App\DataFixtures\User
 */
class SubscriptionServicesFixture extends Fixture
{
    /**
     * @inheritDoc
     *
     * @throws \ReflectionException
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var \ReflectionClass[]
         */
        $services = array(
            new \ReflectionClass(MailNotificationService::class),
            new \ReflectionClass(PushNotificationService::class),
            new \ReflectionClass(SmsNotificationService::class)
        );

        foreach ($services as $service) {
            $subService = new SubscriptionService();
            $subService
                ->setTitle(null)
                ->setTag($service->getConstant('LOCAL_SERVICE_TAG'));

            $manager->persist($subService);
        }

        $manager->flush();
    }
}
