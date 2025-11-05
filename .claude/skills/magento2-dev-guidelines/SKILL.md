---
name: magento2-dev-guidelines
description: Comprehensive Magento 2 development guidelines covering module structure, dependency injection, plugins, observers, repositories, view layer (blocks, templates, layouts), best practices, and testing. Use when creating or modifying Magento 2 modules, customizations, or extensions.
---

# Magento 2 Development Guidelines

## Purpose

Establish consistency and best practices for Magento 2 development following Adobe Commerce standards and community best practices.

## When to Use This Skill

Automatically activates when working on:
- Creating or modifying Magento 2 modules
- Implementing plugins (interceptors)
- Creating observers for events
- Building API endpoints (Web API)
- Working with repositories and models
- Creating blocks, templates, and layouts
- Dependency injection configuration
- Database schema and data patches
- Admin grids and forms
- Frontend customizations

---

## Quick Start

### New Module Checklist

- [ ] **Module structure**: Standard Magento 2 directory structure
- [ ] **registration.php**: Module registration
- [ ] **module.xml**: Module declaration and dependencies
- [ ] **di.xml**: Dependency injection configuration
- [ ] **Composer**: composer.json for dependencies
- [ ] **Interfaces**: API contracts in Api/ directory
- [ ] **Repositories**: Data access layer
- [ ] **Models**: Business logic
- [ ] **Plugins**: Behavior modification
- [ ] **Observers**: Event handling
- [ ] **Tests**: Unit and integration tests

### New Feature Checklist

- [ ] Define API contracts (interfaces)
- [ ] Implement repositories for data access
- [ ] Create service contracts
- [ ] Use dependency injection
- [ ] Implement plugins (not preferences unless necessary)
- [ ] Create observers for events
- [ ] Add proper error handling
- [ ] Write unit tests
- [ ] Write integration tests
- [ ] Update module version in module.xml

---

## Magento 2 Architecture Overview

### Module Structure

```
app/code/Vendor/Module/
├── Api/                      # API contracts (interfaces)
│   ├── Data/                 # Data interfaces
│   └── *RepositoryInterface.php
├── Block/                    # View blocks
├── Console/                  # CLI commands
├── Controller/               # Controllers
│   ├── Adminhtml/           # Admin controllers
│   └── Index/               # Frontend controllers
├── Cron/                    # Cron jobs
├── etc/                     # Configuration
│   ├── adminhtml/           # Admin-specific config
│   │   ├── menu.xml
│   │   ├── routes.xml
│   │   └── system.xml
│   ├── frontend/            # Frontend-specific config
│   │   └── routes.xml
│   ├── di.xml               # Dependency injection
│   ├── module.xml           # Module declaration
│   ├── events.xml           # Event declarations
│   ├── webapi.xml           # REST/SOAP API
│   ├── acl.xml              # Access Control List
│   └── config.xml           # Default config values
├── Helper/                  # Helper classes (minimize use)
├── Model/                   # Models and resource models
│   ├── ResourceModel/       # Resource models & collections
│   └── *Repository.php      # Repository implementations
├── Observer/                # Event observers
├── Plugin/                  # Plugins (interceptors)
├── Setup/                   # Installation/upgrade scripts
│   ├── Patch/               # Data and schema patches
│   │   ├── Data/
│   │   └── Schema/
│   └── InstallSchema.php    # (deprecated, use patches)
├── Test/                    # Unit and integration tests
│   ├── Unit/
│   └── Integration/
├── Ui/                      # UI components
│   ├── Component/
│   └── DataProvider/
├── view/                    # View layer
│   ├── adminhtml/           # Admin view files
│   │   ├── layout/
│   │   ├── templates/
│   │   ├── ui_component/
│   │   └── web/
│   └── frontend/            # Frontend view files
│       ├── layout/
│       ├── templates/
│       ├── web/
│       │   ├── css/
│       │   ├── js/
│       │   └── template/
│       └── requirejs-config.js
├── composer.json            # Composer dependencies
├── registration.php         # Module registration
└── README.md                # Module documentation
```

