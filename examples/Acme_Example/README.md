# Acme_Example - Magento 2 Best Practices Reference Module

A complete example Magento 2 module demonstrating best practices, design patterns, and Claude Code workflows.

## Overview

This module serves as a **reference implementation** showing how to properly structure a Magento 2 module following Adobe Commerce standards. It includes examples of:

- ✅ Service Contracts (API interfaces)
- ✅ Repository Pattern
- ✅ Dependency Injection
- ✅ Plugins (Interceptors)
- ✅ Observers
- ✅ Unit Tests (TDD approach)
- ✅ PSR-12 Coding Standards
- ✅ Proper namespacing and autoloading

## Module Structure

```
Acme_Example/
├── Api/
│   ├── Data/
│   │   └── EntityInterface.php          # Data model interface (API)
│   └── EntityRepositoryInterface.php    # Repository interface (API)
├── Model/
│   ├── Entity.php                       # Data model implementation
│   ├── EntityRepository.php             # Repository implementation
│   └── ResourceModel/
│       └── Entity.php                   # Database resource model
├── Plugin/
│   └── ProductPlugin.php                # Plugin example (interceptor)
├── Observer/
│   └── ProductSaveAfter.php             # Observer example
├── Test/
│   └── Unit/
│       └── Model/
│           └── EntityRepositoryTest.php # Unit test example
├── etc/
│   ├── module.xml                       # Module declaration
│   ├── di.xml                           # Dependency injection config
│   └── events.xml                       # Events configuration
├── registration.php                     # Module registration
├── composer.json                        # Composer package definition
└── README.md                            # This file
```

## Design Patterns Demonstrated

### 1. Service Contracts (API Layer)

**Files:**
- `Api/Data/EntityInterface.php`
- `Api/EntityRepositoryInterface.php`

**Purpose:**
Service contracts define a module's public API. They ensure:
- Backward compatibility
- Clear separation between API and implementation
- Type safety and contract enforcement

**Example:**
```php
// Interface defines the contract
interface EntityRepositoryInterface
{
    public function save(EntityInterface $entity): EntityInterface;
    public function getById(int $entityId): EntityInterface;
}

// Implementation fulfills the contract
class EntityRepository implements EntityRepositoryInterface
{
    // Implementation details...
}
```

**When to use:**
- Always for public APIs
- When building extensible modules
- For repository patterns

---

### 2. Repository Pattern

**Files:**
- `Model/EntityRepository.php`
- `Model/ResourceModel/Entity.php`

**Purpose:**
Repositories abstract database operations:
- Single source of truth for data access
- Centralized caching logic
- Consistent error handling
- Easy to mock for testing

**Example:**
```php
// Repository handles all data access
public function getById(int $entityId): EntityInterface
{
    if (!isset($this->instances[$entityId])) {
        $entity = $this->entityFactory->create();
        $this->resource->load($entity, $entityId);

        if (!$entity->getEntityId()) {
            throw new NoSuchEntityException(__('Entity not found'));
        }

        $this->instances[$entityId] = $entity; // Cache
    }

    return $this->instances[$entityId];
}
```

**When to use:**
- Always for data models
- Required for API layer
- Essential for proper caching

---

### 3. Dependency Injection (DI)

**Files:**
- `etc/di.xml`
- All classes use constructor injection

**Purpose:**
DI provides:
- Loose coupling
- Easy testing (mock dependencies)
- Automatic object creation
- Configuration-based behavior

**Example:**
```xml
<!-- di.xml: Map interface to implementation -->
<preference for="Acme\Example\Api\EntityRepositoryInterface"
            type="Acme\Example\Model\EntityRepository"/>

<!-- Inject custom logger -->
<type name="Acme\Example\Model\EntityRepository">
    <arguments>
        <argument name="logger" xsi:type="object">Acme\Example\Logger\Logger</argument>
    </arguments>
</type>
```

**In PHP:**
```php
class EntityRepository
{
    public function __construct(
        EntityFactory $entityFactory,
        EntityResource $resource,
        LoggerInterface $logger  // Injected automatically
    ) {
        $this->entityFactory = $entityFactory;
        $this->resource = $resource;
        $this->logger = $logger;
    }
}
```

**When to use:**
- Always for class dependencies
- Never use ObjectManager directly
- Use factories for creating new instances

---

### 4. Plugins (Interceptors)

**Files:**
- `Plugin/ProductPlugin.php`
- `etc/di.xml` (configuration)

**Purpose:**
Plugins allow you to:
- Modify behavior without changing core code
- Intercept method calls
- Run code before, after, or around methods

**Types:**

**Before Plugin:**
```php
public function beforeSetName(Product $subject, string $name): array
{
    // Runs BEFORE original method
    // Can modify arguments
    $sanitized = trim($name);
    return [$sanitized]; // Modified arguments
}
```

**After Plugin:**
```php
public function afterGetName(Product $subject, ?string $result): ?string
{
    // Runs AFTER original method
    // Can modify result
    return $result . ' (Modified)';
}
```

