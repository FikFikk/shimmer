<?php

namespace Fikfikk\Shimmer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string image(string $src, string $alt = '', string $class = '', $width = null, $height = null, $aspectRatio = null)
 * 
 * @see \Fikfikk\Shimmer\View\Components\ImageShimmer
 */
class Shimmer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shimmer';
    }
}
