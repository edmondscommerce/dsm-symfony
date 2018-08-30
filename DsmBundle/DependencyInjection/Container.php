<?php declare(strict_types=1);
/**
 * @category EdmondsCommerce
 * @package  EdmondsCommerce_
 * @author   Ross Mitchell <ross@edmondscommerce.co.uk>
 */

namespace EdmondsCommerce\DsmBundle\DependencyInjection;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use EdmondsCommerce\DoctrineStaticMeta\Config;
use EdmondsCommerce\DoctrineStaticMeta\Container as DsmContainer;
use EdmondsCommerce\DsmBundle\Doctrine\Common\EntityManagerFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class Container extends DsmContainer
{
    public function defineEntityManager(ContainerBuilder $container): void
    {
        $defaultConfiguration = new Reference('doctrine.orm.default_configuration');
        $container->autowire(EntityManagerFactory::class)
                  ->addArgument($defaultConfiguration);

        $entityManager = $this->getEntityManagerDefinition($container);
        $entityManager
            ->addArgument(new Reference(Config::class))
            ->setFactory(
                [
                    new Reference(EntityManagerFactory::class),
                    'getEntityManager',
                ]
            );
        $this->setAlias($container);
    }

    private function getEntityManagerDefinition(ContainerBuilder $container): Definition
    {
        if ($container->has(EntityManagerInterface::class) === true) {
            return $container->getDefinition(EntityManagerInterface::class);
        }

        return $container->getDefinition(EntityManager::class);
    }

    private function setAlias(ContainerBuilder $container): void
    {
        if ($container->has(EntityManagerInterface::class) === false) {
            $container->setAlias(EntityManagerInterface::class, EntityManager::class)->setPublic(true);
        }
    }
}
