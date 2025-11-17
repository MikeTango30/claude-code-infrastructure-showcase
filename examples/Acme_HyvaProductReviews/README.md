# Acme_HyvaProductReviews - Hyvä Themes Example Component

Complete example of a Hyvä Themes Alpine.js component with Tailwind CSS styling.

## Overview

This example demonstrates:
- ✅ Alpine.js reactive component
- ✅ ViewModel for server-side data preparation
- ✅ Tailwind CSS utility-first styling
- ✅ Hyvä Themes best practices
- ✅ Performance optimization
- ✅ Mobile-first responsive design
- ✅ Accessibility (ARIA labels)

## What It Does

An interactive product review component that:
1. Displays product reviews with star ratings
2. Allows filtering by rating
3. Loads reviews asynchronously
4. Provides smooth Alpine.js transitions
5. Uses Tailwind CSS for styling

## Files Included

```
Acme_HyvaProductReviews/
├── registration.php                              # Module registration
├── composer.json                                 # Composer configuration
├── etc/
│   └── module.xml                                # Module declaration
├── ViewModel/
│   └── ProductReviewsData.php                    # ViewModel (data preparation)
├── view/frontend/
│   ├── layout/
│   │   └── catalog_product_view.xml              # Layout XML
│   ├── templates/
│   │   └── product/
│   │       └── reviews-component.phtml           # Alpine.js template
│   └── tailwind/
│       └── components/
│           └── product-reviews.css               # Tailwind component styles
└── README.md                                     # This file
```

## Key Concepts Demonstrated

### 1. ViewModel Pattern

**File:** `ViewModel/ProductReviewsData.php`

```php
class ProductReviewsData implements ArgumentInterface
{
    public function getReviewsData(Product $product): array
    {
        // Server-side data preparation
        return [
            'productId' => $product->getId(),
            'reviews' => $this->formatReviews($product),
            'averageRating' => $product->getRatingSummary(),
            'totalReviews' => count($product->getReviews())
        ];
    }
}
```

**Why ViewModels?**
- Prepare data on the server (faster than JavaScript)
- Replace Knockout.js observables
- Better performance
- Type-safe PHP code

---

### 2. Alpine.js Component

**File:** `view/frontend/templates/product/reviews-component.phtml`

```html
<div x-data="initProductReviews()" x-init="init()">
    <!-- Reactive state -->
    <div x-show="loading">Loading...</div>

    <!-- Filtered reviews -->
    <template x-for="review in filteredReviews">
        <div x-text="review.title"></div>
    </template>
</div>

<script>
function initProductReviews() {
    return {
        reviews: [],
        filterRating: 0,
        loading: false,

        get filteredReviews() {
            // Computed property
            return this.reviews.filter(r =>
                !this.filterRating || r.rating >= this.filterRating
            );
        },

        async loadReviews() {
            this.loading = true;
            // Fetch data
            this.loading = false;
        }
    }
}
</script>
```

**Key Alpine.js Features:**
- `x-data` - Component state
- `x-init` - Initialization
- `x-show`/`x-if` - Conditional rendering
- `x-for` - Loops
- `@click` - Event handlers
- `get filteredReviews()` - Computed properties
- `x-transition` - Smooth animations

---

### 3. Tailwind CSS Styling

**File:** `view/frontend/tailwind/components/product-reviews.css`

```css
@layer components {
    .review-card {
        @apply bg-white rounded-lg shadow-md p-6
               hover:shadow-lg transition-shadow;
    }

    .star-rating {
        @apply flex gap-1 text-yellow-400;
    }
}
```

**Tailwind Benefits:**
- Utility-first approach
- No CSS bloat (PurgeCSS)
- Mobile-first responsive
- JIT compilation for speed

---

### 4. Layout Integration

**File:** `view/frontend/layout/catalog_product_view.xml`

```xml
<referenceContainer name="product.info.main">
    <block name="product.reviews.hyva"
           template="Acme_HyvaProductReviews::product/reviews-component.phtml">
        <arguments>
            <argument name="view_model" xsi:type="object">
                Acme\HyvaProductReviews\ViewModel\ProductReviewsData
            </argument>
        </arguments>
    </block>
</referenceContainer>
```

---

## Installation

### 1. Copy to Magento

```bash
cp -r examples/Acme_HyvaProductReviews app/code/Acme/HyvaProductReviews
```

### 2. Enable Module

```bash
php bin/magento module:enable Acme_HyvaProductReviews
php bin/magento setup:upgrade
php bin/magento setup:di:compile
```

### 3. Rebuild Tailwind

```bash
cd app/design/frontend/Vendor/hyva-theme
npm run build-tailwind
```

### 4. Clear Cache

```bash
php bin/magento cache:flush
```

### 5. Test

Visit any product page - the reviews component should appear.

---

## Usage in Your Project

### Create Similar Component

```bash
# Use the /hyva-component command
/hyva-component MyComponent product "My component description"
```

### Customize This Example

1. **Modify ViewModel:**
   Edit `ViewModel/ProductReviewsData.php` to change data

2. **Update Template:**
   Edit `view/frontend/templates/product/reviews-component.phtml`