---

## Core Principles

### 1. Dependency Injection (DI)

**Always use constructor injection:**

```php
<?php
namespace Vendor\Module\Model;

use Vendor\Module\Api\CustomerRepositoryInterface;
use Psr\Log\LoggerInterface;

class CustomerService
{
    private CustomerRepositoryInterface $customerRepository;
    private LoggerInterface $logger;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        LoggerInterface $logger
    ) {
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
    }

    public function getCustomerData(int $customerId): array
    {
        try {
            $customer = $this->customerRepository->getById($customerId);
            return $customer->getData();
        } catch (\Exception $e) {
            $this->logger->error('Error fetching customer: ' . $e->getMessage());
            throw $e;
        }
    }
}
```

**Configure in di.xml:**

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <!-- Preference for interface -->
    <preference for="Vendor\Module\Api\CustomerRepositoryInterface"
                type="Vendor\Module\Model\CustomerRepository"/>

    <!-- Virtual type for customization -->
    <virtualType name="Vendor\Module\Model\SpecialCustomerService"
                 type="Vendor\Module\Model\CustomerService">
        <arguments>
            <argument name="logger" xsi:type="object">Vendor\Module\Logger\CustomLogger</argument>
        </arguments>
    </virtualType>
</config>
```

### 2. Service Contracts (API)

**Always define interfaces:**

```php
<?php
namespace Vendor\Module\Api;

use Vendor\Module\Api\Data\ProductInterface;

/**
 * Product repository interface
 * @api
 */
interface ProductRepositoryInterface
{
    /**
     * Get product by ID
     *
     * @param int $productId
     * @return \Vendor\Module\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $productId): ProductInterface;

    /**
     * Save product
     *
     * @param \Vendor\Module\Api\Data\ProductInterface $product
     * @return \Vendor\Module\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(ProductInterface $product): ProductInterface;

    /**
     * Delete product
     *
     * @param \Vendor\Module\Api\Data\ProductInterface $product
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(ProductInterface $product): bool;
}
```

### 3. Plugins (Interceptors)

**Use plugins instead of preferences when possible:**

```php
<?php
namespace Vendor\Module\Plugin;

use Magento\Catalog\Model\Product;
use Psr\Log\LoggerInterface;

class ProductPlugin
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Before plugin - modify arguments
     */
    public function beforeSetName(Product $subject, string $name): array
    {
        $this->logger->info('Setting product name to: ' . $name);
        return [$name]; // Return array of arguments
    }

    /**
     * After plugin - modify return value
     */
    public function afterGetName(Product $subject, string $result): string
    {
        return strtoupper($result);
    }

    /**
     * Around plugin - full control (use sparingly)
     */
    public function aroundSave(
        Product $subject,
        callable $proceed
    ): Product {
        $this->logger->info('Before save');

        // Call original method
        $result = $proceed();

        $this->logger->info('After save');
        return $result;
    }
}
```

**Configure plugin in di.xml:**

```xml
<type name="Magento\Catalog\Model\Product">
    <plugin name="vendor_module_product_plugin"
            type="Vendor\Module\Plugin\ProductPlugin"
            sortOrder="10"
            disabled="false"/>
</type>
```

### 4. Observers

**Use observers for event handling:**

```php
<?php
namespace Vendor\Module\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class ProductSaveAfterObserver implements ObserverInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer): void
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getProduct();

        $this->logger->info('Product saved: ' . $product->getSku());

        // Your custom logic here
    }
}
```

**Configure in events.xml:**

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Event/etc/events.xsd">
    <event name="catalog_product_save_after">
        <observer name="vendor_module_product_save_after"
                  instance="Vendor\Module\Observer\ProductSaveAfterObserver"/>
    </event>
</config>
```

### 5. Repository Pattern

**Implement repository for data access:**

