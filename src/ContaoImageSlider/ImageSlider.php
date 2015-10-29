<?php namespace ContaoImageSlider;


/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2015 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2015 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    image_slider
 * @license    LGPL
 * @filesource
 */

/**
 * Class ImageSlider
 *
 * Helper class
 * @copyright  Martin Kozianka 2015
 * @author     Martin Kozianka <martin@kozianka.de>
 * @package    image_slider
 */

class ImageSlider
{
    public static function effectOptions()
    {
        $arrLang    = &$GLOBALS['TL_LANG']['tl_content']['image_slider_effect']['options'];
        $arrOptions = [
            'fade'    => ($arrLang['fade']) ? $arrLang['fade'] : 'Fade-effect',
            'slide'   => ($arrLang['slide']) ? $arrLang['slide'] : 'Slide-effect',
        ];
        return $arrOptions;
    }
    
}