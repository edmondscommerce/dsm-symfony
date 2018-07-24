<?php declare(strict_types=1);
/**
 * @category EdmondsCommerce
 * @package  EdmondsCommerce_
 * @author   Ross Mitchell <ross@edmondscommerce.co.uk>
 */

namespace EdmondsCommerce\DsmBundle\Doctrine\Common;

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Configuration;
use EdmondsCommerce\DoctrineStaticMeta\ConfigInterface;
use EdmondsCommerce\DoctrineStaticMeta\EntityManager\EntityManagerFactory as DsmEntityManagerFactory;

class EntityManagerFactory extends DsmEntityManagerFactory
{
    /**
     * @var Configuration
     */
    private $configuration;


    /**
     * EntityManagerFactory constructor.
     *
     * @param Configuration $configuration
     * @param Cache         $cache
     */
    public function __construct(Configuration $configuration, Cache $cache)
    {
        parent::__construct($cache);
        $this->configuration = $configuration;
    }

    public function getDoctrineConfig(ConfigInterface $config): Configuration
    {
        return $this->configuration;
    }
}
