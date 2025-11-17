---
description: Create Alpine.js component with ViewModel, template, and Tailwind CSS for Hyvä Themes
argument-hint: "<component-name> <location> <brief-description>"
---

You are creating an Alpine.js component for Hyvä Themes.

## Arguments Provided

- **Component Name**: `{ARG1}` (e.g., "ProductWishlist", "QuickView", "ColorSwatch")
- **Location**: `{ARG2}` (e.g., "product", "category", "cart", "checkout")
- **Description**: `{ARG3}`

## Task

Create a complete Alpine.js component with:
1. ViewModel for server-side data preparation
2. phtml template with Alpine.js reactivity
3. Tailwind CSS component styles
4. Layout XML integration
5. Example usage documentation

## Files to Create

Based on location `{ARG2}`, create in existing Hyvä theme or module:

### 1. ViewModel/`{ComponentName}`Data.php

```php
<?php
/**
 * {ComponentName} ViewModel
 * {ARG3}
 *
 * @category  Hyva
 * @package   Hyva_Components
 */
declare(strict_types=1);

namespace Vendor\Theme\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Escaper;

class {ComponentName}Data implements ArgumentInterface
{
    private SerializerInterface $serializer;
    private Escaper $escaper;

    public function __construct(
        SerializerInterface $serializer,
        Escaper $escaper
    ) {
        $this->serializer = $serializer;
        $this->escaper = $escaper;
    }

    /**
     * Get component configuration
     *
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'enabled' => true,
            'animationDuration' => 300,
            'autoHide' => false,
            // Add configuration options
        ];
    }

    /**
     * Get component data
     *
     * @param mixed $context
     * @return array
     */
    public function getData($context = null): array
    {
        // Prepare component data
        $data = [
            'id' => $context ? $context->getId() : null,
            'items' => [],
            'loading' => false,
        ];

        return $data;
    }

    /**
     * Get component data as JSON (escaped for safe inline use)
     *
     * @param mixed $context
     * @return string
     */
    public function getDataJson($context = null): string
    {
        return $this->escaper->escapeHtml(
            $this->serializer->serialize($this->getData($context))
        );
    }

    /**
     * Get configuration as JSON
     *
     * @return string
     */
    public function getConfigJson(): string
    {
        return $this->escaper->escapeHtml(
            $this->serializer->serialize($this->getConfig())
        );
    }
}
```

### 2. view/frontend/templates/`{location}`/`{component-name}`.phtml

