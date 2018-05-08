<?php declare(strict_types=1);
/**
 * @category EdmondsCommerce
 * @package  EdmondsCommerce_
 * @author   Ross Mitchell <ross@edmondscommerce.co.uk>
 */

namespace EdmondsCommerce\DsmApiPlatformBundle;

use EdmondsCommerce\DsmApiPlatformBundle\DependencyInjection\Compiler\DataPersisterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DsmApiPlatformBundle extends Bundle
{

    /**
     * @inheritdoc
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container): void
    {
        $this->replacePersister($container);
    }

    /**
     * Registers our compiler pass class to switch out the Data Persister with our own
     *
     * @param ContainerBuilder $container
     */
    private function replacePersister(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new DataPersisterPass());
    }
}
