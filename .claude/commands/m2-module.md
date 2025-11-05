---
description: Create Magento 2 module structure with proper conventions
argument-hint: "<Vendor_ModuleName> <brief-description>"
---

You are a Magento 2 module creation specialist. Create a complete Magento 2 module structure for: $ARGUMENTS

## Instructions

1. **Parse the arguments**:
   - First part: Vendor_ModuleName (e.g., "Acme_CustomShipping")
   - Remaining: Brief description

2. **Extract components**:
   ```
   Full module name: Vendor_ModuleName
   Vendor: Vendor
   Module: ModuleName
   Path: app/code/Vendor/ModuleName
   Namespace: Vendor\ModuleName
   ```

3. **Create complete module structure**:

### registration.php
```php
<?php
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    '[Vendor]_[ModuleName]',
    __DIR__
);
```

### etc/module.xml
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="[Vendor]_[ModuleName]" setup_version="1.0.0">
        <sequence>
            <!-- Add module dependencies here -->
            <!-- <module name="Magento_Catalog"/> -->
        </sequence>
    </module>
</config>
```

### composer.json
```json
{
    "name": "[vendor]/module-[modulename]",
    "description": "[Description from arguments]",
    "type": "magento2-module",
    "version": "1.0.0",
    "license": "proprietary",
    "authors": [
        {
            "name": "[Your Name/Company]",
            "email": "[your-email@example.com]"
        }
    ],
    "require": {
        "php": "~7.4.0||~8.1.0",
        "magento/framework": "*"
    },
    "autoload": {
        "files": ["registration.php"],
        "psr-4": {
            "[Vendor]\\[ModuleName]\\": ""
        }
    }
}
```

### etc/di.xml (base structure)
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <!-- Dependency injection configuration -->
</config>
```

### etc/acl.xml (base structure)
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Acl/etc/acl.xsd">
    <acl>
        <resources>
            <resource id="Magento_Backend::admin">
                <resource id="[Vendor]_[ModuleName]::config"
                          title="[Module Title]"
                          sortOrder="100"/>
            </resource>
        </resources>
    </acl>
</config>
```

### README.md
```markdown
# [Vendor]_[ModuleName]

## Description
[Description from arguments]

## Installation

### Via Composer (recommended)
```bash
composer require [vendor]/module-[modulename]
php bin/magento module:enable [Vendor]_[ModuleName]
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
```

### Manual Installation
1. Create directory: `app/code/[Vendor]/[ModuleName]`
2. Copy all files to the directory
3. Run:
```bash
php bin/magento module:enable [Vendor]_[ModuleName]
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
```

## Configuration
[Configuration instructions if applicable]

## Features
- [Feature 1]
- [Feature 2]

## Requirements
- Magento 2.4.x
- PHP 7.4 or 8.1

## License
Proprietary

## Support
[Support information]
```

4. **Create directory structure**:
```
app/code/[Vendor]/[ModuleName]/
├── Api/
│   └── Data/
├── Block/
├── Console/
├── Controller/
│   ├── Adminhtml/
│   └── Index/
├── Cron/
├── etc/
│   ├── adminhtml/
│   ├── frontend/
│   ├── acl.xml
│   ├── di.xml
│   ├── module.xml
│   └── config.xml
├── Helper/
├── Model/
│   └── ResourceModel/
├── Observer/
├── Plugin/
├── Setup/
│   └── Patch/
│       ├── Data/
│       └── Schema/
├── Test/
│   ├── Unit/
│   └── Integration/
├── Ui/
├── view/
│   ├── adminhtml/
│   │   ├── layout/
│   │   ├── templates/
│   │   ├── ui_component/
│   │   └── web/
│   └── frontend/
│       ├── layout/
│       ├── templates/
│       ├── web/
│       │   ├── css/
│       │   ├── js/
│       │   └── template/
│       └── requirejs-config.js
├── composer.json
├── registration.php
└── README.md
```

5. **After creation, display setup instructions**:

```
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Magento 2 Module Created: [Vendor]_[ModuleName]
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Module Location:
📁 app/code/[Vendor]/[ModuleName]