```php
<?php
namespace Vendor\Module\Model;

use Vendor\Module\Api\ProductRepositoryInterface;
use Vendor\Module\Api\Data\ProductInterface;
use Vendor\Module\Model\ResourceModel\Product as ProductResource;
use Vendor\Module\Model\ProductFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

class ProductRepository implements ProductRepositoryInterface
{
    private ProductResource $resource;
    private ProductFactory $productFactory;

    public function __construct(
        ProductResource $resource,
        ProductFactory $productFactory
    ) {
        $this->resource = $resource;
        $this->productFactory = $productFactory;
    }

    public function getById(int $productId): ProductInterface
    {
        $product = $this->productFactory->create();
        $this->resource->load($product, $productId);

        if (!$product->getId()) {
            throw new NoSuchEntityException(
                __('Product with id "%1" does not exist.', $productId)
            );
        }

        return $product;
    }

    public function save(ProductInterface $product): ProductInterface
    {
        try {
            $this->resource->save($product);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('Could not save product: %1', $e->getMessage()),
                $e
            );
        }

        return $product;
    }

    public function delete(ProductInterface $product): bool
    {
        try {
            $this->resource->delete($product);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(
                __('Could not delete product: %1', $e->getMessage()),
                $e
            );
        }

        return true;
    }
}
```

---

## Database: Schema and Data Patches

**Use declarative schema (db_schema.xml):**

```xml
<?xml version="1.0"?>
<schema xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Setup/Declaration/Schema/etc/schema.xsd">
    <table name="vendor_module_product" resource="default" engine="innodb"
           comment="Custom Product Table">
        <column xsi:type="int" name="entity_id" unsigned="true" nullable="false"
                identity="true" comment="Entity ID"/>
        <column xsi:type="varchar" name="sku" nullable="false" length="64"
                comment="SKU"/>
        <column xsi:type="text" name="name" nullable="false"
                comment="Product Name"/>
        <column xsi:type="decimal" name="price" scale="4" precision="12"
                unsigned="false" nullable="false" default="0" comment="Price"/>
        <column xsi:type="timestamp" name="created_at" nullable="false"
                default="CURRENT_TIMESTAMP" comment="Created At"/>
        <column xsi:type="timestamp" name="updated_at" nullable="false"
                default="CURRENT_TIMESTAMP" on_update="true" comment="Updated At"/>

        <constraint xsi:type="primary" referenceId="PRIMARY">
            <column name="entity_id"/>
        </constraint>
        <constraint xsi:type="unique" referenceId="VENDOR_MODULE_PRODUCT_SKU">
            <column name="sku"/>
        </constraint>

        <index referenceId="VENDOR_MODULE_PRODUCT_NAME" indexType="fulltext">
            <column name="name"/>
        </index>
    </table>
</schema>
```

**Data patch for inserting data:**

```php
<?php
namespace Vendor\Module\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Vendor\Module\Api\ProductRepositoryInterface;
use Vendor\Module\Model\ProductFactory;

class AddSampleProducts implements DataPatchInterface
{
    private ProductRepositoryInterface $productRepository;
    private ProductFactory $productFactory;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductFactory $productFactory
    ) {
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
    }

    public function apply(): void
    {
        $product = $this->productFactory->create();
        $product->setData([
            'sku' => 'SAMPLE-001',
            'name' => 'Sample Product',
            'price' => 99.99
        ]);

        $this->productRepository->save($product);
    }

    public static function getDependencies(): array
    {
        return []; // List of patch dependencies
    }

    public function getAliases(): array
    {
        return []; // Patch aliases for backwards compatibility
    }
}
```

---

## View Layer: Blocks, Templates, Layouts

### Block

```php
<?php
namespace Vendor\Module\Block;

use Magento\Framework\View\Element\Template;
use Vendor\Module\Api\ProductRepositoryInterface;

class ProductList extends Template
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function getProducts(): array
    {
        // Fetch products
        return [];
    }

    public function getProductUrl(int $productId): string
    {
        return $this->getUrl('module/product/view', ['id' => $productId]);
    }
}
```

