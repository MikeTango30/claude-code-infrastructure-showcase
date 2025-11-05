# Magento 2 Workflow Guide

Complete guide for using Reddit-validated workflows in Magento 2 development.

## 🎯 Overview

This guide adapts the proven Reddit workflows (TDD & Documentation-Driven) specifically for Magento 2 development. Same principles, Magento 2 patterns.

---

## Part 1: Setup (One-Time, 10 minutes)

### Step 1: Copy Workflow Files to Your Magento 2 Project

```bash
# In your Magento 2 root directory
mkdir -p .claude/skills
mkdir -p .claude/agents
mkdir -p .claude/commands

# Copy from showcase repo:

# Magento 2 specific skill
cp /path/to/showcase/.claude/skills/magento2-dev-guidelines ./.claude/skills/ -r

# Workflow skills
cp /path/to/showcase/.claude/skills/tdd-workflow ./.claude/skills/ -r
cp /path/to/showcase/.claude/skills/doc-driven-workflow ./.claude/skills/ -r

# Agents
cp /path/to/showcase/.claude/agents/phase-executor.md ./.claude/agents/
cp /path/to/showcase/.claude/agents/tdd-driver.md ./.claude/agents/

# Commands
cp /path/to/showcase/.claude/commands/feature.md ./.claude/commands/
cp /path/to/showcase/.claude/commands/clarify.md ./.claude/commands/
cp /path/to/showcase/.claude/commands/research.md ./.claude/commands/
cp /path/to/showcase/.claude/commands/phase-exec.md ./.claude/commands/
```

### Step 2: Create Documentation Directory

```bash
# In your Magento 2 root
mkdir -p documentation/modules
mkdir -p documentation/features
```

### Step 3: Test the Setup

```bash
# Open Claude Code in your Magento 2 project
# Type:
/feature
```

If command activates → Ready! ✅

---

## Part 2: Choose Your Workflow

### Use **TDD Workflow** for:
- ✅ New Magento 2 modules with clear requirements
- ✅ API endpoints (Web API)
- ✅ Repositories and service contracts
- ✅ Plugins and observers
- ✅ Admin grids and forms

**Example Magento 2 scenarios:**
- "Build a custom shipping method module"
- "Create a customer loyalty points system"
- "Implement product recommendations API"

### Use **Documentation-Driven Workflow** for:
- ✅ Complex module with multiple components
- ✅ Large customization projects
- ✅ Module refactoring
- ✅ Multi-store setup features

**Example Magento 2 scenarios:**
- "Build complete inventory management module"
- "Create B2B customer portal"
- "Implement advanced pricing rules engine"

### Use **Combined Workflow** for:
- ✅ Enterprise Magento 2 features
- ✅ Production-critical customizations
- ✅ Complex integrations (ERP, PIM, etc.)

**Example Magento 2 scenario:**
- "Build SAP ERP integration module with testing"

---

## Part 3: TDD Workflow for Magento 2 (Step-by-Step)

### Real Example: Custom Shipping Method Module

#### Step 1: Brainstorm with Claude

```
You: "I need to build a custom shipping method for Magento 2 that calculates
shipping cost based on product weight and distance to warehouse.
Should support multiple warehouses and cache rates for 1 hour."

Claude: [Asks clarifying questions]

You: [Answer questions]
```

**Claude's clarifying questions:**
- Carrier code and title?
- How to determine nearest warehouse?
- Rate calculation formula?
- Admin configuration needs?
- Tracking number support?

#### Step 2: Claude Creates Build Plan

```
Claude creates:
- Module structure: Vendor/ShippingMethod
- API contracts for rate calculation
- Configuration structure
- Test scenarios
- Implementation checklist
```

#### Step 3: Write Tests FIRST

```
You: "Write PHPUnit tests for this module. Include:
- Unit tests for rate calculator
- Unit tests for warehouse distance calculator
- Integration tests for carrier model
- Tests for admin configuration"

Claude: [Writes comprehensive test suite]
```

**Example test output:**

