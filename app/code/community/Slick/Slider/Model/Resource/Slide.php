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
 * Slide resource model
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Model_Resource_Slide extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Ali Kazim
     */
    public function _construct()
    {
        $this->_init('slick_slider/slide', 'entity_id');
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @access public
     * @param int $slideId
     * @return array
     * @author Ali Kazim
     */
    public function lookupStoreIds($slideId)
    {
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('slick_slider/slide_store'), 'store_id')
            ->where('slide_id = ?', (int)$slideId);
        return $adapter->fetchCol($select);
    }

    /**
     * Perform operations after object load
     *
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return Slick_Slider_Model_Resource_Slide
     * @author Ali Kazim
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
        }
        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Slick_Slider_Model_Slide $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('slider_slide_store' => $this->getTable('slick_slider/slide_store')),
                $this->getMainTable() . '.entity_id = slider_slide_store.slide_id',
                array()
            )
            ->where('slider_slide_store.store_id IN (?)', $storeIds)
            ->order('slider_slide_store.store_id DESC')
            ->limit(1);
        }
        return $select;
    }

    /**
     * Assign slide to store views
     *
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Slick_Slider_Model_Resource_Slide
     * @author Ali Kazim
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('slick_slider/slide_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = array(
                'slide_id = ?' => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );
            $this->_getWriteAdapter()->delete($table, $where);
        }
        if ($insert) {
            $data = array();
            foreach ($insert as $storeId) {
                $data[] = array(
                    'slide_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }
            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }
        return parent::_afterSave($object);
    }
}
