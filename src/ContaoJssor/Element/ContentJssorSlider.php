<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    jssor-slider
 * @license    LGPL
 * @filesource
 */

namespace ContaoJssor\Element;

/**
 * Class ContentJssorSlider
 *
 * Front end content element "ContentJssorSlider".
 * @copyright  Martin Kozianka 2014
 * @author     Martin Kozianka <martin@kozianka.de>
 * @package    jssor-slider
 */

class ContentJssorSlider extends \ContentGallery {

    protected $strTemplate = 'ce_jssor_slider_default';


    protected function compile() {
        $sliderConf             = new \stdClass();
        $sliderConf->duration   = intval($this->jssor_duration);
        $sliderConf->interval   = intval($this->jssor_interval);
        $sliderConf->effect     = $this->jssor_effect;
        $sliderConf->autoslide  = ($this->jssor_autoslide === '1');
        $sliderConf->bullets    = ($this->jssor_bullets === '1');
        $sliderConf->captions   = ($this->jssor_captions === '1');


        var_dump($sliderConf);
        die();

        $path = 'system/modules/jssor-slider/assets/bower_components/ideal-image-slider/';
        $GLOBALS['TL_JAVASCRIPT'][] = $path.'ideal-image-slider.min.js|static';
        $GLOBALS['TL_CSS'][]        = $path.'ideal-image-slider.css||static';
        $GLOBALS['TL_CSS'][]        = $path.'themes/default/default.css||static';
        if ($sliderConf->bullets) {
            $GLOBALS['TL_JAVASCRIPT'][] = $path.'extensions/bullet-nav/iis-bullet-nav.js|static';
        }
        if ($sliderConf->captions) {
            $GLOBALS['TL_JAVASCRIPT'][] = $path.'extensions/captions/iis-captions.js|static';
        }

        $arrSize          = deserialize($this->size);
        $sizeConf         = new \stdClass();
        $sizeConf->width  = intval($arrSize[0]);
        $sizeConf->height = intval($arrSize[1]);
        $sizeConf->type   = $arrSize[2];


        $this->Template->sliderConf  = $sliderConf;
        $this->Template->size        = $sizeConf;
        $this->Template->images      = $this->getAllImages();


    }

    private function getAllImages() {
        global $objPage;
        $images   = array();
        $auxDate  = array();
        $objFiles = $this->objFiles;

        // Get all images
        while ($objFiles->next())
        {
            // Continue if the files has been processed or does not exist
            if (isset($images[$objFiles->path]) || !file_exists(TL_ROOT . '/' . $objFiles->path))
            {
                continue;
            }

            // Single files
            if ($objFiles->type == 'file')
            {
                $objFile = new \File($objFiles->path, true);

                if (!$objFile->isGdImage)
                {
                    continue;
                }

                $arrMeta = $this->getMetaData($objFiles->meta, $objPage->language);

                // Use the file name as title if none is given
                if ($arrMeta['title'] == '')
                {
                    $arrMeta['title'] = specialchars($objFile->basename);
                }

                // Add the image
                $images[$objFiles->path] = array
                (
                    'id'        => $objFiles->id,
                    'uuid'      => $objFiles->uuid,
                    'name'      => $objFile->basename,
                    'singleSRC' => $objFiles->path,
                    'alt'       => $arrMeta['title'],
                    'imageUrl'  => $arrMeta['link'],
                    'caption'   => $arrMeta['caption']
                );

                $auxDate[] = $objFile->mtime;
            }

            // Folders
            else
            {
                $objSubfiles = \FilesModel::findByPid($objFiles->uuid);

                if ($objSubfiles === null)
                {
                    continue;
                }

                while ($objSubfiles->next())
                {
                    // Skip subfolders
                    if ($objSubfiles->type == 'folder')
                    {
                        continue;
                    }

                    $objFile = new \File($objSubfiles->path, true);

                    if (!$objFile->isGdImage)
                    {
                        continue;
                    }

                    $arrMeta = $this->getMetaData($objSubfiles->meta, $objPage->language);

                    // Use the file name as title if none is given
                    if ($arrMeta['title'] == '')
                    {
                        $arrMeta['title'] = specialchars($objFile->basename);
                    }

                    // Add the image
                    $images[$objSubfiles->path] = array
                    (
                        'id'        => $objSubfiles->id,
                        'uuid'      => $objSubfiles->uuid,
                        'name'      => $objFile->basename,
                        'singleSRC' => $objSubfiles->path,
                        'alt'       => $arrMeta['title'],
                        'imageUrl'  => $arrMeta['link'],
                        'caption'   => $arrMeta['caption']
                    );

                    $auxDate[] = $objFile->mtime;
                }
            }
        }

        // Sort array
        switch ($this->sortBy)
        {
            default:
            case 'name_asc':
                uksort($images, 'basename_natcasecmp');
                break;

            case 'name_desc':
                uksort($images, 'basename_natcasercmp');
                break;

            case 'date_asc':
                array_multisort($images, SORT_NUMERIC, $auxDate, SORT_ASC);
                break;

            case 'date_desc':
                array_multisort($images, SORT_NUMERIC, $auxDate, SORT_DESC);
                break;

            case 'meta': // Backwards compatibility
            case 'custom':
                if ($this->orderSRC != '')
                {
                    $tmp = deserialize($this->orderSRC);

                    if (!empty($tmp) && is_array($tmp))
                    {
                        // Remove all values
                        $arrOrder = array_map(function(){}, array_flip($tmp));

                        // Move the matching elements to their position in $arrOrder
                        foreach ($images as $k=>$v)
                        {
                            if (array_key_exists($v['uuid'], $arrOrder))
                            {
                                $arrOrder[$v['uuid']] = $v;
                                unset($images[$k]);
                            }
                        }

                        // Append the left-over images at the end
                        if (!empty($images))
                        {
                            $arrOrder = array_merge($arrOrder, array_values($images));
                        }

                        // Remove empty (unreplaced) entries
                        $images = array_values(array_filter($arrOrder));
                        unset($arrOrder);
                    }
                }
                break;

            case 'random':
                shuffle($images);
                break;
        }
        return array_values($images);
    }
}
