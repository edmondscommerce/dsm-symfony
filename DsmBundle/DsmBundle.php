<?php declare(strict_types=1);
/**
 * @category EdmondsCommerce
 * @package  EdmondsCommerce_
 * @author   Ross Mitchell <ross@edmondscommerce.co.uk>
 */

namespace EdmondsCommerce\DsmBundle;

use EdmondsCommerce\DsmBundle\DependencyInjection\Compiler\DataPersisterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DsmBundle extends Bundle
{
    /**
     * @inheritdoc
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container): void
    {
        return;
    }
}
