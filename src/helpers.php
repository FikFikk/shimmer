<?php

if (!function_exists('shimmer_image')) {
    /**
     * Generate a shimmer image HTML.
     *
     * @param string $src Image source URL
     * @param string $alt Image alt text
     * @param string $class Additional CSS classes
     * @param string|int|null $width Container width
     * @param string|int|null $height Container height
     * @param string|null $aspectRatio Aspect ratio (e.g., '16/9')
     * @param string $loading Loading attribute ('lazy' or 'eager')
     * @param string $decoding Decoding attribute ('async' or 'sync')
     * @return string
     */
    function shimmer_image(
        string $src,
        string $alt = '',
        string $class = '',
        $width = null,
        $height = null,
        ?string $aspectRatio = null,
        string $loading = 'lazy',
        string $decoding = 'async'
    ): string {
        return view('shimmer::components.image-shimmer', [
            'src' => $src,
            'alt' => $alt,
            'class' => $class,
            'width' => $width,
            'height' => $height,
            'aspectRatio' => $aspectRatio ?? config('shimmer.default_aspect_ratio', '16/9'),
            'loading' => $loading,
            'decoding' => $decoding,
        ])->render();
    }
}

if (!function_exists('shimmer_styles')) {
    /**
     * Get the shimmer CSS styles.
     *
     * @return string
     */
    function shimmer_styles(): string
    {
        $animationDuration = config('shimmer.animation_duration', '1.5s');
        $baseColor = config('shimmer.base_color', '#e0e0e0');
        $shimmerColor = config('shimmer.shimmer_color', '#f0f0f0');
        $borderRadius = config('shimmer.border_radius', '8px');
        $fadeDuration = config('shimmer.fade_duration', '0.3s');

        return <<<CSS
<style>
    .shimmer-image-container {
        position: relative;
        overflow: hidden;
        background-color: {$baseColor};
        border-radius: {$borderRadius};
        width: 100%;
    }
    .shimmer-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: {$baseColor};
        overflow: hidden;
    }
    .shimmer-animation {
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent 0%, {$shimmerColor} 50%, transparent 100%);
        animation: shimmer {$animationDuration} infinite;
    }
    .shimmer-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: opacity {$fadeDuration} ease-in-out;
    }
    .shimmer-image.loaded {
        opacity: 1 !important;
    }
    .shimmer-placeholder.hidden {
        display: none;
    }
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
</style>
CSS;
    }
}

if (!function_exists('shimmer_scripts')) {
    /**
     * Get the shimmer JavaScript.
     *
     * @return string
     */
    function shimmer_scripts(): string
    {
        return <<<JS
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('[data-shimmer-image]');
        
        images.forEach(function(img) {
            const container = img.closest('[data-shimmer-container]');
            const placeholder = container.querySelector('[data-shimmer-placeholder]');
            
            function imageLoaded() {
                img.classList.add('loaded');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }
            
            if (img.complete) {
                imageLoaded();
            } else {
                img.addEventListener('load', imageLoaded);
                img.addEventListener('error', function() {
                    placeholder.classList.add('hidden');
                });
            }
        });
    });
</script>
JS;
    }
}
