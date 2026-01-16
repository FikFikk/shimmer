@php
    // Safely derive variables: prefer explicit props, fallback to attributes bag, else null/defaults
    $width = isset($width) ? $width : (isset($attributes) ? $attributes->get('width') : null);
    $height = isset($height) ? $height : (isset($attributes) ? $attributes->get('height') : null);

    // aspect-ratio may be passed as 'aspect-ratio' or 'aspectRatio'
    $aspectRatio = isset($aspectRatio)
        ? $aspectRatio
        : (isset($attributes)
            ? $attributes->get('aspect-ratio') ?? $attributes->get('aspectRatio')
            : null);

    $class = isset($class) ? $class : (isset($attributes) ? $attributes->get('class') : '');
    $alt = isset($alt) ? $alt : '';
    $loading = isset($loading) ? $loading : 'lazy';
    $decoding = isset($decoding) ? $decoding : 'async';

    $styles = [];

    if ($width) {
        $styles[] = 'width: ' . (is_numeric($width) ? $width . 'px' : $width);
    }

    if ($height) {
        $styles[] = 'height: ' . (is_numeric($height) ? $height . 'px' : $height);
    }

    // Only apply aspect-ratio if no explicit height AND aspectRatio is provided
    if (!$height && $aspectRatio) {
        $styles[] = 'aspect-ratio: ' . $aspectRatio;
    }

    $inlineStyle = implode('; ', $styles);
@endphp

<div class="shimmer-container{{ $class ? ' ' . $class : '' }}"
    @if ($inlineStyle) style="{{ $inlineStyle }}" @endif data-shimmer>

    {{-- Shimmer Placeholder --}}
    <div class="shimmer-placeholder">
        <div class="shimmer-animation"></div>
    </div>

    {{-- Actual Image --}}
    <img src="{{ $src }}" alt="{{ $alt }}" class="shimmer-image" loading="{{ $loading }}"
        decoding="{{ $decoding }}" data-shimmer-image>
</div>

@once
    @push('styles')
        <style>
            :root {
                --shimmer-base: {{ config('shimmer.base_color', '#e0e0e0') }};
                --shimmer-color: {{ config('shimmer.shimmer_color', '#f0f0f0') }};
                --shimmer-duration: {{ config('shimmer.animation_duration', '1.5s') }};
                --shimmer-radius: {{ config('shimmer.border_radius', '8px') }};
                --shimmer-fade: {{ config('shimmer.fade_duration', '0.3s') }};
            }

            .shimmer-container {
                position: relative;
                overflow: hidden;
                background-color: var(--shimmer-base);
                border-radius: var(--shimmer-radius);
                display: block;
            }

            .shimmer-placeholder {
                position: absolute;
                inset: 0;
                background-color: var(--shimmer-base);
                overflow: hidden;
                z-index: 1;
                transition: opacity var(--shimmer-fade) ease;
            }

            .shimmer-placeholder.loaded {
                opacity: 0;
                pointer-events: none;
            }

            .shimmer-animation {
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg,
                        transparent 0%,
                        var(--shimmer-color) 50%,
                        transparent 100%);
                animation: shimmer-slide var(--shimmer-duration) infinite;
            }

            .shimmer-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
                opacity: 0;
                transition: opacity var(--shimmer-fade) ease;
            }

            .shimmer-image.loaded {
                opacity: 1;
            }

            @keyframes shimmer-slide {
                0% {
                    transform: translateX(-100%);
                }

                100% {
                    transform: translateX(100%);
                }
            }

            /* Utility variants */
            .shimmer-container.shimmer-cover .shimmer-image {
                object-fit: cover;
            }

            .shimmer-container.shimmer-contain .shimmer-image {
                object-fit: contain;
            }

            .shimmer-container.shimmer-fill .shimmer-image {
                object-fit: fill;
            }

            /* Border radius variants */
            .shimmer-container.shimmer-rounded {
                --shimmer-radius: 50%;
            }

            .shimmer-container.shimmer-rounded-lg {
                --shimmer-radius: 16px;
            }

            .shimmer-container.shimmer-rounded-none {
                --shimmer-radius: 0;
            }

            /* Speed variants */
            .shimmer-container.shimmer-fast {
                --shimmer-duration: 0.8s;
            }

            .shimmer-container.shimmer-slow {
                --shimmer-duration: 2.5s;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function() {
                function initShimmer() {
                    document.querySelectorAll('[data-shimmer-image]:not(.shimmer-initialized)').forEach(function(img) {
                        img.classList.add('shimmer-initialized');
                        var container = img.closest('[data-shimmer]');
                        var placeholder = container ? container.querySelector('.shimmer-placeholder') : null;

                        function onLoad() {
                            img.classList.add('loaded');
                            if (placeholder) placeholder.classList.add('loaded');
                        }

                        function onError() {
                            if (placeholder) placeholder.classList.add('loaded');
                        }

                        if (img.complete && img.naturalHeight !== 0) {
                            onLoad();
                        } else {
                            img.addEventListener('load', onLoad);
                            img.addEventListener('error', onError);
                        }
                    });
                }

                // Initialize on DOM ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initShimmer);
                } else {
                    initShimmer();
                }

                // Expose refresh function globally
                window.ShimmerRefresh = initShimmer;
            })
            ();
        </script>
    @endpush
@endonce
