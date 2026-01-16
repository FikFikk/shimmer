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
    public string $aspectRatio;
    public string $loading;
    public string $decoding;

    public function __construct(
        string $src,
        string $alt = '',
        string $class = '',
        ?string $width = null,
        ?string $height = null,
        ?string $aspectRatio = null,
        string $loading = 'lazy',
        string $decoding = 'async'
    ) {
        $this->src = $src;
        $this->alt = $alt;
        $this->class = $class;
        $this->width = $width;
        $this->height = $height;
        $this->aspectRatio = $aspectRatio ?? config('shimmer.default_aspect_ratio', '16/9');
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

    /**
     * Get data for the view.
     */
    public function data(): array
    {
        return [
            'src' => $this->src,
            'alt' => $this->alt,
            'class' => $this->class,
            'width' => $this->width,
            'height' => $this->height,
            'aspectRatio' => $this->aspectRatio,
            'loading' => $this->loading,
            'decoding' => $this->decoding,
        ];
    }
}
