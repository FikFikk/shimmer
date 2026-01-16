<?php

namespace Fikfikk\Shimmer\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ImageShimmer extends Component
{
    public string $src;
    public string $alt;
    public string $class;
    public ?string $width;
    public ?string $height;
    public ?string $aspectRatio;
    public string $loading;
    public string $decoding;

    /**
     * Create a new component instance.
     *
     * @param string $src Image source URL (required)
     * @param string $alt Image alt text
     * @param string $class Additional CSS classes
     * @param string|int|null $width Container width (optional - auto if not set)
     * @param string|int|null $height Container height (optional - auto if not set)
     * @param string|null $aspectRatio Aspect ratio when no width/height (optional)
     * @param string $loading Loading strategy: 'lazy' or 'eager'
     * @param string $decoding Decoding strategy: 'async' or 'sync'
     */
    public function __construct(
        string $src,
        string $alt = '',
        string $class = '',
        string|int|null $width = null,
        string|int|null $height = null,
        ?string $aspectRatio = null,
        string $loading = 'lazy',
        string $decoding = 'async'
    ) {
        $this->src = $src;
        $this->alt = $alt;
        $this->class = $class;
        $this->width = $width !== null ? (string) $width : null;
        $this->height = $height !== null ? (string) $height : null;
        $this->aspectRatio = $aspectRatio;
        $this->loading = $loading;
        $this->decoding = $decoding;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('shimmer::components.image-shimmer');
    }
}
