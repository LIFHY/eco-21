<?php

namespace App\Helpers;

use App\Models\SiteContent;

class ContentHelper
{
    /**
     * Get content value by key
     */
    public static function get($key, $default = '')
    {
        return SiteContent::getValue($key, $default);
    }

    /**
     * Get content image path by key
     */
    public static function getImage($key, $default = '')
    {
        $item = SiteContent::where('key', $key)->first();
        return $item && $item->image_path ? asset($item->image_path) : $default;
    }

    /**
     * Get all content items by section
     */
    public static function getSection($section)
    {
        return SiteContent::getBySection($section);
    }
}
