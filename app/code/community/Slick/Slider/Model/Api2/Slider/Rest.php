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
 * Slider abstract REST API handler model
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
abstract class Slick_Slider_Model_Api2_Slider_Rest extends Slick_Slider_Model_Api2_Slider
{
    /**
     * current slider
     */
    protected $_slider;

    /**
     * retrieve entity
     *
     * @access protected
     * @return array|mixed
     * @author Ali Kazim
     */
    protected function _retrieve() {
        $slider = $this->_getSlider();
        $this->_prepareSliderForResponse($slider);
        return $slider->getData();
    }

    /**
     * get collection
     *
     * @access protected
     * @return array
     * @author Ali Kazim
     */
    protected function _retrieveCollection() {
        $collection = Mage::getResourceModel('slick_slider/slider_collection');
        $entityOnlyAttributes = $this->getEntityOnlyAttributes(
            $this->getUserType(),
            Mage_Api2_Model_Resource::OPERATION_ATTRIBUTE_READ
        );
        $availableAttributes = array_keys($this->getAvailableAttributes(
            $this->getUserType(),
            Mage_Api2_Model_Resource::OPERATION_ATTRIBUTE_READ)
        );
        $collection->addFieldToFilter('status', array('eq' => 1));
        $this->_applyCollectionModifiers($collection);
        $sliders = $collection->load();
        $sliders->walk('afterLoad');
        foreach ($sliders as $slider) {
            $this->_setSlider($slider);
            $this->_prepareSliderForResponse($slider);
        }
        $slidersArray = $sliders->toArray();
        $slidersArray = $slidersArray['items'];

        return $slidersArray;
    }

    /**
     * prepare slider for response
     *
     * @access protected
     * @param Slick_Slider_Model_Slider $slider
     * @author Ali Kazim
     */
    protected function _prepareSliderForResponse(Slick_Slider_Model_Slider $slider) {
        $sliderData = $slider->getData();
    }

    /**
     * create slider
     *
     * @access protected
     * @param array $data
     * @return string|void
     * @author Ali Kazim
     */
    protected function _create(array $data) {
        $this->_critical(self::RESOURCE_METHOD_NOT_ALLOWED);
    }

    /**
     * update slider
     *
     * @access protected
     * @param array $data
     * @author Ali Kazim
     */
    protected function _update(array $data) {
        $this->_critical(self::RESOURCE_METHOD_NOT_ALLOWED);
    }

    /**
     * delete slider
     *
     * @access protected
     * @author Ali Kazim
     */
    protected function _delete() {
        $this->_critical(self::RESOURCE_METHOD_NOT_ALLOWED);
    }

    /**
     * delete current slider
     *
     * @access protected
     * @param Slick_Slider_Model_Slider $slider
     * @author Ali Kazim
     */
    protected function _setSlider(Slick_Slider_Model_Slider $slider) {
        $this->_slider = $slider;
    }

    /**
     * get current slider
     *
     * @access protected
     * @return Slick_Slider_Model_Slider
     * @author Ali Kazim
     */
    protected function _getSlider() {
        if (is_null($this->_slider)) {
            $sliderId = $this->getRequest()->getParam('id');
            $slider = Mage::getModel('slick_slider/slider');
            $slider->load($sliderId);
            if (!($slider->getId())) {
                $this->_critical(self::RESOURCE_NOT_FOUND);
            }
            $this->_slider = $slider;
        }
        return $this->_slider;
    }
}
