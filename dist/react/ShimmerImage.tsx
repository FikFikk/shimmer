/**
 * Fikfikk Shimmer - React Component (TypeScript)
 * @version 1.1.0
 * @author FikFikk
 * @license MIT
 */

import React, { useState, useEffect, useRef, CSSProperties, ImgHTMLAttributes } from 'react';

export interface ShimmerImageProps extends Omit<ImgHTMLAttributes<HTMLImageElement>, 'width' | 'height' | 'onLoad' | 'onError'> {
    /** Image source URL (required) */
    src: string;
    /** Image alt text */
    alt?: string;
    /** Additional CSS classes */
    className?: string;
    /** Container width */
    width?: string | number;
    /** Container height */
    height?: string | number;
    /** Aspect ratio (e.g., '16/9', '4/3', '1/1') */
    aspectRatio?: string;
    /** Loading strategy */
    loading?: 'lazy' | 'eager';
    /** Decoding strategy */
    decoding?: 'async' | 'sync' | 'auto';
    /** Object fit style */
    objectFit?: CSSProperties['objectFit'];
    /** Callback when image loads */
    onLoad?: (event: React.SyntheticEvent<HTMLImageElement>) => void;
    /** Callback on error */
    onError?: (event: React.SyntheticEvent<HTMLImageElement>) => void;
    /** Additional inline styles for container */
    style?: CSSProperties;
}

export const ShimmerImage: React.FC<ShimmerImageProps> = ({
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
}) => {
    const [isLoaded, setIsLoaded] = useState(false);
    const [hasError, setHasError] = useState(false);
    const imgRef = useRef<HTMLImageElement>(null);

    useEffect(() => {
        const img = imgRef.current;
        if (img && img.complete && img.naturalHeight !== 0) {
            setIsLoaded(true);
        }
    }, [src]);

    // Reset state when src changes
    useEffect(() => {
        setIsLoaded(false);
        setHasError(false);
    }, [src]);

    const handleLoad = (e: React.SyntheticEvent<HTMLImageElement>) => {
        setIsLoaded(true);
        onLoad?.(e);
    };

    const handleError = (e: React.SyntheticEvent<HTMLImageElement>) => {
        setHasError(true);
        setIsLoaded(true);
        onError?.(e);
    };

    const containerStyle: CSSProperties = {
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
                {...props}
            />
        </div>
    );
};

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
