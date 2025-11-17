<?php
/**
 * Entity repository implementation
 *
 * @category  Acme
 * @package   Acme_Example
 */
declare(strict_types=1);

namespace Acme\Example\Model;

use Acme\Example\Api\Data\EntityInterface;
use Acme\Example\Api\EntityRepositoryInterface;
use Acme\Example\Model\ResourceModel\Entity as EntityResource;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Entity repository implementation
 */
class EntityRepository implements EntityRepositoryInterface
{
    /**
     * @var EntityFactory
     */
    private EntityFactory $entityFactory;

    /**
     * @var EntityResource
     */
    private EntityResource $resource;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var array
     */
    private array $instances = [];

    /**
     * Constructor
     *
     * @param EntityFactory $entityFactory
     * @param EntityResource $resource
     * @param LoggerInterface $logger
     */
    public function __construct(
        EntityFactory $entityFactory,
        EntityResource $resource,
        LoggerInterface $logger
    ) {
        $this->entityFactory = $entityFactory;
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function save(EntityInterface $entity): EntityInterface
    {
        try {
            $this->resource->save($entity);
            unset($this->instances[$entity->getEntityId()]);
        } catch (\Exception $exception) {
            $this->logger->error('Error saving entity: ' . $exception->getMessage());
            throw new CouldNotSaveException(
                __('Could not save the entity: %1', $exception->getMessage())
            );
        }

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $entityId): EntityInterface
    {
        if (!isset($this->instances[$entityId])) {
            /** @var Entity $entity */
            $entity = $this->entityFactory->create();
            $this->resource->load($entity, $entityId);

            if (!$entity->getEntityId()) {
                throw new NoSuchEntityException(
                    __('Entity with id "%1" does not exist.', $entityId)
                );
            }

            $this->instances[$entityId] = $entity;
        }

        return $this->instances[$entityId];
    }

    /**
     * @inheritDoc
     */
    public function delete(EntityInterface $entity): bool
    {
        try {
            $entityId = $entity->getEntityId();
            $this->resource->delete($entity);
            unset($this->instances[$entityId]);
        } catch (\Exception $exception) {
            $this->logger->error('Error deleting entity: ' . $exception->getMessage());
            throw new CouldNotDeleteException(
                __('Could not delete the entity: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $entityId): bool
    {
        return $this->delete($this->getById($entityId));
    }
}
