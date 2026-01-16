/**
 * Fikfikk Shimmer - Universal Image Shimmer Loading Effect
 * @version 1.1.0
 * @author FikFikk
 * @license MIT
 * 
 * Works with: Laravel Blade, Vue, React, Alpine.js, vanilla HTML/JS
 */

(function(root, factory) {
    // UMD pattern for universal module compatibility
    if (typeof define === 'function' && define.amd) {
        define([], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        root.FikfikkShimmer = factory();
    }
}(typeof self !== 'undefined' ? self : this, function() {
    'use strict';

    var FikfikkShimmer = {
        version: '1.1.0',
        
        /**
         * Default configuration
         */
        defaults: {
            aspectRatio: null,
            loading: 'lazy',
            decoding: 'async',
            objectFit: 'cover'
        },

        /**
         * Initialize shimmer effect on all images
         * @param {string|Element} [selector] - Optional selector or container
         */
        init: function(selector) {
            var container = selector 
                ? (typeof selector === 'string' ? document.querySelector(selector) : selector)
                : document;
            
            if (!container) return;

            var images = container.querySelectorAll('[data-shimmer-image]:not(.shimmer-initialized)');
            
            images.forEach(function(img) {
                img.classList.add('shimmer-initialized');
                
                var shimmerContainer = img.closest('[data-shimmer], .shimmer-container');
                var placeholder = shimmerContainer 
                    ? shimmerContainer.querySelector('.shimmer-placeholder') 
                    : null;

                function onImageLoad() {
                    img.classList.add('loaded');
                    if (placeholder) {
                        placeholder.classList.add('loaded');
                    }
                }

                function onImageError() {
                    // Hide shimmer on error
                    if (placeholder) {
                        placeholder.classList.add('loaded');
                    }
                }

                // Check if already loaded (cached)
                if (img.complete && img.naturalHeight !== 0) {
                    onImageLoad();
                } else {
                    img.addEventListener('load', onImageLoad);
                    img.addEventListener('error', onImageError);
                }
            });
        },

        /**
         * Create shimmer element programmatically
         * @param {Object} options - Configuration options
         * @returns {HTMLElement|null}
         */
        create: function(options) {
            if (!options || !options.src) {
                console.warn('FikfikkShimmer: src is required');
                return null;
            }

            var container = options.container
                ? (typeof options.container === 'string' 
                    ? document.querySelector(options.container) 
                    : options.container)
                : null;

            // Build styles
            var styles = [];
            if (options.width) {
                styles.push('width:' + (typeof options.width === 'number' ? options.width + 'px' : options.width));
            }
            if (options.height) {
                styles.push('height:' + (typeof options.height === 'number' ? options.height + 'px' : options.height));
            }
            if (!options.height && options.aspectRatio) {
                styles.push('aspect-ratio:' + options.aspectRatio);
            }

            var className = 'shimmer-container' + (options.class ? ' ' + options.class : '');
            var styleAttr = styles.length ? ' style="' + styles.join(';') + '"' : '';

            var html = 
                '<div class="' + className + '" data-shimmer' + styleAttr + '>' +
                    '<div class="shimmer-placeholder">' +
                        '<div class="shimmer-animation"></div>' +
                    '</div>' +
                    '<img ' +
                        'src="' + options.src + '" ' +
                        'alt="' + (options.alt || '') + '" ' +
                        'class="shimmer-image" ' +
                        'loading="' + (options.loading || this.defaults.loading) + '" ' +
                        'decoding="' + (options.decoding || this.defaults.decoding) + '" ' +
                        'data-shimmer-image' +
                    '>' +
                '</div>';

            if (container) {
                container.innerHTML = html;
                this.init(container);
                
                var element = container.querySelector('[data-shimmer]');
                
                // Callbacks
                var img = element.querySelector('[data-shimmer-image]');
                if (options.onLoad) {
                    img.addEventListener('load', function() { options.onLoad(img); });
                }
                if (options.onError) {
                    img.addEventListener('error', function() { options.onError(img); });
                }
                
                return element;
            }

            // Return HTML string if no container
            return html;
        },

        /**
         * Refresh/reinitialize (alias for init)
         * @param {string|Element} [selector]
         */
        refresh: function(selector) {
            // Remove initialized class to allow re-init
            var container = selector 
                ? (typeof selector === 'string' ? document.querySelector(selector) : selector)
                : document;
            
            if (container) {
                container.querySelectorAll('.shimmer-initialized').forEach(function(el) {
                    el.classList.remove('shimmer-initialized');
                });
            }
            
            this.init(selector);
        },

        /**
         * Destroy shimmer from elements
         * @param {string|Element} [selector]
         */
        destroy: function(selector) {
            var container = selector 
                ? (typeof selector === 'string' ? document.querySelector(selector) : selector)
                : document;
            
            if (!container) return;

            container.querySelectorAll('[data-shimmer]').forEach(function(el) {
                var img = el.querySelector('img');
                if (img) {
                    // Replace shimmer container with just the image
                    img.classList.remove('shimmer-image', 'shimmer-initialized', 'loaded');
                    img.removeAttribute('data-shimmer-image');
                    img.style.opacity = '';
                    el.parentNode.replaceChild(img, el);
                }
            });
        }
    };

    // Auto-initialize on DOM ready
    if (typeof document !== 'undefined') {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                FikfikkShimmer.init();
            });
        } else {
            FikfikkShimmer.init();
        }
    }

    return FikfikkShimmer;
}));
