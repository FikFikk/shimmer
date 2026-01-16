# Laravel Image Shimmer

Simple shimmer loading effect untuk image di Laravel.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Laravel](https://img.shields.io/badge/Laravel-9%2B-red.svg)

## Installation

```bash
composer require fikfikk/shimmer
```

## Usage

### Blade Component (Recommended)

```blade
<x-shimmer::image-shimmer
    src="{{ asset('storage/photo.jpg') }}"
    alt="My Photo"
    aspect-ratio="16/9"
/>
```

### Plain HTML

```html
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/fikfikk-shimmer@latest/dist/shimmer.min.css"
/>

<div class="shimmer-container" style="aspect-ratio: 16/9;">
  <div class="shimmer-placeholder">
    <div class="shimmer-animation"></div>
  </div>
  <img src="photo.jpg" alt="Photo" class="shimmer-image" data-shimmer-image />
</div>

<script src="https://cdn.jsdelivr.net/npm/fikfikk-shimmer@latest/dist/shimmer.min.js"></script>
```

### Helper Function

```php
<?= shimmer_image('photo.jpg', 'Alt text') ?>
```

### JavaScript

```javascript
FikfikkShimmer.create({
  container: "#gallery",
  src: "photo.jpg",
  alt: "Photo",
});
```

---

## ⚙️ Configuration

### Publish Configuration

```bash
php artisan vendor:publish --tag=shimmer-config
```

This creates `config/shimmer.php`:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Animation Duration
    |--------------------------------------------------------------------------
    | The duration of the shimmer animation effect.
    | Examples: '1s', '1.5s', '2s'
    */
    'animation_duration' => '1.5s',

    /*
    |--------------------------------------------------------------------------
    | Base Color
    |--------------------------------------------------------------------------
    | The background color of the shimmer placeholder.
    | Examples: '#e0e0e0', '#f5f5f5', 'rgb(224, 224, 224)'
    */
    'base_color' => '#e0e0e0',

    /*
    |--------------------------------------------------------------------------
    | Shimmer Color
    |--------------------------------------------------------------------------
    | The highlight color that moves across the shimmer.
    | Should be lighter than base_color for best effect.
    */
    'shimmer_color' => '#f0f0f0',

    /*
    |--------------------------------------------------------------------------
    | Border Radius
    |--------------------------------------------------------------------------
    | The border radius of the shimmer container.
    | Examples: '0', '8px', '16px', '50%' (for circles)
    */
    'border_radius' => '8px',

    /*
    |--------------------------------------------------------------------------
    | Default Aspect Ratio
    |--------------------------------------------------------------------------
    | The default aspect ratio when no height is specified.
    | Common values: '16/9', '4/3', '1/1', '21/9', '3/2'
    */
    'default_aspect_ratio' => '16/9',

    /*
    |--------------------------------------------------------------------------
    | Fade Duration
    |--------------------------------------------------------------------------
    | How long the fade-in animation takes when the image loads.
    | Examples: '0.2s', '0.3s', '0.5s'
    */
    'fade_duration' => '0.3s',
];
```

### Environment-Based Configuration

You can use environment variables in your `.env` file:

```env
SHIMMER_ANIMATION_DURATION=1.5s
SHIMMER_BASE_COLOR=#e0e0e0
SHIMMER_SHIMMER_COLOR=#f0f0f0
SHIMMER_BORDER_RADIUS=8px
```

Then in `config/shimmer.php`:

```php
return [
    'animation_duration' => env('SHIMMER_ANIMATION_DURATION', '1.5s'),
    'base_color' => env('SHIMMER_BASE_COLOR', '#e0e0e0'),
    // ... etc
];
```

## Customization

### Custom Colors

```css
:root {
  --shimmer-base: #e0e0e0;
  --shimmer-color: #f0f0f0;
}
```

### Dark Mode

```css
@media (prefers-color-scheme: dark) {
  :root {
    --shimmer-base: #1a1a1a;
    --shimmer-color: #2a2a2a;
  }
}
```

---

## 📊 API Reference

### Blade Component Props

| Prop           | Type        | Default   | Required | Description                                          |
| -------------- | ----------- | --------- | -------- | ---------------------------------------------------- |
| `src`          | string      | -         | ✅       | Image source URL                                     |
| `alt`          | string      | `''`      | ❌       | Image alt text for accessibility                     |
| `class`        | string      | `''`      | ❌       | Additional CSS classes                               |
| `width`        | string\|int | `null`    | ❌       | Container width (e.g., `'400'`, `'400px'`, `'50%'`)  |
| `height`       | string\|int | `null`    | ❌       | Container height (e.g., `'300'`, `'300px'`)          |
| `aspect-ratio` | string      | `'16/9'`  | ❌       | Aspect ratio when no height (e.g., `'4/3'`, `'1/1'`) |
| `loading`      | string      | `'lazy'`  | ❌       | Image loading strategy (`'lazy'` or `'eager'`)       |
| `decoding`     | string      | `'async'` | ❌       | Image decoding strategy (`'async'` or `'sync'`)      |

### Helper Function Signature

```php
shimmer_image(
    string $src,
    string $alt = '',
    string $class = '',
    string|int|null $width = null,
    string|int|null $height = null,
    ?string $aspectRatio = null,
    string $loading = 'lazy',
    string $decoding = 'async'
): string
```

### JavaScript API

#### `FikfikkShimmer.init()`

Initialize or re-initialize shimmer on all shimmer images in the DOM.

```javascript
// Call manually if needed
FikfikkShimmer.init();
```

#### `FikfikkShimmer.create(options)`

Create a shimmer image programmatically.

**Parameters:**

```typescript
{
    container: string | HTMLElement;  // Required: selector or element
    src: string;                      // Required: image URL
    alt?: string;                     // Optional: alt text (default: '')
    class?: string;                   // Optional: additional classes
    width?: string | number;          // Optional: container width
    height?: string | number;         // Optional: container height
    aspectRatio?: string;             // Optional: aspect ratio (default: '16/9')
    loading?: 'lazy' | 'eager';       // Optional: loading strategy
    decoding?: 'async' | 'sync';      // Optional: decoding strategy
    onLoad?: (img: HTMLImageElement) => void;   // Optional: callback
    onError?: (img: HTMLImageElement) => void;  // Optional: error callback
}
```

**Returns:** `HTMLElement | null` - The created shimmer container element

**Example:**

```javascript
const shimmerElement = FikfikkShimmer.create({
  container: "#gallery",
  src: "photo.jpg",
  alt: "My Photo",
  width: 400,
  height: 300,
  onLoad: (img) => console.log("Loaded!", img),
});
```

#### `FikfikkShimmer.refresh()`

Alias for `FikfikkShimmer.init()`. Use after adding dynamic content.

````javascript
// After AJAX load
fetch("/api/images").then((data) => {
  // Add images to DOM...
  FikfikkShimmer.refresh();
});
## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `src` | string | required | Image URL |
| `alt` | string | '' | Alt text |
| `class` | string | '' | CSS classes |
| `width` | string/int | null | Width |
| `height` | string/int | null | Height |
| `aspect-ratio` | string | '16/9' | Aspect ratio |
| `loading` | string | 'lazy' | Loading strategy |

## Examples

### Product Grid

```blade
@foreach($products as $product)
    <x-shimmer::image-shimmer
        src="{{ $product->image }}"
        alt="{{ $product->name }}"
        aspect-ratio="1/1"
    />
