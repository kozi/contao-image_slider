<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2015 Leo Feyer
 *
 * @copyright Martin Kozianka 2015 <http://kozianka.de/>
 * @author    Martin Kozianka <http://kozianka.de/>
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * @package   image_slider
 */



$GLOBALS['TL_DCA']['tl_content']['fields']['multiSRC']['load_callback'][] = function($varValue, DataContainer $dc) {
    if ($dc->activeRecord && $dc->activeRecord->type == 'image_slider') {
        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
    }
    return $varValue;
};


$GLOBALS['TL_DCA']['tl_content']['palettes']['image_slider'] = str_replace(
  'headline;',
  'headline;{image_slider_legend},multiSRC,sortBy,size,image_slider_duration, image_slider_effect, image_slider_interval,
  image_slider_hidpi, image_slider_autoslide, image_slider_bullets, image_slider_captions;',
  $GLOBALS['TL_DCA']['tl_content']['palettes']['headline']);

$GLOBALS['TL_DCA']['tl_content']['fields']['image_slider_duration']  = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['image_slider_duration'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['rgxp'=>'digit', 'tl_class'=>'w50'],
    'sql'                     => "smallint(5) unsigned NOT NULL default '700'"
];
$GLOBALS['TL_DCA']['tl_content']['fields']['image_slider_interval']  = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['image_slider_interval'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['rgxp'=>'digit', 'tl_class'=>'w50'],
    'sql'                     => "smallint(5) unsigned NOT NULL default '4000'"
];
$GLOBALS['TL_DCA']['tl_content']['fields']['image_slider_effect']    = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['image_slider_effect'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => ImageSlider::effectOptions(),
    'eval'                    => ['mandatory'=>true, 'tl_class' => 'w50'],
    'sql'                     => "varchar(255) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_content']['fields']['image_slider_hidpi'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['image_slider_hidpi'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => ['tl_class'=>'w50  m12'],
    'sql'                     => "char(1) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_content']['fields']['image_slider_autoslide'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['image_slider_autoslide'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => ['tl_class'=>'w50'],
    'sql'                     => "char(1) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_content']['fields']['image_slider_bullets']   = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['image_slider_bullets'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => ['tl_class'=>'w50'],
    'sql'                     => "char(1) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_content']['fields']['image_slider_captions']  = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['image_slider_captions'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => ['tl_class'=>'w50'],
    'sql'                     => "char(1) NOT NULL default ''"
];
