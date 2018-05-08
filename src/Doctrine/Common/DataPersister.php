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
        $manager = $this->getManager($data);
        if ($manager === null) {
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
        $manager = $this->getManager($data);
        if ($manager === null) {
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
     * @param mixed $object
     *
     * @return string
     *
     * The only way to access this is using a static call
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    private function getObjectClass($object): string
    {
        if (class_exists(ClassUtils::class)) {
            return ClassUtils::getRealClass($object);
        }

        return \get_class($object);
    }
}
