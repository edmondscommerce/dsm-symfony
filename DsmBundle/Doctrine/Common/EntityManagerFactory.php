<?php declare(strict_types=1);
/**
 * @category EdmondsCommerce
 * @package  EdmondsCommerce_
 * @author   Ross Mitchell <ross@edmondscommerce.co.uk>
 */

namespace EdmondsCommerce\DsmBundle\Doctrine\Common;

use Doctrine\Common\Cache\Cache;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use EdmondsCommerce\DoctrineStaticMeta\ConfigInterface;
use EdmondsCommerce\DoctrineStaticMeta\Entity\Factory\EntityFactory;
use EdmondsCommerce\DoctrineStaticMeta\EntityManager\Decorator\EntityFactoryManagerDecorator;
use EdmondsCommerce\DoctrineStaticMeta\EntityManager\EntityManagerFactory as DsmEntityManagerFactory;

class EntityManagerFactory extends DsmEntityManagerFactory
{
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var Connection
     */
    private $connection;

    /**
     * EntityManagerFactory constructor.
     *
     * @param Configuration $configuration
     * @param Connection    $connection
     * @param Cache         $cache
     * @param EntityFactory $factory
     */
    public function __construct(
        Configuration $configuration,
        Connection $connection,
        Cache $cache,
        EntityFactory $factory
    ) {
        parent::__construct($cache, $factory);
        $this->configuration = $configuration;
        $this->connection    = $connection;
    }

    /**
     * We already have a fully configured DBAL connection from the config folder. It makes sense to use that, plus it
     * allows other services, such as the web profiler to hook into it
     *
     * @param array         $dbParams
     * @param Configuration $doctrineConfig
     *
     * @return EntityManagerInterface
     * @throws \Doctrine\ORM\ORMException
     */
    public function createEntityManager(array $dbParams, Configuration $doctrineConfig): EntityManagerInterface
    {
        $entityManager = EntityManager::create($this->connection, $doctrineConfig);

        return new EntityFactoryManagerDecorator($entityManager);
    }

    public function getDoctrineConfig(ConfigInterface $config): Configuration
    {
        return $this->configuration;
    }


}
