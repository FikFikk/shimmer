<div class="shimmer-image-container {{ $class }}"
    style="
        @if ($width) width: {{ is_numeric($width) ? $width . 'px' : $width }}; @endif
        @if ($height) height: {{ is_numeric($height) ? $height . 'px' : $height }}; @endif
        @if (!$height && $aspectRatio) aspect-ratio: {{ $aspectRatio }}; @endif
     "
    data-shimmer-container>

    {{-- Shimmer Placeholder --}}
    <div class="shimmer-placeholder" data-shimmer-placeholder>
        <div class="shimmer-animation"></div>
    </div>

    {{-- Actual Image --}}
    <img src="{{ $src }}" alt="{{ $alt }}" class="shimmer-image" loading="{{ $loading }}"
        decoding="{{ $decoding }}" data-shimmer-image style="opacity: 0;">
</div>

@once
    @push('styles')
        <style>
            .shimmer-image-container {
                position: relative;
                overflow: hidden;
                background-color: {{ config('shimmer.base_color', '#e0e0e0') }};
                border-radius: {{ config('shimmer.border_radius', '8px') }};
                width: 100%;
            }

            .shimmer-placeholder {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: {{ config('shimmer.base_color', '#e0e0e0') }};
                overflow: hidden;
            }

            .shimmer-animation {
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg,
                        transparent 0%,
                        {{ config('shimmer.shimmer_color', '#f0f0f0') }} 50%,
                        transparent 100%);
                animation: shimmer {{ config('shimmer.animation_duration', '1.5s') }} infinite;
            }

            .shimmer-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
                transition: opacity {{ config('shimmer.fade_duration', '0.3s') }} ease-in-out;
            }

            .shimmer-image.loaded {
                opacity: 1 !important;
            }

            .shimmer-placeholder.hidden {
                display: none;
            }

            @keyframes shimmer {
                0% {
                    transform: translateX(-100%);
                }

                100% {
                    transform: translateX(100%);
                }
            }
        </style>
    @endpush

    @push('scripts')
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
    @endpush
@endonce
