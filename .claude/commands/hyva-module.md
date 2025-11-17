---
description: Create Hyvä Themes compatibility module structure with Alpine.js components, Tailwind CSS, and ViewModels
argument-hint: "<Vendor_ModuleName> <brief-description>"
---

You are creating a Hyvä Themes compatibility module for Magento 2.

## Arguments Provided

- **Module Name**: `{ARG1}` (format: Vendor_ModuleName)
- **Description**: `{ARG2}`

## Task

Create a complete Hyvä compatibility module structure with:
1. Standard Magento 2 module files (registration.php, module.xml, composer.json)
2. Hyvä-specific Alpine.js components
3. Tailwind CSS integration
4. ViewModel for data preparation
5. Layout XML for Hyvä theme
6. Example templates with Alpine.js and Tailwind

## Module Structure to Create

```
app/code/{Vendor}/{ModuleName}/
├── registration.php
├── composer.json
├── etc/
│   ├── module.xml
│   └── frontend/
│       └── di.xml
├── ViewModel/
│   └── ComponentData.php
├── view/frontend/
│   ├── layout/
│   │   └── catalog_product_view.xml
│   ├── templates/
│   │   └── product/
│   │       └── custom-component.phtml
│   └── tailwind/
│       └── components/
│           └── product-component.css
└── README.md
```

## File Templates

### 1. registration.php

```php
<?php
/**
 * {Vendor}_{ModuleName} module registration
 *
 * @category  {Vendor}
 * @package   {Vendor}_{ModuleName}
 */
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    '{Vendor}_{ModuleName}',
    __DIR__
);
```

### 2. etc/module.xml

```xml
<?xml version="1.0"?>
<!--
/**
 * Module declaration - Hyvä compatibility module
 *
 * @category  {Vendor}
 * @package   {Vendor}_{ModuleName}
 */
-->
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="{Vendor}_{ModuleName}" setup_version="1.0.0">
        <sequence>
            <!-- Hyvä Themes dependency -->
            <module name="Hyva_Theme"/>
            <!-- Add third-party module if this is compatibility module -->
            <!-- <module name="ThirdParty_Module"/> -->
        </sequence>
    </module>
</config>
```

### 3. composer.json

```json
{
    "name": "{vendor-lowercase}/{module-name-lowercase}",
    "description": "{ARG2} - Hyvä Themes compatibility",
    "type": "magento2-module",
    "version": "1.0.0",
    "license": "proprietary",
    "authors": [
        {
            "name": "{Vendor}",
            "email": "dev@{vendor-lowercase}.com"
        }
    ],
    "require": {
        "php": "~7.4.0||~8.1.0||~8.2.0",
        "magento/framework": "*",
        "hyva-themes/magento2-default-theme": "^1.3"
    },
    "autoload": {
        "files": ["registration.php"],
        "psr-4": {
            "{Vendor}\\{ModuleName}\\": ""
        }
    }
}
```

### 4. ViewModel/ComponentData.php

```php
<?php
/**
 * Component data ViewModel
 * Prepares server-side data for Alpine.js components
 *
 * @category  {Vendor}
 * @package   {Vendor}_{ModuleName}
 */
declare(strict_types=1);

namespace {Vendor}\{ModuleName}\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\SerializerInterface;

class ComponentData implements ArgumentInterface
{
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * Get component configuration data
     *
     * @return array
     */
    public function getComponentConfig(): array
    {
        return [
            'enabled' => true,
            'showLabels' => true,
            'animationDuration' => 300,
            // Add your configuration
        ];
    }

    /**
     * Get component configuration as JSON
     *
     * @return string
     */
    public function getComponentConfigJson(): string
    {
        return $this->serializer->serialize($this->getComponentConfig());
    }

    /**
     * Get component data for specific context
     *
     * @param mixed $context
     * @return array
     */
    public function getDataForContext($context): array
    {
        // Prepare data based on context
        return [
            'id' => $context->getId(),
            'name' => $context->getName(),
            // Add your data
        ];
    }
}
```