```php
<?php
// Test/Unit/Model/Carrier/CustomShippingTest.php
namespace Vendor\ShippingMethod\Test\Unit\Model\Carrier;

use PHPUnit\Framework\TestCase;
use Vendor\ShippingMethod\Model\Carrier\CustomShipping;
use Vendor\ShippingMethod\Model\RateCalculator;
use Magento\Quote\Model\Quote\Address\RateRequest;

class CustomShippingTest extends TestCase
{
    private CustomShipping $carrier;
    private RateCalculator $rateCalculator;

    protected function setUp(): void
    {
        $this->rateCalculator = $this->createMock(RateCalculator::class);

        // Setup carrier with mocked dependencies
        $this->carrier = new CustomShipping(
            /* ... dependencies ... */
            $this->rateCalculator
        );
    }

    public function testCollectRatesReturnsExpectedRate(): void
    {
        $request = $this->createMock(RateRequest::class);
        $request->method('getPackageWeight')->willReturn(10.0);
        $request->method('getDestPostcode')->willReturn('90210');

        $expectedRate = 15.99;
        $this->rateCalculator
            ->expects($this->once())
            ->method('calculateRate')
            ->willReturn($expectedRate);

        $result = $this->carrier->collectRates($request);

        $this->assertNotFalse($result);
        $this->assertEquals($expectedRate, $result->getPrice());
    }

    public function testCollectRatesReturnsFalseForInvalidRequest(): void
    {
        $request = $this->createMock(RateRequest::class);
        $request->method('getPackageWeight')->willReturn(0);

        $result = $this->carrier->collectRates($request);

        $this->assertFalse($result);
    }

    // ... 8 more tests
}
```

#### Step 4: Run Tests (RED Phase)

```bash
# Magento 2 test command
php bin/magento dev:tests:run unit --filter Vendor_ShippingMethod

# Output:
# ❌ 10 tests failing (EXPECTED - no implementation yet!)
```

#### Step 5: Go AFK - Let Claude Implement

```
You: "I'm going AFK for 3 hours. Please implement this Magento 2 module
to make all tests pass.

Checklist:
1. Create module structure (registration.php, module.xml, etc.)
2. Implement Model/Carrier/CustomShipping.php
3. Implement Model/RateCalculator.php
4. Implement Model/WarehouseLocator.php
5. Create etc/config.xml with defaults
6. Create etc/adminhtml/system.xml for configuration
7. Ensure all 10 unit tests pass
8. Write integration test
9. Refactor for production quality

Run tests after each step. Fix any failures. Provide summary when done."
```

#### Step 6: Claude Works Autonomously

**Claude will:**

```
Iteration 1: Create module structure
  ✓ registration.php
  ✓ etc/module.xml
  ✓ composer.json
  Run tests: ❌ 10 failing

Iteration 2: Implement carrier model
  ✓ Model/Carrier/CustomShipping.php
  Run tests: ❌ 7 failing, ✅ 3 passing

Iteration 3: Implement rate calculator
  ✓ Model/RateCalculator.php
  Run tests: ❌ 3 failing, ✅ 7 passing

Iteration 4: Implement warehouse locator
  ✓ Model/WarehouseLocator.php
  Run tests: ✅ 10/10 passing!

Iteration 5: Add admin configuration
  ✓ etc/config.xml
  ✓ etc/adminhtml/system.xml
  Run tests: ✅ Still passing

Iteration 6: Integration test
  ✓ Test/Integration/Model/Carrier/CustomShippingTest.php
  Run tests: ✅ 11/11 passing!

Refactor: Improve code quality
  ✓ Add dependency injection
  ✓ Add proper error handling
  ✓ Add caching for rates
  Run tests: ✅ All still passing
```

#### Step 7: Review Summary

```
✅ All 11 tests passing (10 unit + 1 integration)
✅ Custom shipping carrier implemented
✅ Rate calculation based on weight and distance
✅ Warehouse locator with nearest warehouse logic
✅ Admin configuration in Stores > Configuration > Sales > Shipping Methods
✅ Rate caching implemented (1 hour TTL)
✅ Proper error handling and logging
✅ Production-ready code

Module structure:
app/code/Vendor/ShippingMethod/
├── registration.php
├── etc/
│   ├── module.xml
│   ├── config.xml
│   ├── di.xml
│   └── adminhtml/
│       └── system.xml
├── Model/
│   ├── Carrier/
│   │   └── CustomShipping.php
│   ├── RateCalculator.php
│   └── WarehouseLocator.php
└── Test/
    ├── Unit/
    └── Integration/

Next steps:
1. Enable module: php bin/magento module:enable Vendor_ShippingMethod
2. Run setup: php bin/magento setup:upgrade
3. Configure in admin
4. Test checkout
```

