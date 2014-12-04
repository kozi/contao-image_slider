<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * @copyright Martin Kozianka 2011-2014 <http://kozianka.de/>
 * @author    Martin Kozianka <http://kozianka.de/>
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * @package   image-pack
 */

$GLOBALS['TL_DCA']['tl_content']['fields']['multiSRC']['load_callback'][] = function($varValue, DataContainer $dc) {
    if ($dc->activeRecord && $dc->activeRecord->type == 'imagepack_slider') {
        $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
    }
    return $varValue;
};


$GLOBALS['TL_DCA']['tl_content']['palettes']['imagepack_slider'] = str_replace(
  'headline;',
  'headline;{imagepack_legend_slider},multiSRC,sortBy,size,imagepack_duration, imagepack_effect, imagepack_interval, imagepack_autoslide, imagepack_bullets, imagepack_captions;',
  $GLOBALS['TL_DCA']['tl_content']['palettes']['headline']);

$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_duration']  = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_duration'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50'),
    'sql'                     => "smallint(5) unsigned NOT NULL default '700'"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_interval']  = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_interval'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50'),
    'sql'                     => "smallint(5) unsigned NOT NULL default '4000'"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_effect']    = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_effect'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => &$GLOBALS['TL_LANG']['tl_content']['imagepack_effect']['options'],
    'eval'                    => array('mandatory'=>true, 'tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_autoslide'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_autoslide'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_bullets']   = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_bullets'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_captions']  = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_captions'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);