### 5. view/frontend/layout/catalog_product_view.xml

```xml
<?xml version="1.0"?>
<!--
/**
 * Product view layout - Hyvä compatibility
 *
 * @category  {Vendor}
 * @package   {Vendor}_{ModuleName}
 */
-->
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="product.info.main">
            <block class="Magento\Framework\View\Element\Template"
                   name="{vendor}.{module}.component"
                   template="{Vendor}_{ModuleName}::product/custom-component.phtml"
                   after="-">
                <arguments>
                    <argument name="view_model" xsi:type="object">{Vendor}\{ModuleName}\ViewModel\ComponentData</argument>
                </arguments>
            </block>
        </referenceContainer>
    </body>
</page>
```

### 6. view/frontend/templates/product/custom-component.phtml

```php
<?php
/**
 * Custom Hyvä component template
 * Uses Alpine.js for reactivity and Tailwind CSS for styling
 *
 * @var \Magento\Framework\View\Element\Template $block
 * @var \Magento\Framework\Escaper $escaper
 * @var \Hyva\Theme\Model\ViewModelRegistry $viewModels
 * @var \{Vendor}\{ModuleName}\ViewModel\ComponentData $componentViewModel
 */

// Get product from parent block
$product = $block->getParentBlock()->getProduct();

// Get ViewModel
$componentViewModel = $block->getData('view_model');
$config = $componentViewModel->getComponentConfig();
?>

<div x-data="init{Vendor}{ModuleName}Component()"
     x-init="init()"
     class="my-6 p-6 bg-white rounded-lg shadow-md">

    <!-- Component Header -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-900">
            <?= $escaper->escapeHtml(__('Custom Component')) ?>
        </h3>

        <button @click="toggle()"
                class="text-primary hover:text-primary-darker transition-colors">
            <svg class="w-6 h-6"
                 :class="{'rotate-180': isOpen}"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
    </div>

    <!-- Component Content -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="space-y-4">

        <!-- Example: Product info display -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded-md">
                <p class="text-sm text-gray-600 mb-1"><?= $escaper->escapeHtml(__('Product Name')) ?></p>
                <p class="font-semibold" x-text="productName"></p>
            </div>

            <div class="p-4 bg-gray-50 rounded-md">
                <p class="text-sm text-gray-600 mb-1"><?= $escaper->escapeHtml(__('SKU')) ?></p>
                <p class="font-semibold" x-text="productSku"></p>
            </div>
        </div>

        <!-- Example: Interactive element -->
        <div class="flex items-center gap-4">
            <label for="component-option" class="text-sm font-medium text-gray-700">
                <?= $escaper->escapeHtml(__('Select Option')) ?>
            </label>
            <select id="component-option"
                    x-model="selectedOption"
                    @change="onOptionChange($event)"
                    class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="option1"><?= $escaper->escapeHtml(__('Option 1')) ?></option>
                <option value="option2"><?= $escaper->escapeHtml(__('Option 2')) ?></option>
                <option value="option3"><?= $escaper->escapeHtml(__('Option 3')) ?></option>
            </select>
        </div>

        <!-- Example: Action button -->
        <button type="button"
                @click="performAction()"
                :disabled="loading"
                class="w-full md:w-auto px-6 py-3 bg-primary text-white font-semibold rounded-md hover:bg-primary-darker transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
            <span x-show="!loading"><?= $escaper->escapeHtml(__('Perform Action')) ?></span>
            <span x-show="loading"><?= $escaper->escapeHtml(__('Processing...')) ?></span>
        </button>

        <!-- Example: Status message -->
        <div x-show="showMessage"
             x-transition
             class="p-4 rounded-md"
             :class="{
                 'bg-green-100 text-green-800': messageType === 'success',
                 'bg-red-100 text-red-800': messageType === 'error',
                 'bg-blue-100 text-blue-800': messageType === 'info'
             }">
            <p x-text="message"></p>
        </div>
    </div>
</div>

<script>
function init{Vendor}{ModuleName}Component() {
    return {
        // Component state
        isOpen: <?= $config['enabled'] ? 'true' : 'false' ?>,
        loading: false,
        showMessage: false,
        message: '',
        messageType: 'info',
        selectedOption: 'option1',

        // Product data from PHP
        productName: '<?= $escaper->escapeJs($product->getName()) ?>',
        productSku: '<?= $escaper->escapeJs($product->getSku()) ?>',
        productId: <?= (int)$product->getId() ?>,

        // Configuration from ViewModel
        config: <?= /* @noEscape */ $componentViewModel->getComponentConfigJson() ?>,

        /**
         * Initialize component
         */
        init() {
            console.log('Component initialized with config:', this.config);

            // Listen for custom events
            window.addEventListener('custom-event', (event) => {
                this.handleCustomEvent(event.detail);
            });
        },

        /**
         * Toggle component visibility
         */
        toggle() {
            this.isOpen = !this.isOpen;
        },

        /**
         * Handle option change
         */
        onOptionChange(event) {
            console.log('Option changed to:', this.selectedOption);
            this.showNotification('Option selected: ' + this.selectedOption, 'info');
        },

        /**
         * Perform async action (example)
         */
        async performAction() {
            this.loading = true;
            this.showMessage = false;

            try {
                // Example: API call
                const response = await fetch('/rest/V1/custom-endpoint', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        productId: this.productId,
                        option: this.selectedOption
                    })
                });

                if (!response.ok) {
                    throw new Error('Request failed');
                }

                const data = await response.json();
                this.showNotification('Action completed successfully!', 'success');

                // Dispatch custom event for other components
                this.dispatchEvent('action-completed', data);

            } catch (error) {
                console.error('Action error:', error);
                this.showNotification('Action failed. Please try again.', 'error');
            } finally {
                this.loading = false;
            }
        },

        /**
         * Show notification message
         */
        showNotification(message, type = 'info') {
            this.message = message;
            this.messageType = type;
            this.showMessage = true;

            // Auto-hide after 3 seconds
            setTimeout(() => {
                this.showMessage = false;
            }, 3000);
        },

        /**
         * Dispatch custom event
         */
        dispatchEvent(eventName, detail = {}) {
            window.dispatchEvent(new CustomEvent(eventName, {
                detail: detail,
                bubbles: true
            }));
        },

        /**
         * Handle custom event from other components
         */
        handleCustomEvent(detail) {
            console.log('Custom event received:', detail);
            // Handle event
        }
    }
}
</script>
```

