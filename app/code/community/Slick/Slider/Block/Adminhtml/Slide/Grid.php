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
 * Slide admin grid block
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Block_Adminhtml_Slide_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Ali Kazim
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('slideGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slide_Grid
     * @author Ali Kazim
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('slick_slider/slide')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slide_Grid
     * @author Ali Kazim
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('slick_slider')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'slider_id',
            array(
                'header'    => Mage::helper('slick_slider')->__('Slider'),
                'index'     => 'slider_id',
                'type'      => 'options',
                'options'   => Mage::getResourceModel('slick_slider/slider_collection')
                    ->toOptionHash(),
                'renderer'  => 'slick_slider/adminhtml_helper_column_renderer_parent',
                'params'    => array(
                    'id'    => 'getSliderId'
                ),
                'base_link' => 'adminhtml/slider_slider/edit'
            )
        );
        $this->addColumn(
            'title',
            array(
                'header'    => Mage::helper('slick_slider')->__('Slide Title'),
                'align'     => 'left',
                'index'     => 'title',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('slick_slider')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('slick_slider')->__('Enabled'),
                    '0' => Mage::helper('slick_slider')->__('Disabled'),
                )
            )
        );
        
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn(
                'store_id',
                array(
                    'header'     => Mage::helper('slick_slider')->__('Store Views'),
                    'index'      => 'store_id',
                    'type'       => 'store',
                    'store_all'  => true,
                    'store_view' => true,
                    'sortable'   => false,
                    'filter_condition_callback'=> array($this, '_filterStoreCondition'),
                )
            );
        }
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('slick_slider')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('slick_slider')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('slick_slider')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('slick_slider')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('slick_slider')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slide_Grid
     * @author Ali Kazim
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('slide');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('slick_slider')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('slick_slider')->__('Are you sure?')
            )
        );
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label'      => Mage::helper('slick_slider')->__('Change status'),
                'url'        => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'status' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('slick_slider')->__('Status'),
                        'values' => array(
                            '1' => Mage::helper('slick_slider')->__('Enabled'),
                            '0' => Mage::helper('slick_slider')->__('Disabled'),
                        )
                    )
                )
            )
        );
        $values = Mage::getResourceModel('slick_slider/slider_collection')->toOptionHash();
        $values = array_reverse($values, true);
        $values[''] = '';
        $values = array_reverse($values, true);
        $this->getMassactionBlock()->addItem(
            'slider_id',
            array(
                'label'      => Mage::helper('slick_slider')->__('Change Slider'),
                'url'        => $this->getUrl('*/*/massSliderId', array('_current'=>true)),
                'additional' => array(
                    'flag_slider_id' => array(
                        'name'   => 'flag_slider_id',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('slick_slider')->__('Slider'),
                        'values' => $values
                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Slick_Slider_Model_Slide
     * @return string
     * @author Ali Kazim
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Ali Kazim
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slide_Grid
     * @author Ali Kazim
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * filter store column
     *
     * @access protected
     * @param Slick_Slider_Model_Resource_Slide_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Slick_Slider_Block_Adminhtml_Slide_Grid
     * @author Ali Kazim
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
