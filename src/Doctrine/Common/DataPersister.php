<?php declare(strict_types=1);
/**
 * @category EdmondsCommerce
 * @package  EdmondsCommerce_
 * @author   Ross Mitchell <ross@edmondscommerce.co.uk>
 */

namespace EdmondsCommerce\DsmApiPlatformBundle\Doctrine\Common;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager as DoctrineObjectManager;
use Doctrine\Common\Util\ClassUtils;

class DataPersister implements DataPersisterInterface
{

    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data): bool
    {
        return null !== $this->getManager($data);
    }

    /**
     * This is the bit that we are changing. As we are using the Deferred Explicit tracking policy, we need persist to
     * be called before the object is flushed. This ensures that it is
     *
     * {@inheritdoc}
     */
    public function persist($data): void
    {
        if (!$manager = $this->getManager($data)) {
            return;
        }

        $manager->persist($data);
        $manager->flush();
        $manager->refresh($data);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data): void
    {
        if (!$manager = $this->getManager($data)) {
            return;
        }

        $manager->remove($data);
        $manager->flush();
    }

    /**
     * Gets the Doctrine object manager associated with given data.
     *
     * @param mixed $data
     *
     * @return DoctrineObjectManager|null
     */
    private function getManager($data): ?DoctrineObjectManager
    {
        if (!\is_object($data)) {
            return null;
        }

        $realClassName = $this->getObjectClass($data);

        return $this->managerRegistry->getManagerForClass($realClassName);
    }

    /**
     * Tries to get the real class name using the doctrine ClassUtils. If this is not possible return the result of
     * get_class
     *
     * @param $object
     *
     * @return string
     */
    private function getObjectClass($object): string
    {
        return class_exists(ClassUtils::class) ? ClassUtils::getClass($object) : \get_class($object);
    }
}
