<?php

namespace App\Entity\DependencyInjection\Compiler;

use App\Service\Delivery\DeliveryInterface;
use App\Service\SubscriptionResolverService;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class DeliveryServicesPath
 */
class DeliveryServicesPath implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(SubscriptionResolverService::class)) {
            return;
        }

        $resolverService = $container->findDefinition(SubscriptionResolverService::class);

        foreach (array_keys($container->findTaggedServiceIds(DeliveryInterface::DELIVERY_TAG)) as $serviceId) {
            $resolverService->addMethodCall('addDeliveryService', [new Reference($serviceId)]);
        }
    }
}
