<?php
/**
 * Slick_Slider extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Slick
 * @package        Slick_Slider
 * @copyright      Copyright (c) 2017
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Slide model
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Model_Slide extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY        = 'slick_slider_slide';
    const CACHE_TAG     = 'slick_slider_slide';
    const MEDIA_FOLDER  = 'slide';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'slick_slider_slide';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'slide';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('slick_slider/slide');
    }

    /**
     * before save slide
     *
     * @access protected
     * @return Slick_Slider_Model_Slide
     * @author Ali Kazim
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * get the slide Content
     *
     * @access public
     * @return string
     * @author Ali Kazim
     */
    public function getContent()
    {
        $content = $this->getData('content');
        $helper = Mage::helper('cms');
        $processor = $helper->getBlockTemplateProcessor();
        $html = $processor->filter($content);
        return $html;
    }

    /**
     * save slide relation
     *
     * @access public
     * @return Slick_Slider_Model_Slide
     * @author Ali Kazim
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * Retrieve parent 
     *
     * @access public
     * @return null|Slick_Slider_Model_Slider
     * @author Ali Kazim
     */
    public function getParentSlider()
    {
        if (!$this->hasData('_parent_slider')) {
            if (!$this->getSliderId()) {
                return null;
            } else {
                $slider = Mage::getModel('slick_slider/slider')
                    ->load($this->getSliderId());
                if ($slider->getId()) {
                    $this->setData('_parent_slider', $slider);
                } else {
                    $this->setData('_parent_slider', null);
                }
            }
        }
        return $this->getData('_parent_slider');
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Ali Kazim
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }

    /**
     * if this slide contains a video
     * 
     * @access     public
     * @return     boolean
     * @author     Ali Kazim
     */
    public function hasVideo()
    {
        return !empty($this->getVideo());
    }

    /**
     * Gets the video url.
     * 
     * @access public
     * @return string url of video
     */
    public function getVideoUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . self::MEDIA_FOLDER . '/file' . $this->getVideo();
    }

    /**
     * Gets the video poster url.
     * 
     * @access public
     * @return string url of poster
     */
    public function getPosterUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . self::MEDIA_FOLDER . '/image' . $this->getPoster();
    }
    
    /**
     * Gets the image url.
     * 
     * @access public
     * @return string url of image
     */
    public function getImageUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . self::MEDIA_FOLDER . '/image' . $this->getImage();
    }
    
}
