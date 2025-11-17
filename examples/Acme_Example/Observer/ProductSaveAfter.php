<?php
/**
 * Product save after observer
 *
 * @category  Acme
 * @package   Acme_Example
 */
declare(strict_types=1);

namespace Acme\Example\Observer;

use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

/**
 * Observer for catalog_product_save_after event
 *
 * Observers respond to events dispatched throughout Magento
 */
class ProductSaveAfter implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        /** @var Product $product */
        $product = $observer->getData('product');

        if (!$product) {
            return;
        }

        // Example: Log product save
        $this->logger->info(sprintf(
            'Product saved: ID=%s, SKU=%s, Name=%s',
            $product->getId(),
            $product->getSku(),
            $product->getName()
        ));

        // Example: Perform custom logic after product save
        // - Update related entities
        // - Send notifications
        // - Clear custom caches
        // - Sync with external systems
    }
}
