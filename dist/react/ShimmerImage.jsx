/**
 * Fikfikk Shimmer - React Component
 * @version 1.1.0
 * @author FikFikk
 * @license MIT
 */

import React, { useState, useEffect, useRef } from 'react';

/**
 * ShimmerImage Component
 * 
 * @param {Object} props
 * @param {string} props.src - Image source URL (required)
 * @param {string} [props.alt=''] - Image alt text
 * @param {string} [props.className=''] - Additional CSS classes
 * @param {string|number} [props.width] - Container width
 * @param {string|number} [props.height] - Container height
 * @param {string} [props.aspectRatio] - Aspect ratio (e.g., '16/9')
 * @param {string} [props.loading='lazy'] - Loading strategy
 * @param {string} [props.decoding='async'] - Decoding strategy
 * @param {string} [props.objectFit='cover'] - Object fit style
 * @param {Function} [props.onLoad] - Callback when image loads
 * @param {Function} [props.onError] - Callback on error
 * @param {Object} [props.style] - Additional inline styles
 */
export function ShimmerImage({
    src,
    alt = '',
    className = '',
    width,
    height,
    aspectRatio,
    loading = 'lazy',
    decoding = 'async',
    objectFit = 'cover',
    onLoad,
    onError,
    style = {},
    ...props
}) {
    const [isLoaded, setIsLoaded] = useState(false);
    const [hasError, setHasError] = useState(false);
    const imgRef = useRef(null);

    useEffect(() => {
        const img = imgRef.current;
        if (img && img.complete && img.naturalHeight !== 0) {
            setIsLoaded(true);
        }
    }, [src]);

    const handleLoad = (e) => {
        setIsLoaded(true);
        onLoad?.(e);
    };

    const handleError = (e) => {
        setHasError(true);
        setIsLoaded(true); // Hide shimmer on error
        onError?.(e);
    };

    // Build container styles
    const containerStyle = {
        ...style,
        ...(width && { width: typeof width === 'number' ? `${width}px` : width }),
        ...(height && { height: typeof height === 'number' ? `${height}px` : height }),
        ...(!height && aspectRatio && { aspectRatio }),
    };

    return (
        <div 
            className={`shimmer-container ${className}`.trim()}
            style={containerStyle}
            data-shimmer
            {...props}
        >
            <div className={`shimmer-placeholder ${isLoaded ? 'loaded' : ''}`}>
                <div className="shimmer-animation" />
            </div>
            <img
                ref={imgRef}
                src={src}
                alt={alt}
                className={`shimmer-image ${isLoaded ? 'loaded' : ''}`}
                style={{ objectFit }}
                loading={loading}
                decoding={decoding}
                onLoad={handleLoad}
                onError={handleError}
                data-shimmer-image
            />
        </div>
    );
}

/**
 * Hook for shimmer state management
 */
export function useShimmer() {
    const [loaded, setLoaded] = useState(false);
    
    const onLoad = () => setLoaded(true);
    const reset = () => setLoaded(false);
    
    return { loaded, onLoad, reset };
}

export default ShimmerImage;
