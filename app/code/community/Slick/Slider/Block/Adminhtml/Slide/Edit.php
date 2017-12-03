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
 * Slide admin edit form
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Block_Adminhtml_Slide_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'slick_slider';
        $this->_controller = 'adminhtml_slide';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('slick_slider')->__('Save Slide')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('slick_slider')->__('Delete Slide')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('slick_slider')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ali Kazim
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_slide') && Mage::registry('current_slide')->getId()) {
            return Mage::helper('slick_slider')->__(
                "Edit Slide '%s'",
                $this->escapeHtml(Mage::registry('current_slide')->getClass())
            );
        } else {
            return Mage::helper('slick_slider')->__('Add Slide');
        }
    }
}