#### Step 8: Verify and Deploy

```bash
# Enable module
php bin/magento module:enable Vendor_ShippingMethod

# Run setup
php bin/magento setup:upgrade

# Compile DI
php bin/magento setup:di:compile

# Run tests again
php bin/magento dev:tests:run unit --filter Vendor_ShippingMethod
# ✅ All passing

# Test in browser
# Go to checkout, verify shipping method appears

# If all works, commit
git add app/code/Vendor/ShippingMethod
git commit -m "feat: Add custom shipping method with weight-based rates"
```

---

## Part 4: Documentation-Driven Workflow for Magento 2

### Real Example: Complete Inventory Management Module

#### Step 1: Create Module Structure

```
/feature inventory-management "Complete inventory management module with multi-warehouse, stock transfer, and low stock alerts"
```

**Claude creates:**

```
documentation/modules/inventory-management/
├── architecture.md
├── context.md
├── requirements.md
├── research.md
├── design.md
├── tasks.md
└── plan.md
```

#### Step 2: Clarify Requirements

```
/clarify inventory-management
```

**Claude asks ~15 critical questions:**

```
Critical Questions:

1. Warehouse Management
   - How many warehouses?
   - Warehouse priority rules?
   - Transfer approval workflow?

2. Stock Allocation
   - FIFO, LIFO, or custom?
   - Reserved stock handling?
   - Backorder support?

3. Multi-Source Inventory (MSI)
   - Use Magento MSI or custom?
   - Integrate with existing MSI?

4. Low Stock Alerts
   - Email notifications?
   - Admin dashboard widget?
   - Per-warehouse or global?

5. API Requirements
   - REST API for stock updates?
   - Webhook support?
   - Third-party integration (ERP)?

6. Admin UI
   - Grid for stock levels?
   - Transfer workflow UI?
   - Reporting dashboards?

[... 9 more questions]
```

**You answer each question.**

#### Step 3: Research Existing Patterns

```
/research inventory-management
```

**Claude analyzes YOUR Magento codebase:**

```
Research Complete for: inventory-management

Magento Core Patterns Found:
✓ MSI (Multi-Source Inventory) modules: Magento_Inventory*
✓ Stock management: Magento_CatalogInventory
✓ Admin grid UI component: vendor/magento/module-ui/view/base/ui_component
✓ Admin form UI component: similar pattern
✓ Observer pattern: catalog_product_save_after event
✓ Web API: webapi.xml pattern in multiple modules

Recommendations:
→ Extend Magento MSI rather than replace (InventoryApi interfaces)
→ Use UI components for admin grids (not custom HTML)
→ Use data patches for initial warehouse setup
→ Use repository pattern consistent with Magento standards
→ Plugin into MSI stock management for custom logic

Technical Constraints:
- Must maintain compatibility with Magento 2.4.x MSI
- Cannot override core MSI without breaking extensions
- Admin UI must follow Magento UI component standards

Updated: documentation/modules/inventory-management/research.md
```

#### Step 4: Review the Plan

```
You: "Show me the implementation plan"
```

**plan.md:**

```markdown
# Plan: Inventory Management Module

## Overall Goal
Build comprehensive inventory management module extending Magento MSI with
multi-warehouse stock transfers, low stock alerts, and advanced reporting.

## Phases
- [ ] Phase 1: Module structure and database schema (3-4 hours)
- [ ] Phase 2: Stock transfer models and repositories (4-5 hours)
- [ ] Phase 3: Admin UI - Warehouse grid and transfer form (5-6 hours)
- [ ] Phase 4: Low stock alert system (3-4 hours)
- [ ] Phase 5: Web API and integration (4-5 hours)
- [ ] Phase 6: Reporting and dashboards (5-6 hours)
- [ ] Phase 7: Testing and optimization (4-5 hours)

## Current Status
Status: Planning complete
Current Phase: Ready for Phase 1

## Architecture Decisions
- Extend Magento MSI, don't replace
- Use UI components for all admin interfaces
- Repository pattern for data access
- Observer pattern for event handling
- Plugin pattern for extending MSI logic

## Dependencies
- Magento_Inventory (MSI)
- Magento_InventoryApi
- Magento_Catalog
- Magento_Backend
```