```php
<?php
/**
 * {ComponentName} Alpine.js Component
 * {ARG3}
 *
 * @var \Magento\Framework\View\Element\Template $block
 * @var \Magento\Framework\Escaper $escaper
 * @var \Hyva\Theme\Model\ViewModelRegistry $viewModels
 */

// Get ViewModel
$viewModel = $block->getData('view_model') ?:
    $viewModels->require(Vendor\Theme\ViewModel\{ComponentName}Data::class);

// Get context (product, category, etc.)
$context = $block->getData('context');

// Get configuration and data
$config = $viewModel->getConfig();
$initialData = $viewModel->getData($context);
?>

<div x-data="init{ComponentName}()"
     x-init="init()"
     @{component-event}.window="handleEvent($event)"
     class="{component-name}-container">

    <!-- Component Header -->
    <div class="{component-name}-header">
        <h3 class="text-lg font-semibold text-gray-900">
            <?= $escaper->escapeHtml(__({ComponentName})) ?>
        </h3>

        <!-- Toggle button example -->
        <button type="button"
                @click="toggle()"
                :aria-expanded="isOpen"
                :aria-label="isOpen ? '<?= $escaper->escapeHtmlAttr(__('Close')) ?>' : '<?= $escaper->escapeHtmlAttr(__('Open')) ?>'"
                class="text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-6 h-6 transition-transform"
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
         class="{component-name}-content">

        <!-- Loading state -->
        <div x-show="loading" class="flex items-center justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
            <span class="ml-3 text-gray-600"><?= $escaper->escapeHtml(__('Loading...')) ?></span>
        </div>

        <!-- Content -->
        <div x-show="!loading" class="space-y-4">
            <!-- Example: List of items -->
            <template x-if="items.length > 0">
                <div class="grid grid-cols-1 gap-4">
                    <template x-for="(item, index) in items" :key="item.id || index">
                        <div class="{component-name}-item">
                            <!-- Item content -->
                            <div class="flex items-center gap-4">
                                <img :src="item.image"
                                     :alt="item.name"
                                     class="w-16 h-16 object-cover rounded-md">
                                <div class="flex-1">
                                    <h4 class="font-semibold" x-text="item.name"></h4>
                                    <p class="text-sm text-gray-600" x-text="item.description"></p>
                                </div>
                                <button type="button"
                                        @click="handleItemAction(item)"
                                        class="btn btn-sm btn-primary">
                                    <?= $escaper->escapeHtml(__('Action')) ?>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Empty state -->
            <template x-if="items.length === 0 && !loading">
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p><?= $escaper->escapeHtml(__('No items found')) ?></p>
                </div>
            </template>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex gap-4">
            <button type="button"
                    @click="performAction()"
                    :disabled="loading || items.length === 0"
                    class="btn btn-primary"
                    :class="{'opacity-50 cursor-not-allowed': loading || items.length === 0}">
                <span x-show="!loading"><?= $escaper->escapeHtml(__('Perform Action')) ?></span>
                <span x-show="loading"><?= $escaper->escapeHtml(__('Processing...')) ?></span>
            </button>

            <button type="button"
                    @click="reset()"
                    class="btn btn-secondary">
                <?= $escaper->escapeHtml(__('Reset')) ?>
            </button>
        </div>

        <!-- Status messages -->
        <div x-show="message"
             x-transition
             class="mt-4 p-4 rounded-md"
             :class="{
                 'bg-green-100 text-green-800': messageType === 'success',
                 'bg-red-100 text-red-800': messageType === 'error',
                 'bg-blue-100 text-blue-800': messageType === 'info',
                 'bg-yellow-100 text-yellow-800': messageType === 'warning'
             }">
            <p x-text="message"></p>
        </div>
    </div>
</div>

<script>
function init{ComponentName}() {
    return {
        // Component state
        isOpen: <?= $config['enabled'] ? 'true' : 'false' ?>,
        loading: false,
        message: '',
        messageType: 'info',

        // Component data
        items: <?= /* @noEscape */ $viewModel->getDataJson($context) ?>.items || [],
        config: <?= /* @noEscape */ $viewModel->getConfigJson() ?>,

        /**
         * Initialize component
         */
        init() {
            console.log('{ComponentName} initialized');

            // Load initial data if needed
            if (this.config.autoLoad) {
                this.loadData();
            }

            // Listen for events
            this.$watch('items', (value) => {
                console.log('Items updated:', value.length);
            });
        },

        /**
         * Toggle component visibility
         */
        toggle() {
            this.isOpen = !this.isOpen;

            if (this.isOpen && this.items.length === 0) {
                this.loadData();
            }
        },

        /**
         * Load component data (async)
         */
        async loadData() {
            this.loading = true;
            this.message = '';

            try {
                const response = await fetch('/rest/V1/{endpoint}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load data');
                }

                const data = await response.json();
                this.items = data.items || [];

                if (this.items.length === 0) {
                    this.showMessage('<?= $escaper->escapeJs(__('No items available')) ?>', 'info');
                }

            } catch (error) {
                console.error('Load error:', error);
                this.showMessage('<?= $escaper->escapeJs(__('Failed to load data')) ?>', 'error');
            } finally {
                this.loading = false;
            }
        },

        /**
         * Handle item action
         */
        async handleItemAction(item) {
            this.loading = true;

            try {
                const response = await fetch(`/rest/V1/{endpoint}/${item.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ item: item })
                });

                if (!response.ok) {
                    throw new Error('Action failed');
                }

                const result = await response.json();
                this.showMessage('<?= $escaper->escapeJs(__('Action completed successfully')) ?>', 'success');

                // Dispatch event
                this.dispatchEvent('{component-name}:action-completed', result);

                // Reload data
                await this.loadData();

            } catch (error) {
                console.error('Action error:', error);
                this.showMessage('<?= $escaper->escapeJs(__('Action failed')) ?>', 'error');
            } finally {
                this.loading = false;
            }
        },

        /**
         * Perform main action
         */
        async performAction() {
            this.loading = true;
            this.message = '';

            try {
                // Perform action
                await new Promise(resolve => setTimeout(resolve, 1000));

                this.showMessage('<?= $escaper->escapeJs(__('Action completed')) ?>', 'success');

                // Dispatch event
                this.dispatchEvent('{component-name}:completed');

            } catch (error) {
                console.error('Action error:', error);
                this.showMessage('<?= $escaper->escapeJs(__('Action failed')) ?>', 'error');
            } finally {
                this.loading = false;
            }
        },

        /**
         * Reset component state
         */
        reset() {
            this.items = [];
            this.message = '';
            this.messageType = 'info';
            this.showMessage('<?= $escaper->escapeJs(__('Component reset')) ?>', 'info');
        },

        /**
         * Show message
         */
        showMessage(text, type = 'info') {
            this.message = text;
            this.messageType = type;

            // Auto-hide after delay
            if (this.config.autoHide !== false) {
                setTimeout(() => {
                    this.message = '';
                }, this.config.animationDuration * 10 || 3000);
            }
        },

        /**
         * Dispatch custom event
         */
        dispatchEvent(name, detail = {}) {
            window.dispatchEvent(new CustomEvent(name, {
                detail: detail,
                bubbles: true
            }));
        },

        /**
         * Handle external events
         */
        handleEvent(event) {
            console.log('Event received:', event.detail);
            // Handle event
        }
    }
}
</script>
```

### 3. view/frontend/tailwind/components/`{component-name}`.css

```css
/**
 * {ComponentName} Tailwind Component
 * {ARG3}
 */