**Around Plugin:**
```php
public function aroundSave(Product $subject, callable $proceed, ...$data): Product
{
    // Code BEFORE original method
    $result = $proceed(...$data); // Call original
    // Code AFTER original method
    return $result;
}
```

**Configuration:**
```xml
<type name="Magento\Catalog\Model\Product">
    <plugin name="acme_example_product_plugin"
            type="Acme\Example\Plugin\ProductPlugin"
            sortOrder="10"/>
</type>
```

**When to use:**
- Modifying core behavior
- Adding logging/validation
- Prefer plugins over preferences

---

### 5. Observers

**Files:**
- `Observer/ProductSaveAfter.php`
- `etc/events.xml`

**Purpose:**
Observers respond to events:
- React to system events
- Decouple modules
- Implement event-driven architecture

**Example:**
```php
class ProductSaveAfter implements ObserverInterface
{
    public function execute(Observer $observer): void
    {
        $product = $observer->getData('product');

        // React to product save event
        $this->logger->info('Product saved: ' . $product->getSku());
    }
}
```

**Configuration:**
```xml
<event name="catalog_product_save_after">
    <observer name="acme_example_product_save_after"
              instance="Acme\Example\Observer\ProductSaveAfter"/>
</event>
```

**When to use:**
- Responding to system events
- Loosely coupled integrations
- When you don't need to modify return values

**Plugins vs Observers:**
- Plugins: Intercept method calls, can modify results
- Observers: React to events, can't modify results
- Use plugins to change behavior, observers to react to events

---

### 6. Unit Testing (TDD)

**Files:**
- `Test/Unit/Model/EntityRepositoryTest.php`

**Purpose:**
Unit tests ensure:
- Code correctness
- Refactoring safety
- Documentation of expected behavior
- TDD workflow support

**Example:**
```php
public function testSaveEntitySuccess(): void
{
    $entityMock = $this->createMock(Entity::class);

    $this->resourceMock->expects($this->once())
        ->method('save')
        ->with($entityMock);

    $result = $this->repository->save($entityMock);

    $this->assertSame($entityMock, $result);
}
```

**Running tests:**
```bash
# Run all unit tests
vendor/bin/phpunit app/code/Acme/Example/Test/Unit

# Run specific test
vendor/bin/phpunit app/code/Acme/Example/Test/Unit/Model/EntityRepositoryTest.php
```

**When to use:**
- Always for business logic
- Repository methods
- Complex algorithms
- TDD workflow

---

## Installation

### 1. Copy Module to Project

```bash
# Copy to Magento app/code directory
cp -r examples/Acme_Example app/code/Acme/Example
```

### 2. Enable Module

```bash
php bin/magento module:enable Acme_Example
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
```

### 3. Verify Installation

```bash
php bin/magento module:status Acme_Example
# Should show: "Module is enabled"
```

---

## Using with Claude Code Workflows

This example module demonstrates how to use Claude Code workflows effectively.

### TDD Workflow

**Step 1: Copy module and write tests**
```bash
# Create your module based on this example
/m2-module YourVendor_YourModule "Your description"

# Write tests first (following EntityRepositoryTest.php example)
# Create Test/Unit/Model/YourRepositoryTest.php
```

**Step 2: Go AFK for autonomous implementation**
```
"I've written tests for YourRepository. I'm going AFK, implement until all tests pass."
```

Claude will:
- ✅ Run tests (RED phase)
- ✅ Implement code
- ✅ Re-run tests
- ✅ Fix failures
- ✅ Repeat until GREEN

**Step 3: Review and commit**
```bash
vendor/bin/phpunit app/code/YourVendor/YourModule/Test/Unit
git add .
git commit -m "feat: Implement YourRepository with TDD"
```

---

### Documentation-Driven Workflow

**Step 1: Create feature documentation**
```bash
/feature custom-shipping-module "Custom shipping method with rate calculation"
```

**Step 2: Clarify requirements**
```bash
/clarify custom-shipping-module
```

**Step 3: Research existing patterns**
```bash
/research custom-shipping-module
# Claude analyzes this example module and similar code
```

**Step 4: Execute phases**
```bash
# Phase 1: Database schema and models (fresh context)
/phase-exec custom-shipping-module 1

# Commit Phase 1
git add .
git commit -m "Phase 1: Database models"

# Phase 2: Repository layer (fresh context = token savings!)
/phase-exec custom-shipping-module 2
```

Each phase starts fresh:
- ✅ Loads only current phase docs
- ✅ 50-70% token savings
- ✅ Focused implementation
- ✅ Clear checkpoints

---

### Combined Workflow (Best of Both)

**Use TDD + Documentation-Driven together:**

```bash
# 1. Create feature with phases
/feature advanced-pricing "Complex pricing with tier/group/custom logic"

# 2. Research and clarify
/clarify advanced-pricing
/research advanced-pricing

# 3. For each phase: Write tests, then execute
# Phase 1: Tier pricing
- Write tests: Test/Unit/Model/TierPricingTest.php
- Execute: /phase-exec advanced-pricing 1
- "I'm AFK, implement until tests pass"
- Commit when green

# Phase 2: Group pricing
- Write tests: Test/Unit/Model/GroupPricingTest.php
- Execute: /phase-exec advanced-pricing 2
- "I'm AFK, implement until tests pass"
- Commit when green
```

