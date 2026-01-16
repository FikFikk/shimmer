/**
 * Fikfikk Shimmer - Vue 3 Component
 * @version 1.1.0
 * @author FikFikk
 * @license MIT
 */

<template>
    <div 
        class="shimmer-container" 
        :class="className"
        :style="containerStyle"
        data-shimmer
    >
        <div class="shimmer-placeholder" :class="{ loaded: isLoaded }">
            <div class="shimmer-animation"></div>
        </div>
        <img
            ref="imgRef"
            :src="src"
            :alt="alt"
            class="shimmer-image"
            :class="{ loaded: isLoaded }"
            :style="{ objectFit }"
            :loading="loading"
            :decoding="decoding"
            data-shimmer-image
            @load="handleLoad"
            @error="handleError"
        />
    </div>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue';

export default {
    name: 'ShimmerImage',
    props: {
        /** Image source URL (required) */
        src: {
            type: String,
            required: true
        },
        /** Image alt text */
        alt: {
            type: String,
            default: ''
        },
        /** Additional CSS classes */
        className: {
            type: String,
            default: ''
        },
        /** Container width */
        width: {
            type: [String, Number],
            default: null
        },
        /** Container height */
        height: {
            type: [String, Number],
            default: null
        },
        /** Aspect ratio (e.g., '16/9') */
        aspectRatio: {
            type: String,
            default: null
        },
        /** Loading strategy */
        loading: {
            type: String,
            default: 'lazy',
            validator: (v) => ['lazy', 'eager'].includes(v)
        },
        /** Decoding strategy */
        decoding: {
            type: String,
            default: 'async',
            validator: (v) => ['async', 'sync', 'auto'].includes(v)
        },
        /** Object fit style */
        objectFit: {
            type: String,
            default: 'cover'
        }
    },
    emits: ['load', 'error'],
    setup(props, { emit }) {
        const imgRef = ref(null);
        const isLoaded = ref(false);
        const hasError = ref(false);

        const containerStyle = computed(() => {
            const style = {};
            
            if (props.width) {
                style.width = typeof props.width === 'number' 
                    ? `${props.width}px` 
                    : props.width;
            }
            
            if (props.height) {
                style.height = typeof props.height === 'number' 
                    ? `${props.height}px` 
                    : props.height;
            }
            
            if (!props.height && props.aspectRatio) {
                style.aspectRatio = props.aspectRatio;
            }
            
            return style;
        });

        const handleLoad = (e) => {
            isLoaded.value = true;
            emit('load', e);
        };

        const handleError = (e) => {
            hasError.value = true;
            isLoaded.value = true;
            emit('error', e);
        };

        // Check if image is already loaded
        onMounted(() => {
            const img = imgRef.value;
            if (img && img.complete && img.naturalHeight !== 0) {
                isLoaded.value = true;
            }
        });

        // Reset on src change
        watch(() => props.src, () => {
            isLoaded.value = false;
            hasError.value = false;
        });

        return {
            imgRef,
            isLoaded,
            hasError,
            containerStyle,
            handleLoad,
            handleError
        };
    }
};
</script>