### Template (view/frontend/templates/product/list.phtml)

```php
<?php
/** @var \Vendor\Module\Block\ProductList $block */
$products = $block->getProducts();
?>

<div class="product-list">
    <?php if (empty($products)): ?>
        <p><?= $block->escapeHtml(__('No products found.')) ?></p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <h3><?= $block->escapeHtml($product->getName()) ?></h3>
                <p class="price"><?= $block->escapeHtml($product->getPrice()) ?></p>
                <a href="<?= $block->escapeUrl($block->getProductUrl($product->getId())) ?>">
                    <?= $block->escapeHtml(__('View Details')) ?>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
```

### Layout XML (view/frontend/layout/module_product_list.xml)

```xml
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <head>
        <title>Product List</title>
        <css src="Vendor_Module::css/product-list.css"/>
    </head>
    <body>
        <referenceContainer name="content">
            <block class="Vendor\Module\Block\ProductList"
                   name="vendor.module.product.list"
                   template="Vendor_Module::product/list.phtml">
                <arguments>
                    <argument name="cache_lifetime" xsi:type="string">3600</argument>
                </arguments>
            </block>
        </referenceContainer>
    </body>
</page>
```

---

## Web API (REST/SOAP)

**Define in webapi.xml:**

```xml
<?xml version="1.0"?>
<routes xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Webapi:etc/webapi.xsd">
    <route url="/V1/vendor-module/products/:productId" method="GET">
        <service class="Vendor\Module\Api\ProductRepositoryInterface" method="getById"/>
        <resources>
            <resource ref="Vendor_Module::product_view"/>
        </resources>
    </route>

    <route url="/V1/vendor-module/products" method="POST">
        <service class="Vendor\Module\Api\ProductRepositoryInterface" method="save"/>
        <resources>
            <resource ref="Vendor_Module::product_save"/>
        </resources>
    </route>
</routes>
```

**Usage:**
```bash
# GET
curl -X GET "https://example.com/rest/V1/vendor-module/products/1" \
  -H "Authorization: Bearer {token}"

# POST
curl -X POST "https://example.com/rest/V1/vendor-module/products" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{"product": {"sku": "TEST", "name": "Test Product", "price": 19.99}}'
```

---

## Best Practices

### DO ✅

- ✅ Use dependency injection for all class dependencies
- ✅ Define API contracts (interfaces) before implementation
- ✅ Use plugins instead of preferences when possible
- ✅ Follow PSR-12 coding standards
- ✅ Use declarative schema (db_schema.xml) for database
- ✅ Implement repository pattern for data access
- ✅ Use service contracts for business logic
- ✅ Escape output in templates ($block->escapeHtml())
- ✅ Use observers for event handling
- ✅ Write unit and integration tests
- ✅ Use type hints and return types (PHP 7.4+)
- ✅ Log errors with PSR-3 LoggerInterface
- ✅ Use factories for object creation
- ✅ Implement proper ACL for admin resources
- ✅ Cache blocks and data when appropriate

### DON'T ❌

- ❌ Use ObjectManager directly (except in factories)
- ❌ Use preferences when plugins can work
- ❌ Modify core files
- ❌ Use helpers excessively (prefer service contracts)
- ❌ Direct SQL queries (use repositories and collections)
- ❌ Hard-code values (use configuration)
- ❌ Forget to escape output
- ❌ Use $_GET, $_POST directly (use Request object)
- ❌ Skip dependency injection
- ❌ Create God objects (single responsibility principle)
- ❌ Use deprecated methods
- ❌ Forget to update module version after changes

---

## Testing

### Unit Test Example

