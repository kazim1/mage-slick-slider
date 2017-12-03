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
 * Slider admin grid block
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $this->setId('sliderGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slider_Grid
     * @author Ali Kazim
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('slick_slider/slider')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slider_Grid
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
            'name',
            array(
                'header'    => Mage::helper('slick_slider')->__('Name'),
                'align'     => 'left',
                'index'     => 'name',
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
        $this->addColumn(
            'slug',
            array(
                'header' => Mage::helper('slick_slider')->__('Slug'),
                'index'  => 'slug',
                'type'=> 'text',

            )
        );
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
     * @return Slick_Slider_Block_Adminhtml_Slider_Grid
     * @author Ali Kazim
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('slider');
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
        $this->getMassactionBlock()->addItem(
            'center_mode',
            array(
                'label'      => Mage::helper('slick_slider')->__('Change Center Mode'),
                'url'        => $this->getUrl('*/*/massCenterMode', array('_current'=>true)),
                'additional' => array(
                    'flag_center_mode' => array(
                        'name'   => 'flag_center_mode',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('slick_slider')->__('Center Mode'),
                        'values' => array(
                                '1' => Mage::helper('slick_slider')->__('Yes'),
                                '0' => Mage::helper('slick_slider')->__('No'),
                            )

                    )
                )
            )
        );
        $this->getMassactionBlock()->addItem(
            'show_dots',
            array(
                'label'      => Mage::helper('slick_slider')->__('Change Show Dots'),
                'url'        => $this->getUrl('*/*/massShowDots', array('_current'=>true)),
                'additional' => array(
                    'flag_show_dots' => array(
                        'name'   => 'flag_show_dots',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('slick_slider')->__('Show Dots'),
                        'values' => array(
                                '1' => Mage::helper('slick_slider')->__('Yes'),
                                '0' => Mage::helper('slick_slider')->__('No'),
                            )

                    )
                )
            )
        );
        $this->getMassactionBlock()->addItem(
            'show_arrows',
            array(
                'label'      => Mage::helper('slick_slider')->__('Change Show Arrows'),
                'url'        => $this->getUrl('*/*/massShowArrows', array('_current'=>true)),
                'additional' => array(
                    'flag_show_arrows' => array(
                        'name'   => 'flag_show_arrows',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('slick_slider')->__('Show Arrows'),
                        'values' => array(
                                '1' => Mage::helper('slick_slider')->__('Yes'),
                                '0' => Mage::helper('slick_slider')->__('No'),
                            )

                    )
                )
            )
        );
        $this->getMassactionBlock()->addItem(
            'rtl',
            array(
                'label'      => Mage::helper('slick_slider')->__('Change RTL'),
                'url'        => $this->getUrl('*/*/massRtl', array('_current'=>true)),
                'additional' => array(
                    'flag_rtl' => array(
                        'name'   => 'flag_rtl',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('slick_slider')->__('RTL'),
                        'values' => array(
                                '1' => Mage::helper('slick_slider')->__('Yes'),
                                '0' => Mage::helper('slick_slider')->__('No'),
                            )

                    )
                )
            )
        );
        $this->getMassactionBlock()->addItem(
            'infinite',
            array(
                'label'      => Mage::helper('slick_slider')->__('Change Infinite'),
                'url'        => $this->getUrl('*/*/massInfinite', array('_current'=>true)),
                'additional' => array(
                    'flag_infinite' => array(
                        'name'   => 'flag_infinite',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('slick_slider')->__('Infinite'),
                        'values' => array(
                                '1' => Mage::helper('slick_slider')->__('Yes'),
                                '0' => Mage::helper('slick_slider')->__('No'),
                            )

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
     * @param Slick_Slider_Model_Slider
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
     * @return Slick_Slider_Block_Adminhtml_Slider_Grid
     * @author Ali Kazim
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
