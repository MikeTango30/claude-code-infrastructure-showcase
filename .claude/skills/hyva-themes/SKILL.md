---
name: hyva-themes
description: Comprehensive Hyvä Themes development guidelines covering Alpine.js components, Tailwind CSS, ViewModels, Hyvä Checkout, compatibility modules, and performance optimization. Use when developing Hyvä-based Magento 2 themes and storefronts.
---

# Hyvä Themes Development Guidelines

## Purpose

Modern, performant Magento 2 frontend development using the Hyvä Themes framework - replacing Knockout.js and RequireJS with Alpine.js and Tailwind CSS for 10x better performance.

## When to Use This Skill

Automatically activates when working on:
- Hyvä theme development
- Alpine.js components for Magento 2
- Tailwind CSS customization
- Hyvä Checkout implementation
- ViewModel creation
- Hyvä compatibility modules
- Performance optimization
- Converting Luma/Blank themes to Hyvä
- Headless commerce with Hyvä

---

## Quick Start

### Hyvä Theme Checklist

- [ ] **Theme installed**: Hyvä theme base package
- [ ] **Tailwind configured**: tailwind.config.js setup
- [ ] **Alpine.js**: Component structure
- [ ] **ViewModels**: Server-side data preparation
- [ ] **Compatibility**: Hyvä compatibility modules for extensions
- [ ] **Checkout**: Hyvä Checkout or Hyvä Checkout (if using headless)
- [ ] **Performance**: Optimized assets, lazy loading
- [ ] **Testing**: Cross-browser, mobile-first

### New Component Checklist

