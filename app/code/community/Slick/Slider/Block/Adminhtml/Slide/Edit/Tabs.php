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
 * Slide admin edit tabs
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Block_Adminhtml_Slide_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('slide_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('slick_slider')->__('Slide'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slide_Edit_Tabs
     * @author Ali Kazim
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_slide',
            array(
                'label'   => Mage::helper('slick_slider')->__('Slide'),
                'title'   => Mage::helper('slick_slider')->__('Slide'),
                'content' => $this->getLayout()->createBlock(
                    'slick_slider/adminhtml_slide_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_slide',
                array(
                    'label'   => Mage::helper('slick_slider')->__('Store views'),
                    'title'   => Mage::helper('slick_slider')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'slick_slider/adminhtml_slide_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve slide entity
     *
     * @access public
     * @return Slick_Slider_Model_Slide
     * @author Ali Kazim
     */
    public function getSlide()
    {
        return Mage::registry('current_slide');
    }
}
