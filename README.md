# 🌟 Fikfikk Shimmer

Beautiful, lightweight image shimmer loading effect for any web project.

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)
[![Laravel](https://img.shields.io/badge/Laravel-9%20|%2010%20|%2011%20|%2012-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.0%2B-purple.svg)](https://php.net)

## ✨ Features

- 🚀 **Zero Dependencies** - Pure CSS & vanilla JS
- 🎨 **Customizable** - Colors, speed, border radius
- 🌙 **Dark Mode** - Automatic dark mode support
- ♿ **Accessible** - Respects `prefers-reduced-motion`
- 📦 **Universal** - Works with Laravel, Vue, React, Alpine.js, or plain HTML
- ⚡ **Lightweight** - < 2KB minified + gzipped

---

## 📦 Installation

### Laravel (Composer)

```bash
composer require fikfikk/shimmer
```

### CDN (HTML/JS/Vue/React)

```html
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/fikfikk-shimmer@latest/dist/shimmer.min.css"
/>
<script
  src="https://cdn.jsdelivr.net/npm/fikfikk-shimmer@latest/dist/shimmer.min.js"
  defer
></script>
```

### NPM (Coming Soon)

```bash
npm install fikfikk-shimmer
```

---

## 🚀 Quick Start

### Laravel Blade

```blade
{{-- Simple usage - auto size based on image --}}
<x-shimmer::image-shimmer src="{{ asset('photo.jpg') }}" alt="Photo" />

{{-- With aspect ratio --}}
<x-shimmer::image-shimmer
    src="{{ $product->image }}"
    alt="{{ $product->name }}"
    aspect-ratio="4/3"
/>

{{-- With fixed dimensions --}}
<x-shimmer::image-shimmer
    src="{{ $user->avatar }}"
    alt="{{ $user->name }}"
    width="100"
    height="100"
    class="shimmer-rounded"
/>
```

### Plain HTML

```html
<div class="shimmer-container" style="aspect-ratio: 16/9;">
  <div class="shimmer-placeholder">
    <div class="shimmer-animation"></div>
  </div>
  <img src="photo.jpg" alt="Photo" class="shimmer-image" data-shimmer-image />
</div>
```

### JavaScript API

```javascript
// Create shimmer programmatically
FikfikkShimmer.create({
  container: "#my-container",
  src: "photo.jpg",
  alt: "My Photo",
  aspectRatio: "16/9",
  onLoad: (img) => console.log("Loaded!", img),
});

// Refresh after dynamic content
FikfikkShimmer.refresh();
```

### Vue 3

```vue
<template>
  <ShimmerImage
    :src="product.image"
    :alt="product.name"
    aspect-ratio="1/1"
    @load="onImageLoad"
  />
</template>

<script setup>
import { ShimmerImage } from "fikfikk-shimmer/vue";
</script>
```

### React

```jsx
import { ShimmerImage } from "fikfikk-shimmer/react";

function ProductCard({ product }) {
  return (
    <ShimmerImage
      src={product.image}
      alt={product.name}
      aspectRatio="1/1"
      className="product-image"
      onLoad={() => console.log("Loaded!")}
    />
  );
}
```

### PHP Helper Function

```php
<?= shimmer_image($product->image, $product->name, 'my-class') ?>

// Or with options
<?= shimmer_html('photo.jpg', 'Alt text', [
    'aspectRatio' => '16/9',
    'class' => 'my-image'
]) ?>
```

---

## 📐 Props / Attributes

| Prop           | Type             | Default      | Description                                |
| -------------- | ---------------- | ------------ | ------------------------------------------ |
| `src`          | `string`         | **required** | Image source URL                           |
| `alt`          | `string`         | `''`         | Image alt text                             |
| `class`        | `string`         | `''`         | Additional CSS classes                     |
| `width`        | `string\|number` | `null`       | Container width (e.g., `400`, `'50%'`)     |
| `height`       | `string\|number` | `null`       | Container height                           |
| `aspect-ratio` | `string`         | `null`       | CSS aspect ratio (e.g., `'16/9'`, `'1/1'`) |
| `loading`      | `string`         | `'lazy'`     | `'lazy'` or `'eager'`                      |
| `decoding`     | `string`         | `'async'`    | `'async'` or `'sync'`                      |

> 💡 **Tip:** If no `width`, `height`, or `aspect-ratio` is provided, the container will size automatically based on the image dimensions.

---

## 🎨 Utility Classes

### Border Radius

```html
<div class="shimmer-container shimmer-rounded">
  <!-- Circle -->
  <div class="shimmer-container shimmer-rounded-sm">
    <!-- 4px -->
    <div class="shimmer-container shimmer-rounded-lg">
      <!-- 16px -->
      <div class="shimmer-container shimmer-rounded-xl">
        <!-- 24px -->
        <div class="shimmer-container shimmer-rounded-none"><!-- 0 --></div>
      </div>
    </div>
  </div>
</div>
```

### Animation Speed

```html
<div class="shimmer-container shimmer-fast">
  <!-- 0.8s -->
  <div class="shimmer-container shimmer-slow"><!-- 2.5s --></div>
</div>
```

### Object Fit

```html
<div class="shimmer-container shimmer-cover">
  <!-- object-fit: cover -->
  <div class="shimmer-container shimmer-contain">
    <!-- object-fit: contain -->
    <div class="shimmer-container shimmer-fill"><!-- object-fit: fill --></div>
  </div>
</div>
```

### Dark Mode

```html
<div class="shimmer-container shimmer-dark"><!-- Force dark theme --></div>
```

---

## ⚙️ Configuration (Laravel)

### Publish Config

```bash
php artisan vendor:publish --tag=shimmer-config
```

### `config/shimmer.php`

```php
return [
    'animation_duration' => '1.5s',    // Shimmer speed
    'base_color' => '#e0e0e0',         // Background color
    'shimmer_color' => '#f0f0f0',      // Highlight color
    'border_radius' => '8px',          // Default radius
    'fade_duration' => '0.3s',         // Fade-in speed
];
```

### Environment Variables

```env
SHIMMER_ANIMATION_DURATION=1.5s
SHIMMER_BASE_COLOR=#e0e0e0
SHIMMER_SHIMMER_COLOR=#f0f0f0
SHIMMER_BORDER_RADIUS=8px
SHIMMER_FADE_DURATION=0.3s
```

---

## 🎨 CSS Customization

### CSS Variables

```css
:root {
  --shimmer-base: #e0e0e0; /* Background */
  --shimmer-color: #f0f0f0; /* Highlight */
  --shimmer-duration: 1.5s; /* Animation speed */
  --shimmer-radius: 8px; /* Border radius */
  --shimmer-fade: 0.3s; /* Fade duration */
}
```

### Custom Theme

```css
/* Green theme */
.shimmer-green {
  --shimmer-base: #e8f5e9;
  --shimmer-color: #c8e6c9;
}

/* Purple theme */
.shimmer-purple {
  --shimmer-base: #f3e5f5;
  --shimmer-color: #e1bee7;
}
```

### Per-Element Customization

```blade
{{-- Inline style override --}}
<x-shimmer::image-shimmer
    src="photo.jpg"
    style="--shimmer-base: #fce4ec; --shimmer-color: #f8bbd9;"
/>
```

### Dark Mode

```css
/* Automatic */
@media (prefers-color-scheme: dark) {
  :root {
    --shimmer-base: #2a2a2a;
    --shimmer-color: #3a3a3a;
  }
}

/* Manual with class */
.dark .shimmer-container {
  --shimmer-base: #2a2a2a;
  --shimmer-color: #3a3a3a;
}
```

---

## 🔧 JavaScript API

### `FikfikkShimmer.init([selector])`

Initialize shimmer on elements. Called automatically on page load.

```javascript
// Initialize all
FikfikkShimmer.init();

// Initialize within container
FikfikkShimmer.init("#gallery");
```

### `FikfikkShimmer.create(options)`

Create shimmer element programmatically.

```javascript
const element = FikfikkShimmer.create({
  container: "#target", // Required: selector or element
  src: "image.jpg", // Required: image URL
  alt: "Description", // Optional
  class: "my-class", // Optional
  width: 400, // Optional
  height: 300, // Optional
  aspectRatio: "16/9", // Optional (ignored if height set)
  loading: "lazy", // Optional: 'lazy' | 'eager'
  decoding: "async", // Optional: 'async' | 'sync'
  onLoad: (img) => {}, // Optional: callback
  onError: (img) => {}, // Optional: callback
});
```

### `FikfikkShimmer.refresh([selector])`

Reinitialize after dynamic content changes.

```javascript
// After AJAX/fetch
fetch("/api/images").then(() => {
  // ... add images to DOM
  FikfikkShimmer.refresh();
});

// After Vue/React update
FikfikkShimmer.refresh("#gallery");
```

### `FikfikkShimmer.destroy([selector])`

Remove shimmer and restore plain images.

```javascript
FikfikkShimmer.destroy("#gallery");
```

---

## 🔌 Framework Integration

### Alpine.js

```html
<div x-data="{ loaded: false }">
  <div class="shimmer-container" style="aspect-ratio: 16/9;">
    <div class="shimmer-placeholder" :class="{ loaded }">
      <div class="shimmer-animation"></div>
    </div>
    <img
      src="photo.jpg"
      class="shimmer-image"
      :class="{ loaded }"
      @load="loaded = true"
    />
  </div>
</div>
```

### Livewire

```blade
{{-- Works out of the box --}}
<x-shimmer::image-shimmer
    src="{{ $image }}"
    wire:key="image-{{ $id }}"
/>

{{-- Refresh after Livewire update --}}
<script>
    Livewire.hook('message.processed', () => {
        if (window.FikfikkShimmer) {
            FikfikkShimmer.refresh();
        }
    });
</script>
```

### Inertia.js

```javascript
// In your Vue/React component
import { onMounted, onUpdated } from "vue";

onMounted(() => FikfikkShimmer?.init());
onUpdated(() => FikfikkShimmer?.refresh());
```

---

## 📚 Examples

### Product Grid

```blade
<div class="grid grid-cols-4 gap-4">
    @foreach($products as $product)
        <x-shimmer::image-shimmer
            src="{{ $product->image }}"
            alt="{{ $product->name }}"
            aspect-ratio="1/1"
            class="shimmer-rounded-lg"
        />
    @endforeach
</div>
```

### User Avatar

```blade
<x-shimmer::image-shimmer
    src="{{ $user->avatar }}"
    alt="{{ $user->name }}"
    width="48"
    height="48"
    class="shimmer-rounded"
/>
```

### Hero Banner

```blade
<x-shimmer::image-shimmer
    src="{{ $banner->image }}"
    alt="{{ $banner->title }}"
    aspect-ratio="21/9"
    loading="eager"
    class="shimmer-rounded-none"
/>
```

### Gallery with Lightbox

```blade
@foreach($gallery as $image)
    <a href="{{ $image->full }}" data-lightbox="gallery">
        <x-shimmer::image-shimmer
            src="{{ $image->thumbnail }}"
            alt="{{ $image->caption }}"
            aspect-ratio="4/3"
        />
    </a>
@endforeach
```

---

## ❓ FAQ

### Does it work without Laravel?

Yes! Use the CDN or copy the CSS/JS files. The shimmer works with any HTML page.

### Why isn't the shimmer showing?

1. Make sure CSS is loaded before the image
2. Check that `data-shimmer-image` attribute is on the `<img>`
3. Call `FikfikkShimmer.init()` after adding dynamic content

### How do I change colors for a specific element?

Use inline CSS variables:

```blade
<x-shimmer::image-shimmer
    src="photo.jpg"
    style="--shimmer-base: #fce4ec; --shimmer-color: #f8bbd9;"
/>
```

### Does it support srcset/responsive images?

Yes!

```html
<div class="shimmer-container" data-shimmer>
  <div class="shimmer-placeholder"><div class="shimmer-animation"></div></div>
  <img
    src="small.jpg"
    srcset="small.jpg 400w, medium.jpg 800w, large.jpg 1200w"
    sizes="(max-width: 600px) 400px, 800px"
    class="shimmer-image"
    data-shimmer-image
  />
</div>
```

### Can I disable shimmer animation?

For users who prefer reduced motion, it's automatic. To disable manually:

```css
.shimmer-animation {
  animation: none !important;
}
```

---

## 📄 License

MIT License - see [LICENSE.md](LICENSE.md)

---

## 🙏 Credits

Created by [FikFikk](https://github.com/fikfikk)

---

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.
