<?php
/**
 * Entity repository interface (Service Contract)
 *
 * @category  Acme
 * @package   Acme_Example
 */
declare(strict_types=1);

namespace Acme\Example\Api;

use Acme\Example\Api\Data\EntityInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Entity repository interface
 *
 * @api
 */
interface EntityRepositoryInterface
{
    /**
     * Save entity
     *
     * @param EntityInterface $entity
     * @return EntityInterface
     * @throws CouldNotSaveException
     */
    public function save(EntityInterface $entity): EntityInterface;

    /**
     * Get entity by ID
     *
     * @param int $entityId
     * @return EntityInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): EntityInterface;

    /**
     * Delete entity
     *
     * @param EntityInterface $entity
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(EntityInterface $entity): bool;

    /**
     * Delete entity by ID
     *
     * @param int $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $entityId): bool;
}
