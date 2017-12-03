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
 * Slider model
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Model_Slider extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'slick_slider_slider';
    const CACHE_TAG = 'slick_slider_slider';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'slick_slider_slider';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'slider';

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
        $this->_init('slick_slider/slider');
    }

    /**
     * before save slider
     *
     * @access protected
     * @return Slick_Slider_Model_Slider
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
     * save slider relation
     *
     * @access public
     * @return Slick_Slider_Model_Slider
     * @author Ali Kazim
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * Retrieve  collection
     *
     * @access public
     * @return Slick_Slider_Model_Slide_Collection
     * @author Ali Kazim
     */
    public function getSelectedSlidesCollection()
    {
        if (!$this->hasData('_slide_collection')) {
            if (!$this->getId()) {
                return new Varien_Data_Collection();
            } else {
                $collection = Mage::getResourceModel('slick_slider/slide_collection')
                        ->addFieldToFilter('slider_id', $this->getId());
                $this->setData('_slide_collection', $collection);
            }
        }
        return $this->getData('_slide_collection');
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
        $values['slides_to_show'] = '1';
        $values['slides_to_scroll'] = '1';
        $values['speed'] = '500';

        return $values;
    }
    
}