### 7. view/frontend/tailwind/components/product-component.css

```css
/**
 * Tailwind component styles for {Vendor}_{ModuleName}
 *
 * These styles will be processed by Tailwind's @apply directive
 */

@layer components {
    .product-component-container {
        @apply my-6 p-6 bg-white rounded-lg shadow-md;
    }

    .product-component-header {
        @apply flex items-center justify-between mb-4;
    }

    .product-component-title {
        @apply text-xl font-bold text-gray-900;
    }

    .product-component-toggle {
        @apply text-primary hover:text-primary-darker transition-colors;
    }

    .product-component-content {
        @apply space-y-4;
    }

    .product-component-grid {
        @apply grid grid-cols-1 md:grid-cols-2 gap-4;
    }

    .product-component-info-box {
        @apply p-4 bg-gray-50 rounded-md;
    }

    .product-component-label {
        @apply text-sm text-gray-600 mb-1;
    }

    .product-component-value {
        @apply font-semibold;
    }

    .product-component-button {
        @apply w-full md:w-auto px-6 py-3 bg-primary text-white font-semibold rounded-md
               hover:bg-primary-darker transition-colors
               disabled:opacity-50 disabled:cursor-not-allowed;
    }

    .product-component-message {
        @apply p-4 rounded-md;
    }

    .product-component-message-success {
        @apply bg-green-100 text-green-800;
    }

    .product-component-message-error {
        @apply bg-red-100 text-red-800;
    }

    .product-component-message-info {
        @apply bg-blue-100 text-blue-800;
    }
}
```