#### Step 5: Execute Phase 1 (Fresh Thread!)

**Start fresh conversation:**

```
/phase-exec inventory-management 1
```

**Claude:**

```
Loading context for Phase 1: Module Structure & Database

✓ Read: plan.md (overall goal)
✓ Read: design.md (Phase 1 section only)
✓ Read: research.md (Magento patterns)

Context loaded: 2,500 tokens (vs 10,000+ without phase isolation)

Implementing Phase 1...

Tasks:
- [✓] Create registration.php
- [✓] Create etc/module.xml with MSI dependencies
- [✓] Create composer.json
- [✓] Create db_schema.xml for warehouse_transfer table
- [✓] Create db_schema_whitelist.json
- [✓] Create API interfaces (Api/Data/TransferInterface.php)
- [✓] Create data patch for sample warehouses

✅ Phase 1 Complete!

Files created:
app/code/Vendor/InventoryManagement/
├── registration.php
├── composer.json
├── etc/
│   ├── module.xml (depends on Magento_Inventory*)
│   ├── db_schema.xml (warehouse_transfer table)
│   └── db_schema_whitelist.json
├── Api/
│   └── Data/
│       └── TransferInterface.php
└── Setup/
    └── Patch/
        └── Data/
            └── AddSampleWarehouses.php

Database schema:
- warehouse_transfer table with columns:
  - entity_id, source_code, destination_code, sku, qty,
    status, created_at, updated_at

Next Steps:
1. Enable module: php bin/magento module:enable Vendor_InventoryManagement
2. Run setup: php bin/magento setup:upgrade
3. Verify: Check database for warehouse_transfer table
4. Commit changes
5. Clear context (Esc key)
6. Execute Phase 2: /phase-exec inventory-management 2

Updated: documentation/modules/inventory-management/plan.md
```

#### Step 6: Checkpoint

```bash
# Enable and test
php bin/magento module:enable Vendor_InventoryManagement
php bin/magento setup:upgrade

# Verify table exists
php bin/magento db:schema:describe warehouse_transfer
# ✅ Table exists

# Commit
git add app/code/Vendor/InventoryManagement
git commit -m "feat: Phase 1 - Inventory management module structure and schema"

# Clear context (Esc key in Claude Code)
```

**Why this matters:** 2,500 tokens for Phase 1 vs 10,000+ in single thread!

#### Step 7: Execute Phase 2 (Fresh Thread!)

```
/phase-exec inventory-management 2
```

**Claude:**

```
Loading context for Phase 2: Stock Transfer Models & Repositories

✓ Read: plan.md (Phase 1 complete, starting Phase 2)
✓ Read: design.md (Phase 2 section)

Context from Phase 1 (from plan.md):
- Module enabled: Vendor_InventoryManagement
- Table exists: warehouse_transfer
- API interface: Api/Data/TransferInterface.php

Implementing Phase 2: Stock Transfer Models & Repositories

Tasks:
- [✓] Create Model/Transfer.php (extends AbstractModel)
- [✓] Create Model/ResourceModel/Transfer.php
- [✓] Create Model/ResourceModel/Transfer/Collection.php
- [✓] Create Model/TransferRepository.php (implements repository interface)
- [✓] Configure DI in etc/di.xml
- [✓] Write unit tests for repository

✅ Phase 2 Complete!

Files created:
app/code/Vendor/InventoryManagement/
├── Model/
│   ├── Transfer.php
│   ├── ResourceModel/
│   │   ├── Transfer.php
│   │   └── Transfer/
│   │       └── Collection.php
│   └── TransferRepository.php
├── etc/
│   └── di.xml
└── Test/
    └── Unit/
        └── Model/
            └── TransferRepositoryTest.php

Tests: ✅ 5/5 passing

Next: Commit, clear context, execute Phase 3 (Admin UI)
```

**Commit:**

```bash
git add app/code/Vendor/InventoryManagement
git commit -m "feat: Phase 2 - Stock transfer models and repositories"
# Clear context
```

#### Step 8: Repeat for Remaining Phases

```
/phase-exec inventory-management 3
# Admin UI grids and forms
# Commit, clear

/phase-exec inventory-management 4
# Low stock alert system
# Commit, clear

/phase-exec inventory-management 5
# Web API
# Commit, clear

/phase-exec inventory-management 6
# Reporting dashboards
# Commit, clear

/phase-exec inventory-management 7
# Testing and optimization
# Commit, clear
```

