<?php declare(strict_types=1);
/**
 * @category EdmondsCommerce
 * @package  EdmondsCommerce_
 * @author   Ross Mitchell <ross@edmondscommerce.co.uk>
 */

namespace EdmondsCommerce\DsmBundle\Doctrine\Common;

use App\ImportFactory;
use Dittto\DoctrineEntityFactories\Doctrine\ORM\Decorator\EntityFactoryManagerDecorator;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use EdmondsCommerce\DoctrineStaticMeta\ConfigInterface;
use EdmondsCommerce\DoctrineStaticMeta\Entity\Factory\EntityFactory;
use EdmondsCommerce\DoctrineStaticMeta\Entity\Validation\EntityValidatorFactory;
use EdmondsCommerce\DoctrineStaticMeta\EntityManager\EntityManagerFactory as DsmEntityManagerFactory;
use EdmondsCommerce\DsmBundle\Factory\GenericEntityFactory;
use EdmondsCommerce\VaultEntities\Entities\Import;

class EntityManagerFactory extends DsmEntityManagerFactory
{
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var EntityValidatorFactory
     */
    private $validatorFactory;


    /**
     * EntityManagerFactory constructor.
     *
     * @param Configuration          $configuration
     * @param Cache                  $cache
     * @param EntityValidatorFactory $validatorFactory
     */
    public function __construct(Configuration $configuration, Cache $cache, EntityValidatorFactory $validatorFactory)
    {
        parent::__construct($cache);
        $this->configuration = $configuration;
        $this->validatorFactory = $validatorFactory;
    }

    public function getDoctrineConfig(ConfigInterface $config): Configuration
    {
        return $this->configuration;
    }

    public function createEntityManager(array $dbParams, Configuration $doctrineConfig): EntityManagerInterface
    {
        $entityManager = parent::createEntityManager($dbParams, $doctrineConfig);
        $wrapper       = new EntityFactoryManagerDecorator($entityManager);
        $entityFactory = new EntityFactory($this->validatorFactory, $wrapper);
        $factory = new GenericEntityFactory($entityFactory);
        $wrapper->addGenericFactory($factory);

        return $wrapper;
    }
}
