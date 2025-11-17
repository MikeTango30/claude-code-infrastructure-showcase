<?php
/**
 * Product plugin (interceptor) example
 *
 * @category  Acme
 * @package   Acme_Example
 */
declare(strict_types=1);

namespace Acme\Example\Plugin;

use Magento\Catalog\Model\Product;
use Psr\Log\LoggerInterface;

/**
 * Product plugin to demonstrate plugin pattern
 *
 * Plugins allow you to intercept method calls without modifying the original class
 */
class ProductPlugin
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
     * Before plugin example: Runs BEFORE the original method
     *
     * Can modify arguments passed to the original method
     *
     * @param Product $subject
     * @param string $name
     * @return array Modified arguments
     */
    public function beforeSetName(Product $subject, string $name): array
    {
        $this->logger->info('Product name being set to: ' . $name);

        // Example: Sanitize name before saving
        $sanitizedName = trim($name);

        // Return modified arguments as array
        return [$sanitizedName];
    }

    /**
     * After plugin example: Runs AFTER the original method
     *
     * Can modify the result returned by the original method
     *
     * @param Product $subject
     * @param string|null $result Original method result
     * @return string|null Modified result
     */
    public function afterGetName(Product $subject, ?string $result): ?string
    {
        // Example: Add suffix to product name
        if ($result) {
            $this->logger->info('Product name retrieved: ' . $result);
            // You can modify the result here if needed
        }

        return $result;
    }

    /**
     * Around plugin example: Wraps the original method
     *
     * Most powerful but should be used sparingly
     * Can execute code before AND after, and even prevent original method execution
     *
     * @param Product $subject
     * @param callable $proceed Original method callable
     * @param mixed $data
     * @return Product
     */
    public function aroundSave(Product $subject, callable $proceed, ...$data): Product
    {
        // Code before original method
        $this->logger->info('About to save product: ' . $subject->getSku());

        try {
            // Call original method
            $result = $proceed(...$data);

            // Code after original method (on success)
            $this->logger->info('Product saved successfully: ' . $subject->getSku());

            return $result;
        } catch (\Exception $e) {
            // Handle exceptions
            $this->logger->error('Error saving product: ' . $e->getMessage());
            throw $e;
        }
    }
}
