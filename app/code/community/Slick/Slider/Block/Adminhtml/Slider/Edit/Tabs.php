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
 * Slider admin edit tabs
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Block_Adminhtml_Slider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ali Kazim
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('slick_slider')->__('Slider'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slider_Edit_Tabs
     * @author Ali Kazim
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_slider',
            array(
                'label'   => Mage::helper('slick_slider')->__('Slider'),
                'title'   => Mage::helper('slick_slider')->__('Slider'),
                'content' => $this->getLayout()->createBlock(
                    'slick_slider/adminhtml_slider_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve slider entity
     *
     * @access public
     * @return Slick_Slider_Model_Slider
     * @author Ali Kazim
     */
    public function getSlider()
    {
        return Mage::registry('current_slider');
    }
}