#### Step 9: Module Complete!

```markdown
# plan.md final state:

## Phases
- [x] Phase 1: Module structure and database ✅
- [x] Phase 2: Stock transfer models and repositories ✅
- [x] Phase 3: Admin UI - Warehouse grid and transfer form ✅
- [x] Phase 4: Low stock alert system ✅
- [x] Phase 5: Web API and integration ✅
- [x] Phase 6: Reporting and dashboards ✅
- [x] Phase 7: Testing and optimization ✅

## Current Status
Status: Complete
All phases implemented and tested

## Token Usage Comparison
Traditional single-thread approach: ~55,000 tokens
Phase-based approach: ~16,500 tokens
Savings: 70%

## Module Statistics
- Total files: 47
- Models: 8
- Repositories: 4
- Admin UI components: 5
- Web API endpoints: 6
- Unit tests: 23
- Integration tests: 8
- All tests passing: ✅

## Deployment Checklist
- [✅] Module enabled
- [✅] Setup upgrade run
- [✅] DI compiled
- [✅] Static content deployed
- [✅] All tests passing
- [✅] Admin UI tested
- [✅] API endpoints tested
- [✅] Documentation updated
```

---

## Part 5: Combined Workflow for Magento 2

### Real Example: SAP ERP Integration Module

#### Step 1-3: Use Documentation-Driven for Planning

```
/feature sap-integration "Complete SAP ERP integration for orders, products, and customers"
/clarify sap-integration
/research sap-integration
```

**Result:** 7 phases planned with clear documentation.

#### Step 4: Add TDD to Each Phase

**Phase 1: SAP API Client**

```
Before /phase-exec:
1. Write tests for SAP API client
2. Write tests for authentication
3. Write tests for error handling

Then: /phase-exec sap-integration 1
- Claude implements until all tests pass
- Commit when green
```

**Phase 2: Order Synchronization**

```
Before /phase-exec:
1. Write tests for order export to SAP
2. Write tests for SAP order response handling
3. Write tests for retry logic

Then: /phase-exec sap-integration 2
- Tests guide implementation
- Commit when green
```

**Repeat for all 7 phases.**

### Benefits

✅ **Token efficiency** (Documentation-Driven): 65% savings
✅ **Quality assurance** (TDD): All code tested
✅ **Safe checkpoints**: Revert to any phase
✅ **Production-ready**: Tested integration

---

## Part 6: Magento 2 Specific Tips

### Tip 1: Module Dependencies

**Always clarify module dependencies upfront:**

```
You: "This module needs to work with MSI. What dependencies?"

Claude: "Add to module.xml:
<sequence>
    <module name="Magento_Inventory"/>
    <module name="Magento_InventoryApi"/>
    <module name="Magento_Catalog"/>
</sequence>"
```

### Tip 2: Admin Configuration

**Phase dedicated to admin config:**

```
Phase X: Admin Configuration
- etc/adminhtml/system.xml
- etc/config.xml (defaults)
- etc/acl.xml (permissions)
- Test in Stores > Configuration
```

### Tip 3: Compilation and Deployment

**After each phase:**

```bash
# Don't forget these
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f en_US

# Or use deployment mode
php bin/magento deploy:mode:set developer
```

### Tip 4: Cache Management

**During development:**

```bash
# Disable cache types you're working on
php bin/magento cache:disable layout block_html full_page

# Or flush frequently
php bin/magento cache:flush
```

### Tip 5: Testing in Magento 2

**Test command structure:**

```bash
# Unit tests for specific module
php bin/magento dev:tests:run unit --filter Vendor_Module

# Integration tests
php bin/magento dev:tests:run integration --filter Vendor_Module

# Single test class
php bin/magento dev:tests:run unit --filter TransferRepositoryTest

# With coverage (if PHPUnit configured)
php bin/magento dev:tests:run unit --filter Vendor_Module --coverage-html reports/
```

---

## Part 7: Magento 2 Quick Reference

### TDD Workflow for Magento 2

