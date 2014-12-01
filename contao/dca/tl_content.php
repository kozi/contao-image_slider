<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * PHP version 5
 * @copyright Martin Kozianka 2011-2014 <http://kozianka.de/>
 * @author    Martin Kozianka <http://kozianka.de/>
 * @package   image-pack
 * @license   LGPL
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['imagepack_slider'] = str_replace(
  'headline;',
  'headline;{legend_slider},size,imagepack_duration, imagepack_effect, imagepack_interval, imagepack_autoslide, imagepack_bullets, imagepack_captions;',
  $GLOBALS['TL_DCA']['tl_content']['palettes']['headline']);


$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_duration']  = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_duration'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('mandatory'=>true, 'tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_interval']  = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_duration'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('mandatory'=>true, 'tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_effect']    = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_duration'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('mandatory'=>true, 'tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_autoslide'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_duration'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>true, 'tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_bullets']   = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_duration'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>true, 'tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['imagepack_captions']  = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagepack_duration'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);