@endforeach
````

### User Avatar

````blade
<x-shimmer::image-shimmer
    src="{{ $user->avatar }}"
    alt="{{ $user->name }}"
    width="60"
    height="60"
    class="rounded-full"
/

### Can I change the shimmer color?

Yes, multiple ways:

```blade
{{-- Method 1: Config file --}}
php artisan vendor:publish --tag=shimmer-config
<!-- Then edit config/shimmer.php -->

{{-- Method 2: CSS variables --}}
<x-shimmer::image-shimmer
    src="..."
    style="--shimmer-base: #000; --shimmer-color: #333;"
/>

{{-- Method 3: Global CSS --}}
<style>
    :root {
        --shimmer-base: #your-color;
        --shimmer-color: #your-color;
    }
</style>
````

### Does it work with responsive images?

Yes! Use with `srcset`:

```html
<div class="shimmer-container">
  <img
    src="small.jpg"
    srcset="small.jpg 400w, medium.jpg 800w, large.jpg 1200w"
    sizes="(max-width: 600px) 400px, 800px"
    class="shimmer-image"
    data-shimmer-image
  />
</div>
```

### Is it accessible?

Yes! Always include `alt` text:

```blade
<x-shimmer::image-shimmer
    src="..."
    alt="Descriptive text here"  <!-- Important for screen readers -->