@layer components {
    /* Container */
    .{component-name}-container {
        @apply bg-white rounded-lg shadow-md overflow-hidden;
    }

    /* Header */
    .{component-name}-header {
        @apply flex items-center justify-between p-4 bg-gray-50 border-b border-gray-200;
    }

    /* Content */
    .{component-name}-content {
        @apply p-6;
    }

    /* Item */
    .{component-name}-item {
        @apply p-4 bg-white border border-gray-200 rounded-md hover:shadow-md transition-shadow;
    }

    /* Responsive variants */
    @screen md {
        .{component-name}-container {
            @apply max-w-2xl mx-auto;
        }
    }

    @screen lg {
        .{component-name}-header {
            @apply p-6;
        }

        .{component-name}-content {
            @apply p-8;
        }
    }
}
```

### 4. view/frontend/layout/`{location-based-layout}`.xml

Choose appropriate layout file based on location:
- Product: `catalog_product_view.xml`
- Category: `catalog_category_view.xml`
- Cart: `checkout_cart_index.xml`
- Checkout: `checkout_index_index.xml`

```xml
<?xml version="1.0"?>
<!--
/**
 * {ComponentName} Layout
 */
-->
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <block class="Magento\Framework\View\Element\Template"
                   name="{component-name}"
                   template="Vendor_Theme::{location}/{component-name}.phtml"
                   after="-">
                <arguments>
                    <argument name="view_model" xsi:type="object">Vendor\Theme\ViewModel\{ComponentName}Data</argument>
                </arguments>
            </block>
        </referenceContainer>
    </body>
</page>
```

---

## Usage Examples

### In Product Context

```php
<?= $block->getLayout()
    ->createBlock(\Magento\Framework\View\Element\Template::class)
    ->setTemplate('Vendor_Theme::product/{component-name}.phtml')
    ->setData('context', $product)
    ->toHtml()
?>
```

### As Standalone Component

```php
<div class="container mx-auto my-8">
    <?= $block->getChildHtml('{component-name}') ?>
</div>
```

### With Custom Data

```php
$viewModel = $viewModels->require(Vendor\Theme\ViewModel\{ComponentName}Data::class);
$customData = $viewModel->getData($customContext);
?>
<div x-data='<?= json_encode($customData) ?>'>
    <!-- Use data -->
</div>
```

---

## Testing Checklist

- [ ] Component renders without errors
- [ ] Alpine.js reactivity works
- [ ] ViewModel data loads correctly
- [ ] Tailwind styles applied
- [ ] Mobile responsive
- [ ] Accessibility (ARIA labels, keyboard navigation)
- [ ] Loading states work
- [ ] Error handling works
- [ ] Events dispatch/receive correctly
- [ ] Performance is acceptable
- [ ] Works with Hyvä Checkout (if applicable)

---

## Customization Guide

### Modify Component Logic

Edit the `init{ComponentName}()` function in the template.

### Change Styling

Edit `view/frontend/tailwind/components/{component-name}.css`.

### Update Data Source

Modify `ViewModel/{ComponentName}Data.php`.

### Add Event Listeners

```javascript
window.addEventListener('{component-name}:completed', (event) => {
    console.log('Component completed:', event.detail);
});
```

### Trigger from External Code

```javascript
window.dispatchEvent(new CustomEvent('{component-event}', {
    detail: { action: 'reload' }
}));
```

---

## Best Practices

- ✅ Keep components focused and single-purpose
- ✅ Use ViewModels for data preparation
- ✅ Leverage Tailwind utility classes
- ✅ Implement proper loading states
- ✅ Add error handling
- ✅ Use semantic HTML
- ✅ Include ARIA attributes for accessibility
- ✅ Test on mobile devices
- ✅ Optimize for performance
- ✅ Document custom events

---

**Your Alpine.js component is ready for Hyvä Themes!** 🎨