```php
<?php
namespace Vendor\Module\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Vendor\Module\Model\CustomerService;
use Vendor\Module\Api\CustomerRepositoryInterface;
use Psr\Log\LoggerInterface;

class CustomerServiceTest extends TestCase
{
    private CustomerService $customerService;
    private CustomerRepositoryInterface $customerRepository;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->customerService = new CustomerService(
            $this->customerRepository,
            $this->logger
        );
    }

    public function testGetCustomerData(): void
    {
        $customerId = 1;
        $expectedData = ['name' => 'John Doe', 'email' => 'john@example.com'];

        $customer = $this->createMock(\Vendor\Module\Api\Data\CustomerInterface::class);
        $customer->method('getData')->willReturn($expectedData);

        $this->customerRepository
            ->expects($this->once())
            ->method('getById')
            ->with($customerId)
            ->willReturn($customer);

        $result = $this->customerService->getCustomerData($customerId);

        $this->assertEquals($expectedData, $result);
    }
}
```

**Run tests:**
```bash
# Unit tests
php bin/magento dev:tests:run unit --filter Vendor_Module

# Integration tests
php bin/magento dev:tests:run integration --filter Vendor_Module
```

---

## Magento 2 CLI Commands

**Common development commands:**

```bash
# Module management
php bin/magento module:enable Vendor_Module
php bin/magento module:disable Vendor_Module
php bin/magento module:status

# Setup
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f

# Cache
php bin/magento cache:flush
php bin/magento cache:clean
php bin/magento cache:enable
php bin/magento cache:disable

# Indexing
php bin/magento indexer:reindex
php bin/magento indexer:status

# Development mode
php bin/magento deploy:mode:set developer
php bin/magento deploy:mode:set production

# Database
php bin/magento setup:db:status
php bin/magento setup:db-schema:upgrade
php bin/magento setup:db-data:upgrade
```

---

## Workflow Integration

### TDD Workflow for Magento 2

1. **Define API interface** (contract)
2. **Write PHPUnit tests** for the interface
3. **Implement the interface**
4. **Run tests** until all pass
5. **Configure DI** in di.xml
6. **Integrate** with Magento events/plugins
7. **Test** in browser/API

### Documentation-Driven Workflow for Magento 2

Each phase might be:
- **Phase 1**: Module structure and interfaces
- **Phase 2**: Models and repositories
- **Phase 3**: Plugins and observers
- **Phase 4**: View layer (blocks, templates, layouts)
- **Phase 5**: Admin configuration and ACL
- **Phase 6**: Web API and testing

---

## Module Registration

**registration.php:**

```php
<?php
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Vendor_Module',
    __DIR__
);
```

**etc/module.xml:**

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="Vendor_Module" setup_version="1.0.0">
        <sequence>
            <module name="Magento_Catalog"/>
            <module name="Magento_Customer"/>
        </sequence>
    </module>
</config>
```

**composer.json:**

```json
{
    "name": "vendor/module-name",
    "description": "Module description",
    "type": "magento2-module",
    "version": "1.0.0",
    "license": "proprietary",
    "autoload": {
        "files": ["registration.php"],
        "psr-4": {
            "Vendor\\Module\\": ""
        }
    },
    "require": {
        "php": "~7.4.0||~8.1.0",
        "magento/framework": "*",
        "magento/module-catalog": "*"
    }
}
```

---

## Resources

- [Magento 2 DevDocs](https://devdocs.magento.com/)
- [Magento 2 Technical Guidelines](https://developer.adobe.com/commerce/php/coding-standards/technical-guidelines/)
- [Magento 2 Best Practices](https://experienceleague.adobe.com/docs/commerce-operations/implementation-playbook/best-practices/development/overview.html)
- [Magento Coding Standards](https://github.com/magento/magento-coding-standard)

---

**Use with workflows:**
- **tdd-workflow**: Write PHPUnit tests for Magento models/repositories
- **doc-driven-workflow**: Break module development into phases
- **Combined**: Plan module phases, write tests per phase, implement

**Magento 2 Version:** This skill covers Magento 2.4.x (Adobe Commerce / Magento Open Source)
