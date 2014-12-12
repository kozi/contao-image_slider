<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    image-slider
 * @license    LGPL
 * @filesource
 */

namespace ContaoImageSlider\Element;

/**
 * Class ContentImageSlider
 *
 * Front end content element "ContentImageSlider".
 * @copyright  Martin Kozianka 2014
 * @author     Martin Kozianka <martin@kozianka.de>
 * @package    image-slider
 */

class ContentImageSlider extends \ContentGallery {
    private static $imgFullTag = "<img data-src=\"%s\" alt=\"%s\" title=\"%s\" %s>\n";
    protected $strTemplate = 'ce_image_slider_default';

    protected function compile() {
        global $objPage;

        if (TL_MODE === 'BE') {
            $this->Template = new \BackendTemplate('be_image_slider');
        }

        $arrSize               = deserialize($this->size);
        $sliderConf            = new \stdClass();
        $sliderConf->id        = 'slider'.$this->id;
        $sliderConf->selector  = '#'.$sliderConf->id;
        $sliderConf->effect    = $this->image_slider_effect;

        $sliderConf->width     = intval($arrSize[0]);
        $sliderConf->height    = intval($arrSize[1]);
        $sliderConf->sizeCss   = 'width:'.$sliderConf->width.'px;height:'.$sliderConf->height.'px;';

        $sliderConf->interval           = intval($this->image_slider_interval);
        $sliderConf->transitionDuration = intval($this->image_slider_duration);


        $sliderConf->autoslide = ($this->image_slider_autoslide === '1');
        $sliderConf->bullets   = ($this->image_slider_bullets === '1');
        $sliderConf->captions  = ($this->image_slider_captions === '1');
        $sliderConf->hidpi     = ($this->image_slider_hidpi === '1');

        $path = 'system/modules/image-slider/assets/bower_components/ideal-image-slider/';
        $GLOBALS['TL_JAVASCRIPT'][] = $path.'ideal-image-slider.min.js|static';
        $GLOBALS['TL_CSS'][]        = $path.'ideal-image-slider.css||static';
        $GLOBALS['TL_CSS'][]        = $path.'themes/default/default.css||static';

        if ($sliderConf->bullets) {
            $GLOBALS['TL_JAVASCRIPT'][] = $path.'extensions/bullet-nav/iis-bullet-nav.js|static';
        }
        if ($sliderConf->captions) {
            $GLOBALS['TL_JAVASCRIPT'][] = $path.'extensions/captions/iis-captions.js|static';
        }

        $sliderJsConf = new \stdClass();
        foreach(['selector', 'interval', 'transitionDuration', 'effect', 'height'] as $property) {
            $sliderJsConf->$property = $sliderConf->$property;
        }

        $arrImages = $this->getAllImages();
        $firstImg  = true;
        $objTemp   = new \stdClass();

        foreach ($arrImages as &$arrImage) {

            $arrImage['size'] = $this->size;
            $this->addImageToTemplate($objTemp, $arrImage);

            $arrImage['src']   = $objTemp->src;
            $strAttribs        = ($firstImg) ? ' src="'.$arrImage['src'].'"' : '';
            $firstImg          = false;

            if ($this->sliderConf->hidpi) {
                $arrImage['src2x'] = '';

                $strAttribs .= ' data...';
            }

            $arrImage['fullTag'] = sprintf(static::$imgFullTag,
                // <img data-src="%s" title="%s" alt="%s" %s>
                $arrImage['src'],
                $arrImage['caption'],
                $arrImage['alt'],
                $strAttribs
            );
        }
        $this->Template->sliderConf   = $sliderConf;
        $this->Template->sliderJsConf = json_encode($sliderJsConf);
        $this->Template->images       = $arrImages;

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