Files Created:
✓ registration.php
✓ etc/module.xml
✓ etc/di.xml
✓ etc/acl.xml
✓ composer.json
✓ README.md
✓ Directory structure

Next Steps:

1. Enable the module:
   php bin/magento module:enable [Vendor]_[ModuleName]

2. Run setup upgrade:
   php bin/magento setup:upgrade

3. Compile dependency injection:
   php bin/magento setup:di:compile

4. Deploy static content (if needed):
   php bin/magento setup:static-content:deploy -f

5. Clear cache:
   php bin/magento cache:flush

6. Verify module is enabled:
   php bin/magento module:status [Vendor]_[ModuleName]

Development Workflow Options:

📝 Use TDD Workflow:
   - Write tests in Test/Unit/ first
   - Implement features to make tests pass
   - Perfect for: Service contracts, repositories, business logic

📝 Use Documentation-Driven Workflow:
   - /feature [module-name] "[description]"
   - Break into phases
   - Fresh context per phase
   - Perfect for: Complex modules, multiple components

📝 Use Combined Workflow:
   - Plan with /feature
   - Write tests per phase
   - Execute with /phase-exec
   - Perfect for: Enterprise modules, mission-critical code

Module Dependencies:
To add Magento module dependencies, edit etc/module.xml:
<sequence>
    <module name="Magento_Catalog"/>
    <module name="Magento_Customer"/>
    <!-- Add more as needed -->
</sequence>

Common Next Files to Create:

For Database Tables:
✓ etc/db_schema.xml
✓ etc/db_schema_whitelist.json

For API:
✓ Api/[Entity]RepositoryInterface.php
✓ Api/Data/[Entity]Interface.php
✓ Model/[Entity]Repository.php
✓ etc/webapi.xml

For Admin Configuration:
✓ etc/adminhtml/system.xml
✓ etc/config.xml

For Admin Menu:
✓ etc/adminhtml/menu.xml

For Plugins:
✓ Plugin/[TargetClass]Plugin.php
✓ Configure in etc/di.xml

For Observers:
✓ Observer/[EventName]Observer.php
✓ etc/events.xml

For Console Commands:
✓ Console/Command/[CommandName].php
✓ etc/di.xml configuration

Ready to develop! 🚀
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

## Quality Standards
- Follow Magento 2 coding standards
- Use proper PSR-4 autoloading
- Include proper PHPDoc blocks
- Follow dependency injection principles
- Use interfaces for public API
- Include README with clear instructions

## Example Usage

```
/m2-module Acme_CustomShipping "Custom shipping method with weight-based rates"
```

Creates:
```
app/code/Acme/CustomShipping/
├── registration.php
├── composer.json
├── etc/
│   ├── module.xml
│   ├── di.xml
│   └── acl.xml
├── README.md
└── [full directory structure]
```

## Integration with Workflows

After creating module with `/m2-module`:

### For TDD Workflow:
```
1. /m2-module Acme_Feature "Feature description"
2. Create Test/Unit/ test files
3. Write tests for API interfaces
4. Say "I'm going AFK, implement until tests pass"
5. Claude implements with TDD approach
```

### For Documentation-Driven Workflow:
```
1. /m2-module Acme_Feature "Feature description"
2. /feature acme-feature "Detailed description"
3. /clarify acme-feature
4. /research acme-feature
5. /phase-exec acme-feature 1
6. Continue phase by phase
```

### For Combined Workflow:
```
1. /m2-module Acme_Feature "Feature description"
2. /feature acme-feature "Detailed description"
3. For each phase:
   - Write tests
   - /phase-exec acme-feature [N]
   - Tests guide implementation
   - Commit when green
```

## Notes

- Module structure follows Magento 2.4.x conventions
- Compatible with both Magento Open Source and Adobe Commerce
- Includes base files required for module registration
- Ready for development with proper autoloading
- Follows PSR-4 standard for namespace
- Includes proper XML schema declarations

---

**Use this command to quickly scaffold Magento 2 modules, then use workflows to implement features efficiently!**
