<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @copyright Martin Kozianka 2011-2014 <http://kozianka.de/>
 * @author    Martin Kozianka <http://kozianka.de/>
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * @package   image-pack
 */


array_insert($GLOBALS['TL_DCA']['tl_theme']['list']['operations'], 6, array(
    'imagepack' =>  array(
        'label'               => &$GLOBALS['TL_LANG']['tl_theme']['edit'],
        'href'                => 'table=tl_imagepack',
        'icon'                => 'system/modules/image-pack/assets/images-stack.png'
    )
));