### 8. README.md

```markdown
# {Vendor}_{ModuleName}

{ARG2}

## Overview

Hyvä Themes compatibility module that provides {description} functionality using Alpine.js and Tailwind CSS.

## Requirements

- Magento 2.4.x
- Hyvä Themes 1.3+
- PHP 7.4+ or 8.1+

## Installation

### Composer (recommended)

\`\`\`bash
composer require {vendor-lowercase}/{module-name-lowercase}
php bin/magento module:enable {Vendor}_{ModuleName}
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
\`\`\`

### Manual Installation

1. Create directory: \`app/code/{Vendor}/{ModuleName}\`
2. Copy module files to the directory
3. Run:

\`\`\`bash
php bin/magento module:enable {Vendor}_{ModuleName}
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
\`\`\`

## Features

- ✅ Alpine.js reactive components
- ✅ Tailwind CSS styling
- ✅ ViewModel for data preparation
- ✅ Mobile-responsive design
- ✅ Performance optimized
- ✅ Hyvä Themes compatible

## Configuration

No configuration required. The module works out of the box.

## Usage

The custom component will automatically appear on product pages.

### Customization

#### Modify ViewModel Data

Edit \`ViewModel/ComponentData.php\` to customize data preparation:

\`\`\`php
public function getComponentConfig(): array
{
    return [
        'enabled' => true,
        'showLabels' => true,
        // Your configuration
    ];
}
\`\`\`

#### Customize Styling

Edit \`view/frontend/tailwind/components/product-component.css\` for custom styles.

#### Extend Alpine.js Component

Modify \`view/frontend/templates/product/custom-component.phtml\` to add functionality.

## Development

### Rebuild Tailwind

\`\`\`bash
cd /path/to/hyva-theme
npm run build-tailwind
\`\`\`

### Testing

Test the component on:
- Product pages
- Different screen sizes
- Various browsers

## Support

For issues and questions:
- GitHub: {repository-url}
- Email: dev@{vendor-lowercase}.com

## License

Proprietary

## Changelog

### 1.0.0
- Initial release
- Hyvä Themes compatibility
- Alpine.js component
- Tailwind CSS styling
\`\`\`

---

## Instructions

1. **Create all files** listed above in the specified structure
2. **Replace placeholders**:
   - `{Vendor}` → Actual vendor name (e.g., "Acme")
   - `{ModuleName}` → Actual module name (e.g., "HyvaCustomComponent")
   - `{vendor-lowercase}` → Lowercase vendor (e.g., "acme")
   - `{module-name-lowercase}` → Lowercase module name with hyphens (e.g., "hyva-custom-component")
   - `{ARG2}` → Description provided by user
3. **Verify structure** matches Hyvä best practices
4. **Test** on a Hyvä theme installation

## After Creation

1. Enable the module:
   ```bash
   php bin/magento module:enable {Vendor}_{ModuleName}
   php bin/magento setup:upgrade
   ```

2. Compile DI:
   ```bash
   php bin/magento setup:di:compile
   ```

3. Rebuild Tailwind in your Hyvä theme:
   ```bash
   cd /path/to/hyva-theme
   npm run build-tailwind
   ```

4. Clear cache:
   ```bash
   php bin/magento cache:flush
   ```

5. Test on product page

## Success Criteria

- ✅ Module appears in `php bin/magento module:status`
- ✅ Component renders on product page
- ✅ Alpine.js reactivity works
- ✅ Tailwind styles applied
- ✅ No JavaScript console errors
- ✅ Mobile responsive
- ✅ Performance optimized

---

**Your Hyvä compatibility module is ready for development!** 🚀
