<?php

if (!function_exists('shimmer_image')) {
    /**
     * Generate a shimmer image HTML.
     *
     * @param string $src Image source URL
     * @param string $alt Image alt text
     * @param string $class Additional CSS classes
     * @param string|int|null $width Container width (optional)
     * @param string|int|null $height Container height (optional)
     * @param string|null $aspectRatio Aspect ratio (optional, e.g., '16/9')
     * @param string $loading Loading attribute ('lazy' or 'eager')
     * @param string $decoding Decoding attribute ('async' or 'sync')
     * @return string
     */
    function shimmer_image(
        string $src,
        string $alt = '',
        string $class = '',
        string|int|null $width = null,
        string|int|null $height = null,
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
            'aspectRatio' => $aspectRatio,
            'loading' => $loading,
            'decoding' => $decoding,
        ])->render();
    }
}

if (!function_exists('shimmer_html')) {
    /**
     * Generate plain HTML shimmer (for non-Laravel usage).
     *
     * @param string $src Image source URL
     * @param string $alt Image alt text
     * @param array $options Additional options (class, width, height, aspectRatio)
     * @return string
     */
    function shimmer_html(
        string $src,
        string $alt = '',
        array $options = []
    ): string {
        $class = $options['class'] ?? '';
        $width = $options['width'] ?? null;
        $height = $options['height'] ?? null;
        $aspectRatio = $options['aspectRatio'] ?? null;
        $loading = $options['loading'] ?? 'lazy';
        $decoding = $options['decoding'] ?? 'async';

        $styles = [];
        if ($width) {
            $styles[] = 'width:' . (is_numeric($width) ? $width . 'px' : $width);
        }
        if ($height) {
            $styles[] = 'height:' . (is_numeric($height) ? $height . 'px' : $height);
        }
        if (!$height && $aspectRatio) {
            $styles[] = 'aspect-ratio:' . $aspectRatio;
        }

        $styleAttr = $styles ? ' style="' . implode(';', $styles) . '"' : '';
        $className = 'shimmer-container' . ($class ? ' ' . $class : '');

        return <<<HTML
<div class="{$className}" data-shimmer{$styleAttr}>
    <div class="shimmer-placeholder">
        <div class="shimmer-animation"></div>
    </div>
    <img src="{$src}" alt="{$alt}" class="shimmer-image" loading="{$loading}" decoding="{$decoding}" data-shimmer-image>
</div>
HTML;
    }
}

if (!function_exists('shimmer_assets')) {
    /**
     * Get both CSS and JS inline for quick setup.
     *
     * @return string
     */
    function shimmer_assets(): string
    {
        return shimmer_styles() . "\n" . shimmer_scripts();
    }
}

if (!function_exists('shimmer_styles')) {
    /**
     * Get the shimmer CSS styles.
     *
     * @param array $config Override default configuration
     * @return string
     */
    function shimmer_styles(array $config = []): string
    {
        $baseColor = $config['base_color'] ?? config('shimmer.base_color', '#e0e0e0');
        $shimmerColor = $config['shimmer_color'] ?? config('shimmer.shimmer_color', '#f0f0f0');
        $duration = $config['animation_duration'] ?? config('shimmer.animation_duration', '1.5s');
        $radius = $config['border_radius'] ?? config('shimmer.border_radius', '8px');
        $fade = $config['fade_duration'] ?? config('shimmer.fade_duration', '0.3s');

        return <<<CSS
<style>
:root{--shimmer-base:{$baseColor};--shimmer-color:{$shimmerColor};--shimmer-duration:{$duration};--shimmer-radius:{$radius};--shimmer-fade:{$fade}}
.shimmer-container{position:relative;overflow:hidden;background-color:var(--shimmer-base);border-radius:var(--shimmer-radius);display:block}
.shimmer-placeholder{position:absolute;inset:0;background-color:var(--shimmer-base);overflow:hidden;z-index:1;transition:opacity var(--shimmer-fade) ease}
.shimmer-placeholder.loaded{opacity:0;pointer-events:none}
.shimmer-animation{width:100%;height:100%;background:linear-gradient(90deg,transparent 0%,var(--shimmer-color) 50%,transparent 100%);animation:shimmer-slide var(--shimmer-duration) infinite}
.shimmer-image{width:100%;height:100%;object-fit:cover;display:block;opacity:0;transition:opacity var(--shimmer-fade) ease}
.shimmer-image.loaded{opacity:1}
@keyframes shimmer-slide{0%{transform:translateX(-100%)}100%{transform:translateX(100%)}}
.shimmer-rounded{--shimmer-radius:50%}.shimmer-rounded-lg{--shimmer-radius:16px}.shimmer-rounded-none{--shimmer-radius:0}
.shimmer-fast{--shimmer-duration:0.8s}.shimmer-slow{--shimmer-duration:2.5s}
@media(prefers-color-scheme:dark){:root{--shimmer-base:#2a2a2a;--shimmer-color:#3a3a3a}}
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
(function(){function t(){document.querySelectorAll("[data-shimmer-image]:not(.shimmer-initialized)").forEach(function(e){e.classList.add("shimmer-initialized");var n=e.closest("[data-shimmer],.shimmer-container"),i=n?n.querySelector(".shimmer-placeholder"):null;function o(){e.classList.add("loaded");i&&i.classList.add("loaded")}e.complete&&e.naturalHeight!==0?o():(e.addEventListener("load",o),e.addEventListener("error",function(){i&&i.classList.add("loaded")}))})}document.readyState==="loading"?document.addEventListener("DOMContentLoaded",t):t();window.ShimmerRefresh=t})();
</script>
JS;
    }
}

if (!function_exists('shimmer_cdn')) {
    /**
     * Get CDN links for CSS and JS.
     *
     * @param string $version Version number (default: latest)
     * @return array
     */
    function shimmer_cdn(string $version = 'latest'): array
    {
        $base = "https://cdn.jsdelivr.net/npm/fikfikk-shimmer@{$version}/dist";

        return [
            'css' => "{$base}/shimmer.min.css",
            'js' => "{$base}/shimmer.min.js",
            'html' => "<link rel=\"stylesheet\" href=\"{$base}/shimmer.min.css\">\n<script src=\"{$base}/shimmer.min.js\" defer></script>",
        ];
    }
}