/>
```

### Can I use it with image optimization services?

Absolutely! Works with any image URL:

```blade
{{-- With Cloudinary --}}
<x-shimmer::image-shimmer
    src="https://res.cloudinary.com/demo/image/upload/w_400,f_auto/..."
    alt="..."
/>

{{-- With Imgix --}}
<x-shimmer::image-shimmer
    src="https://assets.imgix.net/image.jpg?w=400&auto=format"
    alt="..."
/>
```

### Does it work with Alpine.js?

Yes! See [Alpine.js Integration](#alpinejs).

### Does it work with Livewire?

Yes! See [Livewire Integration](#livewire).

### Can I disable the shimmer effect?

Yes, just use a regular `<img>` tag or set `display: none` on the shimmer:

```css
.shimmer-placeholder {
  display: none !important;
}
```

### How do I test if images are loading correctly?

Use browser DevTools Network tab or add callbacks:

```javascript
FikfikkShimmer.create({
  src: "image.jpg",
  onLoad: (img) => console.log("✅ Loaded:", img.src),
  onError: (img) => console.error("❌ Failed:", img.src),
});
```

---

## 📦 Browser Support

| Browser | Version                |
| ------- | ---------------------- |
| Chrome  | ✅ All modern versions |
| Firefox | ✅ All modern versions |
| Safari  | ✅ 14+                 |
| Edge    | ✅ All modern versions |
| Opera   | ✅ All modern versions |
| Mobile  | ✅ iOS 14+, Android 5+ |

**Note:** Uses native CSS animations and Intersection Observer API.

---

## 🔄 Changelog

See [CHANGELOG.md](CHANGELOG.md) for detailed version history.

### Version 1.0.0 (2026-01-16)

- 🎉 Initial release
- ✨ Blade component support
- ✨ Plain HTML support
- ✨ JavaScript API
- ✨ Helper functions
- ✨ Dark mode support
- ✨ Customizable via config
- ✨ CDN support
- 📚 Complete documentation

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

Feel free to check the [issues page](https://github.com/fikfikk/shimmer/issues) or submit a PR.

### Development Setup

```bash
# Clone the repository
git clone https://github.com/fikfikk/shimmer.git
cd shimmer

# Install dependencies
composer install

# Run tests (coming soon)
composer test
```

### Guidelines

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/AmazingFeature`
3. Commit your changes: `git commit -m 'Add some AmazingFeature'`
4. Push to the branch: `git push origin feature/AmazingFeature`
5. Open a Pull Request

See [CONTRIBUTING.md](CONTRIBUTING.md) for detailed contribution guidelines.

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

---

## 🙏 Credits & Acknowledgments

- **Created by:** [FikFikk](https://github.com/fikfikk)
- **Inspired by:** Facebook's content placeholders and modern UX patterns
- **Built with:** Laravel, Vanilla JavaScript, and CSS Animations

### Special Thanks

- Laravel community for amazing package ecosystem
- All contributors and users of this package

---

## 📞 Support & Contact

- 🐛 **Bug Reports:** [GitHub Issues](https://github.com/fikfikk/shimmer/issues)
- 💡 **Feature Requests:** [GitHub Issues](https://github.com/fikfikk/shimmer/issues)
- 💬 **Discussions:** [GitHub Discussions](https://github.com/fikfikk/shimmer/discussions)
- 📧 **Email:** fikfikk14@gmail.com
- 🐦 **Twitter:** [@fikfikk](https://twitter.com/fikfikk)

---

## ⭐ Show Your Support

If this package helped you, please give it a ⭐️ on [GitHub](https://github.com/fikfikk/shimmer)!

---

## 🔗 Links

- **Documentation:** [GitHub README](https://github.com/fikfikk/shimmer)
- **Packagist:** [packagist.org/packages/fikfikk/shimmer](https://packagist.org/packages/fikfikk/shimmer)
- **npm (Coming Soon):** Vue & React wrappers
- **CDN:** jsDelivr

---

<p align="center">Made with ❤️ by <a href="https://github.com/fikfikk">FikFikk</a></p>
## License

MIT License - lihat [LICENSE.md](LICENSE.md)

## Credits

Created by [FikFikk](https://github.com/fikfikk)

## Support

- 🐛 [Report Bug](https://github.com/fikfikk/shimmer/issues)
- 📧 Email: fikfikk14@gmail.com
