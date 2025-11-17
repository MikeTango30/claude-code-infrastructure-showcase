<?php
/**
 * Entity repository unit test
 *
 * @category  Acme
 * @package   Acme_Example
 */
declare(strict_types=1);

namespace Acme\Example\Test\Unit\Model;

use Acme\Example\Api\Data\EntityInterface;
use Acme\Example\Model\Entity;
use Acme\Example\Model\EntityFactory;
use Acme\Example\Model\EntityRepository;
use Acme\Example\Model\ResourceModel\Entity as EntityResource;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Unit test for EntityRepository
 *
 * Example of TDD approach with comprehensive test coverage
 */
class EntityRepositoryTest extends TestCase
{
    /**
     * @var EntityRepository
     */
    private EntityRepository $repository;

    /**
     * @var MockObject|EntityFactory
     */
    private MockObject $entityFactoryMock;

    /**
     * @var MockObject|EntityResource
     */
    private MockObject $resourceMock;

    /**
     * @var MockObject|LoggerInterface
     */
    private MockObject $loggerMock;

    /**
     * Set up test dependencies
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->entityFactoryMock = $this->createMock(EntityFactory::class);
        $this->resourceMock = $this->createMock(EntityResource::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->repository = new EntityRepository(
            $this->entityFactoryMock,
            $this->resourceMock,
            $this->loggerMock
        );
    }

    /**
     * Test save method successfully saves entity
     *
     * @return void
     */
    public function testSaveEntitySuccess(): void
    {
        $entityMock = $this->createMock(Entity::class);
        $entityMock->expects($this->once())
            ->method('getEntityId')
            ->willReturn(1);

        $this->resourceMock->expects($this->once())
            ->method('save')
            ->with($entityMock)
            ->willReturn($this->resourceMock);

        $result = $this->repository->save($entityMock);

        $this->assertSame($entityMock, $result);
    }

    /**
     * Test save method throws exception on failure
     *
     * @return void
     */
    public function testSaveEntityThrowsException(): void
    {
        $this->expectException(CouldNotSaveException::class);
        $this->expectExceptionMessage('Could not save the entity');

        $entityMock = $this->createMock(Entity::class);

        $this->resourceMock->expects($this->once())
            ->method('save')
            ->with($entityMock)
            ->willThrowException(new \Exception('Database error'));

        $this->loggerMock->expects($this->once())
            ->method('error')
            ->with($this->stringContains('Error saving entity'));

        $this->repository->save($entityMock);
    }

    /**
     * Test getById returns entity
     *
     * @return void
     */
    public function testGetByIdSuccess(): void
    {
        $entityId = 1;
        $entityMock = $this->createMock(Entity::class);
        $entityMock->expects($this->once())
            ->method('getEntityId')
            ->willReturn($entityId);

        $this->entityFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($entityMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($entityMock, $entityId)
            ->willReturn($this->resourceMock);

        $result = $this->repository->getById($entityId);

        $this->assertInstanceOf(EntityInterface::class, $result);
        $this->assertEquals($entityId, $result->getEntityId());
    }

    /**
     * Test getById throws exception when entity not found
     *
     * @return void
     */
    public function testGetByIdThrowsNoSuchEntityException(): void
    {
        $this->expectException(NoSuchEntityException::class);
        $this->expectExceptionMessage('Entity with id "999" does not exist');

        $entityId = 999;
        $entityMock = $this->createMock(Entity::class);
        $entityMock->expects($this->once())
            ->method('getEntityId')
            ->willReturn(null);

        $this->entityFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($entityMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($entityMock, $entityId);

        $this->repository->getById($entityId);
    }

    /**
     * Test delete method successfully deletes entity
     *
     * @return void
     */
    public function testDeleteEntitySuccess(): void
    {
        $entityMock = $this->createMock(Entity::class);
        $entityMock->expects($this->once())
            ->method('getEntityId')
            ->willReturn(1);

        $this->resourceMock->expects($this->once())
            ->method('delete')
            ->with($entityMock)
            ->willReturn(true);

        $result = $this->repository->delete($entityMock);

        $this->assertTrue($result);
    }
}