- [ ] Create ViewModel (if needed)
- [ ] Create phtml template with Alpine.js
- [ ] Add Tailwind CSS classes
- [ ] Register in layout XML
- [ [ ] Test reactivity and state management
- [ ] Optimize for performance
- [ ] Add accessibility attributes

---

## Hyvä Architecture Overview

### Core Technologies

**Alpine.js** (JavaScript framework)
- Lightweight (15kb)
- Declarative reactive components
- Direct DOM manipulation
- Vue-like syntax

**Tailwind CSS** (Utility-first CSS)
- No CSS file bloat
- PurgeCSS integration
- JIT (Just-In-Time) compilation
- Mobile-first responsive design

**ViewModels** (Server-side data layer)
- Replace Knockout.js observables
- Prepare data in PHP
- Pass to Alpine.js components
- Better performance (server-side processing)

### File Structure

```
app/design/frontend/Vendor/hyva-theme/
├── Magento_Catalog/
│   ├── layout/
│   │   └── catalog_product_view.xml
│   ├── templates/
│   │   └── product/
│   │       ├── view.phtml              # Alpine.js component
│   │       └── view/gallery.phtml      # Gallery component
│   └── web/
│       ├── tailwind/
│       │   └── components/             # Tailwind components
│       └── js/
│           └── product-view.js         # Optional JS
├── Magento_Checkout/
│   ├── layout/
│   │   └── checkout_index_index.xml
│   └── templates/
│       └── cart/
│           └── item/default.phtml      # Cart item component
├── web/
│   ├── css/
│   │   └── tailwind-source.css         # Tailwind directives
│   └── tailwind/
│       └── tailwind.config.js          # Tailwind configuration
├── etc/
│   ├── view.xml                        # Theme configuration
│   └── theme.xml                       # Theme declaration
└── registration.php                     # Theme registration
```

---

## Alpine.js Development Patterns

### Basic Component Structure

```html
<!-- app/design/frontend/Vendor/Theme/Magento_Catalog/templates/product/view/addtocart.phtml -->

<?php
/**
 * @var \Magento\Catalog\Block\Product\View $block
 * @var \Magento\Framework\Escaper $escaper
 * @var \Hyva\Theme\Model\ViewModelRegistry $viewModels
 */

// Get ViewModel for data preparation
/** @var \Hyva\Theme\ViewModel\ProductPrice $priceViewModel */
$priceViewModel = $viewModels->require(\Hyva\Theme\ViewModel\ProductPrice::class);

$product = $block->getProduct();
?>

<div x-data="initAddToCart()"
     x-init="init()"
     @private-content-loaded.window="onPrivateContentLoaded($event)"
     class="flex flex-col gap-4">

    <!-- Quantity selector -->
    <div class="flex items-center gap-2">
        <label for="qty" class="text-sm font-medium">
            <?= $escaper->escapeHtml(__('Quantity')) ?>
        </label>
        <input type="number"
               id="qty"
               name="qty"
               x-model.number="qty"
               min="1"
               class="w-20 px-3 py-2 border border-gray-300 rounded-md">
    </div>

    <!-- Add to Cart button -->
    <button type="button"
            @click="addToCart()"
            :disabled="loading"
            class="btn btn-primary"
            :class="{'opacity-50 cursor-not-allowed': loading}">
        <span x-show="!loading"><?= $escaper->escapeHtml(__('Add to Cart')) ?></span>
        <span x-show="loading"><?= $escaper->escapeHtml(__('Adding...')) ?></span>
    </button>

    <!-- Success message -->
    <div x-show="showSuccess"
         x-transition
         class="p-4 bg-green-100 text-green-800 rounded-md">
        <?= $escaper->escapeHtml(__('Product added to cart!')) ?>
    </div>
</div>

<script>
function initAddToCart() {
    return {
        qty: 1,
        loading: false,
        showSuccess: false,
        productId: <?= (int)$product->getId() ?>,

        init() {
            // Initialization logic
        },

        async addToCart() {
            this.loading = true;

            try {
                const formData = new FormData();
                formData.append('product', this.productId);
                formData.append('qty', this.qty);

                const response = await fetch('<?= $escaper->escapeUrl($block->getSubmitUrl($product)) ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                if (response.ok) {
                    this.showSuccess = true;
                    setTimeout(() => this.showSuccess = false, 3000);

                    // Dispatch event for cart update
                    window.dispatchEvent(new CustomEvent('reload-customer-section-data'));
                }
            } catch (error) {
                console.error('Add to cart error:', error);
            } finally {
                this.loading = false;
            }
        },

        onPrivateContentLoaded(event) {
            // Handle customer section data
        }
    }
}
</script>
```

### Alpine.js Directives (Hyvä Context)

**State Management:**
```html
<!-- Component state -->
<div x-data="{ open: false, items: [], loading: false }">

<!-- Reactive computed properties -->
<div x-data="{ qty: 1 }" x-text="'Total: $' + (qty * <?= $product->getFinalPrice() ?>)"></div>

<!-- Watch for changes -->
<div x-data="{ qty: 1 }" @qty-changed.window="qty = $event.detail.qty">
```

**DOM Manipulation:**
```html
<!-- Conditional rendering -->
<div x-show="cartOpen" x-transition>Mini cart content</div>

<!-- Class binding -->
<button :class="{'bg-blue-500': active, 'bg-gray-300': !active}">

<!-- Attribute binding -->
<img :src="selectedImage" :alt="product.name">
```

**Event Handling:**
```html
<!-- Click events -->
<button @click="addToCart()">Add to Cart</button>

<!-- Custom events -->
<div @product-added.window="updateMiniCart($event)">

<!-- Prevent default -->
<form @submit.prevent="handleSubmit()">

<!-- Debounce -->
<input @input.debounce.500ms="search($event.target.value)">
```

---

## ViewModel Pattern

ViewModels prepare data server-side, replacing Knockout.js observables for better performance.

### Creating a ViewModel

```php
<?php
/**
 * app/code/Vendor/Module/ViewModel/ProductData.php
 */
declare(strict_types=1);

namespace Vendor\Module\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;

class ProductData implements ArgumentInterface
{
    private ProductRepositoryInterface $productRepository;
    private PriceHelper $priceHelper;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        PriceHelper $priceHelper
    ) {
        $this->productRepository = $productRepository;
        $this->priceHelper = $priceHelper;
    }

    /**
     * Get formatted product data for Alpine.js
     *
     * @param int $productId
     * @return array
     */
    public function getProductData(int $productId): array
    {
        $product = $this->productRepository->getById($productId);

        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'sku' => $product->getSku(),
            'price' => $this->priceHelper->currency($product->getFinalPrice(), true, false),
            'priceValue' => $product->getFinalPrice(),
            'image' => $product->getImage(),
            'inStock' => $product->getIsInStock(),
            'qty' => $product->getQty()
        ];
    }

    /**
     * Get JSON-encoded product data
     *
     * @param int $productId
     * @return string
     */
    public function getProductDataJson(int $productId): string
    {
        return json_encode($this->getProductData($productId));
    }
}
```

### Register ViewModel in Layout

```xml
<!-- app/code/Vendor/Module/view/frontend/layout/catalog_product_view.xml -->
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceBlock name="product.info.main">
            <arguments>
                <argument name="view_model" xsi:type="object">Vendor\Module\ViewModel\ProductData</argument>
            </arguments>
        </referenceBlock>
    </body>
</page>
```

### Use ViewModel in Template

```php
<?php
/**
 * @var \Magento\Catalog\Block\Product\View $block
 * @var \Vendor\Module\ViewModel\ProductData $productDataViewModel
 */

// Access ViewModel
$productDataViewModel = $block->getData('view_model');
$productData = $productDataViewModel->getProductData($product->getId());
?>

<div x-data='<?= json_encode($productData) ?>'>
    <h1 x-text="name"></h1>
    <p class="text-2xl font-bold" x-text="price"></p>
    <p x-show="inStock" class="text-green-600">In Stock</p>
</div>
```

---

## Tailwind CSS in Hyvä

### Configuration

```javascript
// web/tailwind/tailwind.config.js
module.exports = {
    important: true, // Hyvä recommendation
    content: [
        '../../../app/design/frontend/Vendor/Theme/**/*.phtml',
        '../../../app/code/Vendor/**/view/frontend/**/*.phtml',
        '../../../vendor/hyva-themes/magento2-default-theme/**/*.phtml',
        '../../../vendor/hyva-themes/magento2-hyva-checkout/**/*.phtml'
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    lighter: '#DAE5F5',
                    DEFAULT: '#006BB4',
                    darker: '#004A7C'
                },
                secondary: {
                    lighter: '#E5E5E5',
                    DEFAULT: '#757575',
                    darker: '#333333'
                }
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui'],
            },
            screens: {
                'sm': '640px',
                'md': '768px',
                'lg': '1024px',
                'xl': '1280px',
                '2xl': '1536px',
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio')
    ],
    corePlugins: {
        container: false // Hyvä provides custom container
    }
}
```

### Common Tailwind Patterns

**Layout:**
```html
<!-- Container -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8">

<!-- Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

<!-- Flex -->
<div class="flex flex-col md:flex-row items-center justify-between">
```

**Components:**
```html
<!-- Button -->
<button class="px-6 py-3 bg-primary text-white font-semibold rounded-md hover:bg-primary-darker transition-colors">
    Buy Now
</button>

<!-- Card -->
<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">

<!-- Input -->
<input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent">
```

**Responsive Design:**
```html
<!-- Hidden on mobile, shown on desktop -->
<div class="hidden md:block">Desktop menu</div>

<!-- Shown on mobile, hidden on desktop -->
<div class="block md:hidden">Mobile menu</div>

<!-- Responsive text size -->
<h1 class="text-2xl md:text-4xl lg:text-5xl font-bold">
```

---

## Hyvä Checkout

Modern, performant checkout built with Alpine.js and Tailwind CSS.

### Installation

```bash
composer require hyva-themes/magento2-hyva-checkout
php bin/magento setup:upgrade
php bin/magento setup:di:compile
```

### Configuration

```php
// config.php or app/etc/env.php
'system' => [
    'default' => [
        'hyva_themes_checkout' => [
            'general' => [
                'enable' => '1'
            ]
        ]
    ]
]
```

### Custom Checkout Step

```php
<?php
/**
 * app/code/Vendor/Module/Magewire/Checkout/CustomStep.php
 */
declare(strict_types=1);

namespace Vendor\Module\Magewire\Checkout;

use Magewirephp\Magewire\Component;

class CustomStep extends Component
{
    public $customField = '';
    public $validated = false;

    protected $listeners = [
        'checkout:validate' => 'validate'
    ];

    public function mount(): void
    {
        // Initialize component
    }

    public function validate(): void
    {
        if (empty($this->customField)) {
            $this->dispatchBrowserEvent('validation-error', [
                'message' => 'Custom field is required'
            ]);
            return;
        }

        $this->validated = true;
        $this->emit('step:validated', ['step' => 'custom-step']);
    }

    public function render()
    {
        return view('Vendor_Module::checkout/custom-step');
    }
}
```

```php
<!-- app/code/Vendor/Module/view/frontend/templates/checkout/custom-step.phtml -->
<div class="checkout-step" wire:init="mount">
    <h2 class="text-2xl font-bold mb-4"><?= __('Custom Step') ?></h2>

    <div class="mb-4">
        <label for="custom-field" class="block text-sm font-medium text-gray-700 mb-2">
            <?= __('Custom Field') ?>
        </label>
        <input type="text"
               id="custom-field"
               wire:model.defer="customField"
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary">
    </div>

    <div x-data="{ validated: @entangle('validated') }">
        <button type="button"
                @click="$wire.validate()"
                class="btn btn-primary"
                :disabled="validated">
            <?= __('Continue') ?>
        </button>
    </div>
</div>
```

### Register Checkout Step

```xml
<!-- app/code/Vendor/Module/view/frontend/layout/hyva_checkout_index_index.xml -->
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="checkout.steps">
            <block class="Hyva\Checkout\Block\Checkout\Step"
                   name="checkout.step.custom"
                   template="Vendor_Module::checkout/step.phtml">
                <arguments>
                    <argument name="magewire" xsi:type="object">Vendor\Module\Magewire\Checkout\CustomStep</argument>
                    <argument name="sort_order" xsi:type="string">20</argument>
                </arguments>
            </block>
        </referenceContainer>
    </body>
</page>
```

---

## Compatibility Modules

Hyvä compatibility modules bridge third-party extensions with Hyvä's Alpine.js/Tailwind architecture.

### Creating a Compatibility Module

```
app/code/Vendor/HyvaModuleCompat/
├── registration.php
├── etc/
│   ├── module.xml
│   └── frontend/
│       └── di.xml
├── Plugin/
│   └── TemplatePlugin.php
└── view/frontend/
    ├── layout/
    │   └── catalog_product_view.xml
    └── templates/
        └── product/
            └── custom-widget.phtml
```

**registration.php:**
```php
<?php
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Vendor_HyvaModuleCompat',
    __DIR__
);
```

**etc/module.xml:**
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="Vendor_HyvaModuleCompat">
        <sequence>
            <module name="ThirdParty_Module"/>
            <module name="Hyva_Theme"/>
        </sequence>
    </module>
</config>
```

### Convert Knockout.js to Alpine.js

**Original (Knockout.js):**
```html
<div data-bind="scope: 'productWidget'">
    <span data-bind="text: productName"></span>
    <button data-bind="click: addToCart">Add to Cart</button>
</div>

<script type="text/x-magento-init">
{
    "[data-bind='scope: productWidget']": {
        "Magento_Ui/js/core/app": {
            "components": {
                "productWidget": {
                    "component": "ThirdParty_Module/js/product-widget",
                    "productName": "<?= $product->getName() ?>",
                    "productId": <?= $product->getId() ?>
                }
            }
        }
    }
}
</script>
```

**Hyvä (Alpine.js):**
```html
<div x-data="productWidget()" x-init="init()">
    <span x-text="productName"></span>
    <button @click="addToCart()">Add to Cart</button>
</div>

<script>
function productWidget() {
    return {
        productName: '<?= $escaper->escapeJs($product->getName()) ?>',
        productId: <?= (int)$product->getId() ?>,

        init() {
            // Initialization
        },

        async addToCart() {
            // Add to cart logic
        }
    }
}
</script>
```

---

## Performance Optimization

### Critical CSS

```html
<!-- app/design/frontend/Vendor/Theme/Magento_Theme/layout/default_head_blocks.xml -->
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <head>
        <!-- Critical CSS inline -->
        <css src="css/critical.css" src_type="controller" />
    </head>
</page>
```

### Lazy Loading

```html
<!-- Lazy load images -->
<img src="placeholder.jpg"
     data-src="<?= $block->getImageUrl() ?>"
     loading="lazy"
     class="lazy">

<!-- Lazy load Alpine components -->
<div x-data
     x-intersect="$el.setAttribute('x-data', 'heavyComponent()')"
     class="min-h-[400px]">
    Component loads when visible
</div>
```

### Asset Optimization

```bash
# Minify Tailwind CSS (production)
NODE_ENV=production npm run build-tailwind

# Optimize images
php bin/magento catalog:images:resize

# Enable production mode
php bin/magento deploy:mode:set production
php bin/magento setup:static-content:deploy
```

---

## Testing Hyvä Components

### Browser Testing

```javascript
// tests/acceptance/ProductViewCest.php
class ProductViewCest
{
    public function testAddToCart(AcceptanceTester $I)
    {
        $I->amOnPage('/product-url.html');
        $I->waitForElementVisible('[x-data="initAddToCart()"]');
        $I->fillField('#qty', '2');
        $I->click('button[type="button"]:contains("Add to Cart")');
        $I->waitForText('Product added to cart!');
        $I->seeElement('.minicart-wrapper .counter-number:contains("2")');
    }
}
```

### Alpine.js Component Testing

```html
<!-- Manual testing in browser console -->
<script>
// Access Alpine component data
const component = Alpine.$data(document.querySelector('[x-data="initAddToCart()"]'));
console.log(component.qty); // Current quantity
component.addToCart(); // Trigger method
</script>
```

---

## Common Patterns

### Product Listing

```html
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php foreach ($products as $product): ?>
        <div class="product-card group">
            <a href="<?= $product->getProductUrl() ?>"
               class="block relative overflow-hidden rounded-lg">
                <img src="<?= $product->getImageUrl() ?>"
                     alt="<?= $escaper->escapeHtmlAttr($product->getName()) ?>"
                     loading="lazy"
                     class="w-full h-auto group-hover:scale-105 transition-transform">
            </a>
            <div class="mt-4">
                <h3 class="text-lg font-semibold truncate">
                    <?= $escaper->escapeHtml($product->getName()) ?>
                </h3>
                <p class="text-xl font-bold text-primary mt-2">
                    <?= $priceHelper->currency($product->getFinalPrice()) ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
```

### Mini Cart

```html
<div x-data="initMiniCart()"
     @private-content-loaded.window="onCartUpdate($event)"
     class="relative">

    <!-- Cart icon -->
    <button @click="open = !open"
            class="relative">
        <svg class="w-6 h-6"><!-- cart icon --></svg>
        <span x-show="itemCount > 0"
              x-text="itemCount"
              class="absolute -top-2 -right-2 bg-primary text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
        </span>
    </button>

    <!-- Dropdown -->
    <div x-show="open"
         x-transition
         @click.away="open = false"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl z-50">
        <!-- Cart items -->
        <template x-for="item in items" :key="item.id">
            <div class="flex gap-4 p-4 border-b">
                <img :src="item.image" :alt="item.name" class="w-20 h-20 object-cover">
                <div class="flex-1">
                    <h4 x-text="item.name" class="font-semibold"></h4>
                    <p class="text-sm text-gray-600" x-text="'Qty: ' + item.qty"></p>
                    <p class="font-bold" x-text="item.price"></p>
                </div>
            </div>
        </template>

        <!-- Checkout button -->
        <div class="p-4">
            <a href="/checkout" class="btn btn-primary w-full">
                <?= __('Checkout') ?>
            </a>
        </div>
    </div>
</div>
```

---

## Resources

### Official Documentation
- Hyvä Themes: https://docs.hyva.io/
- Hyvä Checkout: https://docs.hyva.io/hyva-checkout/
- Alpine.js: https://alpinejs.dev/
- Tailwind CSS: https://tailwindcss.com/

### Community
- Hyvä Slack: https://hyva.io/slack
- GitLab: https://gitlab.hyva.io/
- Hyvä Extensions: https://www.hyva.io/hyva-themes-extensions

### Learning
- Hyvä Academy: https://academy.hyva.io/
- Example Modules: https://gitlab.hyva.io/hyva-themes/
- Compatibility Modules: https://gitlab.hyva.io/hyva-checkout/

---

## Best Practices

### ✅ DO

- Use ViewModels for data preparation
- Leverage Tailwind utility classes
- Keep Alpine.js components small and focused
- Use semantic HTML with Tailwind
- Optimize images and assets
- Test on mobile devices first
- Create compatibility modules for third-party extensions
- Follow Hyvä coding standards
- Use Alpine.js `$dispatch` for component communication
- Implement lazy loading for heavy components

### ❌ DON'T

- Don't use Knockout.js or RequireJS
- Don't inline large JavaScript in templates
- Don't ignore mobile responsiveness
- Don't skip ViewModels for complex data
- Don't use `!important` in custom CSS (Tailwind uses it)
- Don't forget to purge unused Tailwind classes
- Don't mix Luma and Hyvä patterns
- Don't skip compatibility testing with extensions

---

## Quick Reference

### Alpine.js Directives
- `x-data` - Component state
- `x-init` - Initialization
- `x-show` - Conditional display
- `x-if` - Conditional rendering
- `x-for` - Loop
- `x-on (@)` - Event listener
- `x-bind (:)` - Attribute binding
- `x-model` - Two-way binding
- `x-text` - Text content
- `x-html` - HTML content
- `x-transition` - Transitions
- `x-cloak` - Hide until ready

### Tailwind Common Classes
- Layout: `container mx-auto px-4 flex grid`
- Spacing: `p-4 m-2 gap-6 space-y-4`
- Typography: `text-lg font-bold text-gray-700`
- Colors: `bg-primary text-white border-gray-300`
- Effects: `shadow-md hover:shadow-lg transition-all`
- Responsive: `md:flex lg:grid-cols-4 hidden sm:block`

### Hyvä Commands
```bash
# Build Tailwind
npm run build-tailwind

# Watch mode
npm run watch-tailwind

# Deploy
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```

---

**Hyvä Themes delivers 10x better performance than Luma with modern development patterns!**