3. **Change Styles:**
   Edit `view/frontend/tailwind/components/product-reviews.css`

4. **Rebuild:**
   ```bash
   npm run build-tailwind
   php bin/magento cache:flush
   ```

---

## Alpine.js Patterns Shown

### 1. Component State
```javascript
x-data="{ open: false, items: [], loading: false }"
```

### 2. Computed Properties
```javascript
get filteredItems() {
    return this.items.filter(i => i.active);
}
```

### 3. Event Handling
```javascript
@click="toggle()"
@submit.prevent="handleSubmit()"
@input.debounce.500ms="search($event.target.value)"
```

### 4. Conditional Rendering
```html
<div x-show="loading">Loading...</div>
<div x-if="items.length === 0">No items</div>
```

### 5. Loops
```html
<template x-for="item in items" :key="item.id">
    <div x-text="item.name"></div>
</template>
```

### 6. Transitions
```html
<div x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100">
</div>
```

### 7. Two-Way Binding
```html
<input x-model="searchTerm">
<span x-text="searchTerm"></span>
```

### 8. Watchers
```javascript
this.$watch('filterRating', (value) => {
    console.log('Filter changed:', value);
});
```

---

## Tailwind Patterns Shown

### Layout
```html
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<div class="flex flex-col md:flex-row items-center justify-between">
```

### Typography
```html
<h1 class="text-2xl md:text-4xl font-bold text-gray-900">
<p class="text-sm md:text-base text-gray-600 leading-relaxed">
```

### Colors & Backgrounds
```html
<div class="bg-white text-gray-900 border-gray-200">
<button class="bg-primary hover:bg-primary-darker text-white">
```

### Effects
```html
<div class="shadow-md hover:shadow-lg transition-shadow">
<button class="transform hover:scale-105 transition-transform">
```

### Responsive
```html
<div class="hidden md:block">Desktop only</div>
<div class="block md:hidden">Mobile only</div>
<div class="w-full md:w-1/2 lg:w-1/3">Responsive width</div>
```

---

## Performance Best Practices

### 1. Lazy Loading
```html
<img loading="lazy" src="image.jpg">
```

### 2. Debounced Events
```html
<input @input.debounce.500ms="search($event.target.value)">
```

### 3. Conditional Loading
```javascript
init() {
    if (this.isVisible) {
        this.loadData();
    }
}
```

### 4. Intersection Observer
```html
<div x-intersect="loadWhenVisible()">
```

### 5. Optimized Tailwind
```bash
NODE_ENV=production npm run build-tailwind
# Removes unused CSS with PurgeCSS
```

---

## Testing

### Browser Console
```javascript
// Access Alpine component
const component = Alpine.$data(document.querySelector('[x-data="initProductReviews()"]'));
console.log(component.reviews); // Check state
component.loadReviews(); // Trigger method
```

### Manual Testing Checklist
- [ ] Component renders on product page
- [ ] Alpine.js reactivity works
- [ ] Filter by rating works
- [ ] Loading state displays
- [ ] Tailwind styles applied
- [ ] Mobile responsive
- [ ] No console errors
- [ ] Performance acceptable
- [ ] Accessibility (keyboard navigation, ARIA)

---

## Troubleshooting

### Component Not Rendering
```bash
# Check module enabled
php bin/magento module:status Acme_HyvaProductReviews

# Clear cache
php bin/magento cache:flush

# Check layout XML
grep -r "product.reviews.hyva" app/code/Acme/HyvaProductReviews/
```

### Alpine.js Not Working
- Check browser console for errors
- Verify Alpine.js loaded: `window.Alpine`
- Check component syntax: `x-data="initProductReviews()"`

### Styles Not Applied
```bash
# Rebuild Tailwind
cd app/design/frontend/Vendor/hyva-theme
npm run build-tailwind

# Check content paths in tailwind.config.js
# Must include: app/code/Acme/HyvaProductReviews/**/*.phtml
```

### ViewModel Data Not Loading
```bash
# Check DI compilation
php bin/magento setup:di:compile

# Verify ViewModel registered in layout XML
cat app/code/Acme/HyvaProductReviews/view/frontend/layout/catalog_product_view.xml
```

---

## Learning Resources

### Hyvä Themes
- Docs: https://docs.hyva.io/
- Slack: https://hyva.io/slack
- Academy: https://academy.hyva.io/

### Alpine.js
- Docs: https://alpinejs.dev/
- Examples: https://alpinejs.dev/examples
- Plugins: https://alpinejs.dev/plugins

### Tailwind CSS
- Docs: https://tailwindcss.com/
- Components: https://tailwindui.com/
- Cheat Sheet: https://nerdcave.com/tailwind-cheat-sheet

---

## Next Steps

1. **Study the code** - Read through all files
2. **Customize** - Modify for your needs
3. **Create your own** - Use `/hyva-component` command
4. **Explore** - Check Hyvä documentation
5. **Build** - Create amazing Magento 2 storefronts!

---

**This example demonstrates production-ready Hyvä Themes development with modern JavaScript and CSS!** 🚀
