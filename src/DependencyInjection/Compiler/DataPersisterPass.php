<?php declare(strict_types=1);
/**
 * @category EdmondsCommerce
 * @package  EdmondsCommerce_
 * @author   Ross Mitchell <ross@edmondscommerce.co.uk>
 */

namespace EdmondsCommerce\DsmApiPlatformBundle\DependencyInjection\Compiler;

use EdmondsCommerce\DsmApiPlatformBundle\Doctrine\Common\DataPersister;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DataPersisterPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        $this->replaceDataPersisterWithOurOwn($container);
    }

    /**
     * We need to replace the standard API Platform data persister with one that explicitly call persist
     *
     * @param ContainerBuilder $container
     */
    private function replaceDataPersisterWithOurOwn(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('api_platform.doctrine.orm.data_persister');
        $definition->setClass(DataPersister::class);
    }
}
