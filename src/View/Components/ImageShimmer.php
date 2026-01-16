<?php

namespace Fikfikk\Shimmer\View\Components;

use Illuminate\View\Component;

class ImageShimmer extends Component
{
    public $src;
    public $alt;
    public $class;
    public $width;
    public $height;
    public $aspectRatio;
    public $loading;
    public $decoding;

    public function __construct(
        $src,
        $alt = '',
        $class = '',
        $width = null,
        $height = null,
        $aspectRatio = null,
        $loading = 'lazy',
        $decoding = 'async'
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

    public function render()
    {
        return view('shimmer::components.image-shimmer', [
            'src' => $this->src,
            'alt' => $this->alt,
            'class' => $this->class,
            'width' => $this->width,
            'height' => $this->height,
            'aspectRatio' => $this->aspectRatio,
            'loading' => $this->loading,
            'decoding' => $this->decoding,
        ]);
    }
}
