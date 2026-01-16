/**
 * Fikfikk Shimmer - Laravel Image Shimmer Package
 * @version 1.0.0
 * @author FikFikk
 * @license MIT
 */

const FikfikkShimmer = {
    /**
     * Initialize shimmer effect on all shimmer images
     */
    init: function () {
        document.querySelectorAll('[data-shimmer-image], .shimmer-image').forEach(img => {
            const container = img.closest('[data-shimmer-container], [data-shimmer], .shimmer-container, .shimmer-image-container');
            const placeholder = container?.querySelector('[data-shimmer-placeholder], .shimmer-placeholder');

            function imageLoaded() {
                img.classList.add('loaded');
                img.style.opacity = '1';
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }

            // Check if image is already loaded (from cache)
            if (img.complete && img.naturalHeight !== 0) {
                imageLoaded();
            } else {
                img.addEventListener('load', imageLoaded);
                img.addEventListener('error', () => {
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                });
            }
        });
    },

    /**
     * Create a new shimmer image programmatically
     * @param {Object} options - Configuration options
     * @param {string|HTMLElement} options.container - Container selector or element
     * @param {string} options.src - Image source URL
     * @param {string} [options.alt=''] - Image alt text
     * @param {string} [options.class=''] - Additional CSS classes
     * @param {string|number} [options.width] - Container width
     * @param {string|number} [options.height] - Container height
     * @param {string} [options.aspectRatio='16/9'] - Aspect ratio
     * @param {string} [options.loading='lazy'] - Loading attribute
     * @param {string} [options.decoding='async'] - Decoding attribute
     * @param {Function} [options.onLoad] - Callback when image loads
     * @param {Function} [options.onError] - Callback on error
     * @returns {HTMLElement|null} The created shimmer container
     */
    create: function (options) {
        const container = typeof options.container === 'string'
            ? document.querySelector(options.container)
            : options.container;

        if (!container) {
            console.warn('FikfikkShimmer: Container not found');
            return null;
        }

        const width = options.width
            ? `width: ${typeof options.width === 'number' ? options.width + 'px' : options.width};`
            : '';
        const height = options.height
            ? `height: ${typeof options.height === 'number' ? options.height + 'px' : options.height};`
            : '';
        const aspectRatio = !options.height && options.aspectRatio
            ? `aspect-ratio: ${options.aspectRatio};`
            : '';

        const html = `
            <div class="shimmer-container" data-shimmer-container style="${width}${height}${aspectRatio}">
                <div class="shimmer-placeholder" data-shimmer-placeholder>
                    <div class="shimmer-animation"></div>
                </div>
                <img src="${options.src}" 
                     alt="${options.alt || ''}" 
                     class="shimmer-image ${options.class || ''}" 
                     loading="${options.loading || 'lazy'}"
                     decoding="${options.decoding || 'async'}"
                     data-shimmer-image
                     style="opacity: 0;">
            </div>
        `;

        container.innerHTML = html;

        const imgElement = container.querySelector('[data-shimmer-image]');

        if (options.onLoad) {
            imgElement.addEventListener('load', () => options.onLoad(imgElement));
        }

        if (options.onError) {
            imgElement.addEventListener('error', () => options.onError(imgElement));
        }

        this.init();

        return container.firstElementChild;
    },

    /**
     * Refresh/re-initialize shimmer on dynamically added images
     */
    refresh: function () {
        this.init();
    },

    /**
     * Package version
     */
    version: '1.0.0'
};

// Export for different module systems
if (typeof window !== 'undefined') {
    window.FikfikkShimmer = FikfikkShimmer;
}

if (typeof module !== 'undefined' && module.exports) {
    module.exports = FikfikkShimmer;
}

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => FikfikkShimmer.init());
} else {
    FikfikkShimmer.init();
}