**Benefits:**
- ✅ TDD ensures correctness
- ✅ Fresh contexts save tokens
- ✅ Autonomous execution
- ✅ Safe checkpoints

---

## Code Quality Checklist

When creating modules based on this example:

### Architecture
- [ ] Service contracts for public API
- [ ] Repository pattern for data access
- [ ] Dependency injection (no ObjectManager)
- [ ] Proper use of plugins vs preferences
- [ ] Event observers for loose coupling

### Code Standards
- [ ] PSR-12 coding standards
- [ ] Proper PHPDoc blocks
- [ ] Type declarations (strict_types=1)
- [ ] Return type hints
- [ ] Private/protected visibility by default

### Testing
- [ ] Unit tests for business logic
- [ ] Integration tests if needed
- [ ] 100% passing before merge
- [ ] Mocks for dependencies

### Configuration
- [ ] module.xml with dependencies
- [ ] di.xml for DI configuration
- [ ] events.xml for observers
- [ ] Proper XML schema declarations

### Magento Best Practices
- [ ] No direct SQL queries (use repositories)
- [ ] No global state
- [ ] Cache-aware implementations
- [ ] Proper exception handling
- [ ] Logging for debugging

---

## Common Patterns to Copy

### Creating a Repository

1. **Copy** `Api/EntityRepositoryInterface.php` → Rename
2. **Copy** `Model/EntityRepository.php` → Implement interface
3. **Add preference** in `etc/di.xml`:
   ```xml
   <preference for="YourVendor\YourModule\Api\YourRepositoryInterface"
               type="YourVendor\YourModule\Model\YourRepository"/>
   ```

### Creating a Plugin

1. **Copy** `Plugin/ProductPlugin.php` → Rename and modify
2. **Configure** in `etc/di.xml`:
   ```xml
   <type name="Class\To\Intercept">
       <plugin name="your_plugin_name"
               type="YourVendor\YourModule\Plugin\YourPlugin"/>
   </type>
   ```

### Creating an Observer

1. **Copy** `Observer/ProductSaveAfter.php` → Rename and modify
2. **Configure** in `etc/events.xml`:
   ```xml
   <event name="event_name">
       <observer name="your_observer"
                 instance="YourVendor\YourModule\Observer\YourObserver"/>
   </event>
   ```

### Creating Tests

1. **Copy** `Test/Unit/Model/EntityRepositoryTest.php`
2. **Modify** for your class
3. **Run** with PHPUnit
4. **Use with TDD workflow**: Write tests first, then implement

---

## Learning Resources

### Magento DevDocs
- **Service Contracts:** https://developer.adobe.com/commerce/php/architecture/service-contracts/
- **Plugins:** https://developer.adobe.com/commerce/php/development/components/plugins/
- **Dependency Injection:** https://developer.adobe.com/commerce/php/development/components/dependency-injection/
- **Events and Observers:** https://developer.adobe.com/commerce/php/development/components/events-and-observers/

### Claude Code Workflows
- **TDD Workflow:** `.claude/skills/tdd-workflow/SKILL.md`
- **Documentation-Driven:** `.claude/skills/doc-driven-workflow/SKILL.md`
- **Magento 2 Guide:** `.claude/dev-docs/magento2-workflow-guide.md`

---

## Troubleshooting

### Module not showing up

```bash
# Clear cache and regenerate
rm -rf generated/code/* generated/metadata/*
php bin/magento setup:upgrade
php bin/magento module:status Acme_Example
```

### DI errors

```bash
# Recompile DI
rm -rf generated/code/*
php bin/magento setup:di:compile
```

### Plugin not working

```bash
# Clear cache
php bin/magento cache:flush
# Check di.xml configuration
# Verify plugin class exists
```

### Tests failing

```bash
# Run specific test with verbose output
vendor/bin/phpunit --verbose app/code/Acme/Example/Test/Unit/Model/EntityRepositoryTest.php
```

---

## Next Steps

1. **Study the code** - Read through each file to understand patterns
2. **Create your module** - Use `/m2-module` command
3. **Copy patterns** - Use this as reference for your implementations
4. **Write tests** - Follow EntityRepositoryTest.php example
5. **Use workflows** - Try TDD or Documentation-Driven approaches

---

## Support

For questions about:
- **Magento 2 patterns** → Use `magento2-dev-guidelines` skill
- **TDD workflow** → See `.claude/skills/tdd-workflow/SKILL.md`
- **Documentation-Driven** → See `.claude/skills/doc-driven-workflow/SKILL.md`
- **Troubleshooting** → See `.claude/dev-docs/TROUBLESHOOTING.md`

---

**This module demonstrates production-ready Magento 2 development with Claude Code workflows!**