```
1. Clarify module requirements
2. Define API interfaces
3. Write PHPUnit tests (unit + integration)
4. Run: php bin/magento dev:tests:run unit --filter Vendor_Module
   (All should fail initially)
5. Say: "I'm going AFK, implement until tests pass"
6. Claude implements autonomously
7. Review when tests pass
8. Enable module: php bin/magento module:enable Vendor_Module
9. Run setup: php bin/magento setup:upgrade
10. Deploy and test

Time: 2-3 days for module
Quality: ⭐⭐⭐⭐⭐ (all tests passing)
```

### Documentation-Driven for Magento 2

```
1. /feature [module-name] [description]
2. /clarify [module-name]
3. /research [module-name]
4. For each phase:
   - /phase-exec [module-name] [N]
   - php bin/magento module:enable (if Phase 1)
   - php bin/magento setup:upgrade
   - Test phase functionality
   - git commit
   - Clear context (Esc)
5. Repeat until all phases done
6. Full module testing
7. Deploy to production

Token savings: 60-70%
Safe checkpoints: After each phase
```

### Common Magento 2 Phases

```
Phase 1: Module structure, interfaces, schema
Phase 2: Models, repositories, resource models
Phase 3: Plugins and observers
Phase 4: Admin UI (grids, forms, config)
Phase 5: Frontend (blocks, templates, layouts)
Phase 6: Web API (REST/SOAP)
Phase 7: Cron jobs and email templates
Phase 8: Testing and optimization
```

---

## Part 8: Real Commands for Your Next Magento 2 Module

**Example: "Customer Wishlist Sharing Module"**

```bash
# Step 1: Create structure
/feature wishlist-sharing "Allow customers to share wishlists via email with custom messaging"

# Step 2: Clarify
/clarify wishlist-sharing
# Answer questions about:
# - Email template design
# - Recipient limit
# - Public link option
# - Social media sharing
# - Admin approval needed?

# Step 3: Research
/research wishlist-sharing
# Claude finds:
# - Existing wishlist: Magento_Wishlist
# - Email templates: Magento_Email
# - URL generation patterns

# Step 4: Execute phases
/phase-exec wishlist-sharing 1  # Module structure, extend wishlist table
# Enable, setup:upgrade, commit, clear

/phase-exec wishlist-sharing 2  # Models for shared wishlist
# Test, commit, clear

/phase-exec wishlist-sharing 3  # Email sending service
# Test emails, commit, clear

/phase-exec wishlist-sharing 4  # Frontend UI (share button, form)
# Test in browser, commit, clear

/phase-exec wishlist-sharing 5  # Admin configuration
# Test in admin, commit, clear

# Done! 🎉
```

---

## Part 9: Measuring Success in Magento 2

### Track Per Module

```markdown
Module: [Vendor_ModuleName]
Workflow: [TDD/Documentation-Driven/Combined]
Magento Version: 2.4.x
Phases: [number]
Token usage: ~[X]k tokens
Time: [X] days
Files created: [count]
Tests: [X/X] passing
Compilation: ✅ No errors
Production deployment: ✅ Success
Post-deployment issues: [count]
```

### Compare to Old Approach

**Before workflows:**
- Module took: ? weeks
- Token usage: High
- Test coverage: ?
- Post-deployment bugs: ?
- Rework needed: ?

**After workflows:**
- Module took: 2-4 days ✅
- Token usage: 60-70% less ✅
- Test coverage: Comprehensive ✅
- Bugs: Minimal (caught by tests) ✅
- Rework: Rare ✅

---

## 🚀 You're Ready for Magento 2!

**Your first Magento 2 module:**
1. Pick a real module you need
2. Choose workflow:
   - Simple module → TDD
   - Complex module → Documentation-Driven
   - Enterprise module → Combined
3. Follow the steps
4. Experience the efficiency!

**Magento 2 specific benefits:**
- ✅ Proper module structure from the start
- ✅ Tests ensure compatibility
- ✅ Phase-based = manageable complexity
- ✅ Follows Magento best practices
- ✅ Production-ready code

**Remember:**
- Tests first = quality modules
- Fresh threads = token efficiency
- Clarifying questions = no rework
- Phase isolation = safe development

**Good luck building amazing Magento 2 modules!** 🎉

---

**Resources:**
- [Magento 2 DevDocs](https://devdocs.magento.com/)
- [Magento 2 Best Practices](https://experienceleague.adobe.com/docs/commerce-operations/implementation-playbook/best-practices/development/overview.html)
- [This Repo's Workflow Documentation](./workflow-best-practices.md)
