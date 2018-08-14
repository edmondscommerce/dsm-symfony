<?php declare(strict_types=1);
/**
 * @category EdmondsCommerce
 * @package  EdmondsCommerce_
 * @author   Ross Mitchell <ross@edmondscommerce.co.uk>
 */

namespace EdmondsCommerce\DsmBundle\Factory;

use Dittto\DoctrineEntityFactories\Doctrine\ORM\Mapping\GenericFactoryInterface;
use EdmondsCommerce\DoctrineStaticMeta\Entity\Factory\EntityFactory;

class GenericEntityFactory implements GenericFactoryInterface
{
    /**
     * @var EntityFactory
     */
    private $factory;

    /**
     * ImportFactory constructor.
     *
     * @param EntityFactory $factory
     */
    public function __construct(EntityFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getEntity(string $name)
    {
        return $this->factory->create($name);
    }
}
