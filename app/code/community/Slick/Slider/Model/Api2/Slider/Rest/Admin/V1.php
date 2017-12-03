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
 * Slider REST API admin handler
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Model_Api2_Slider_Rest_Admin_V1 extends Slick_Slider_Model_Api2_Slider_Rest
{

    /**
     * Remove specified keys from associative or indexed array
     *
     * @access protected
     * @param array $array
     * @param array $keys
     * @param bool $dropOrigKeys if true - return array as indexed array
     * @return array
     * @author Ali Kazim
     */
    protected function _filterOutArrayKeys(array $array, array $keys, $dropOrigKeys = false) {
        $isIndexedArray = is_array(reset($array));
        if ($isIndexedArray) {
            foreach ($array as &$value) {
                if (is_array($value)) {
                    $value = array_diff_key($value, array_flip($keys));
                }
            }
            if ($dropOrigKeys) {
                $array = array_values($array);
            }
            unset($value);
        } else {
            $array = array_diff_key($array, array_flip($keys));
        }
        return $array;
    }

    /**
     * Retrieve list of sliders
     *
     * @access protected
     * @return array
     * @author Ali Kazim
     */
    protected function _retrieveCollection() {
        $collection = Mage::getResourceModel('slick_slider/slider_collection');
        $entityOnlyAttributes = $this->getEntityOnlyAttributes($this->getUserType(),
            Mage_Api2_Model_Resource::OPERATION_ATTRIBUTE_READ);
        $availableAttributes = array_keys($this->getAvailableAttributes($this->getUserType(),
            Mage_Api2_Model_Resource::OPERATION_ATTRIBUTE_READ));
        $this->_applyCollectionModifiers($collection);
        $sliders = $collection->load();

        foreach ($sliders as $slider) {
            $this->_setSlider($slider);
            $this->_prepareSliderForResponse($slider);
        }
        $slidersArray = $sliders->toArray();
        $slidersArray = $slidersArray['items'];

        return $slidersArray;
    }

    /**
     * Delete slider by its ID
     *
     * @access protected
     * @throws Mage_Api2_Exception
     * @author Ali Kazim
     */
    protected function _delete() {
        $slider = $this->_getSlider();
        try {
            $slider->delete();
        } catch (Mage_Core_Exception $e) {
            $this->_critical($e->getMessage(), Mage_Api2_Model_Server::HTTP_INTERNAL_ERROR);
        } catch (Exception $e) {
            $this->_critical(self::RESOURCE_INTERNAL_ERROR);
        }
    }

    /**
     * Create slider
     *
     * @access protected
     * @param array $data
     * @return string
     * @author Ali Kazim
     */
    protected function _create(array $data) {
        $slider = Mage::getModel('slick_slider/slider')->setData($data);
        try {
            $slider->save();
        }
        catch (Mage_Core_Exception $e) {
            $this->_critical($e->getMessage(), Mage_Api2_Model_Server::HTTP_INTERNAL_ERROR);
        } catch (Exception $e) {
            $this->_critical(self::RESOURCE_UNKNOWN_ERROR);
        }
        return $this->_getLocation($slider->getId());
    }

    /**
     * Update slider by its ID
     *
     * @access protected
     * @param array $data
     * @author Ali Kazim
     */
    protected function _update(array $data) {
        $slider = $this->_getSlider();
        $slider->addData($data);
        try {
            $slider->save();
        } catch (Mage_Core_Exception $e) {
            $this->_critical($e->getMessage(), Mage_Api2_Model_Server::HTTP_INTERNAL_ERROR);
        } catch (Exception $e) {
            $this->_critical(self::RESOURCE_UNKNOWN_ERROR);
        }
    }

    /**
     * Set additional data before slider save
     *
     * @access protected
     * @param Slick_Slider_Model_Slider $entity
     * @param array $sliderData
     * @author Ali Kazim
     */
    protected function _prepareDataForSave($product, $productData) {
        //add your data processing algorithm here if needed
    }
}