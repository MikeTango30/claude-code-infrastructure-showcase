<?php
/**
 * Entity resource model
 *
 * @category  Acme
 * @package   Acme_Example
 */
declare(strict_types=1);

namespace Acme\Example\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Entity resource model
 */
class Entity extends AbstractDb
{
    /**
     * Table name
     */
    private const TABLE_NAME = 'acme_example_entity';

    /**
     * Primary key field name
     */
    private const ID_FIELD_NAME = 'entity_id';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}
