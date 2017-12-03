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
 * Slider edit form tab
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Block_Adminhtml_Slider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slider_Edit_Tab_Form
     * @author Ali Kazim
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('slider_');
        $form->setFieldNameSuffix('slider');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'slider_form',
            array('legend' => Mage::helper('slick_slider')->__('Slider'))
        );

        $fieldset->addField(
            'name',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Name'),
                'name'  => 'name',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'slug',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Slug'),
                'name'  => 'slug',
                'note'	=> $this->__('This will be used to fetch slider'),
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'slides_to_show',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Slides To Show'),
                'name'  => 'slides_to_show',

           )
        );

        $fieldset->addField(
            'slides_to_scroll',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Slides To Scroll'),
                'name'  => 'slides_to_scroll',

           )
        );

        $fieldset->addField(
            'center_mode',
            'select',
            array(
                'label' => Mage::helper('slick_slider')->__('Center Mode'),
                'name'  => 'center_mode',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('slick_slider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('slick_slider')->__('No'),
                ),
            ),
           )
        );

        $fieldset->addField(
            'show_dots',
            'select',
            array(
                'label' => Mage::helper('slick_slider')->__('Show Dots'),
                'name'  => 'show_dots',
                'note'	=> $this->__('Whether to show navigation or not.'),

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('slick_slider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('slick_slider')->__('No'),
                ),
            ),
           )
        );

        $fieldset->addField(
            'show_arrows',
            'select',
            array(
                'label' => Mage::helper('slick_slider')->__('Show Arrows'),
                'name'  => 'show_arrows',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('slick_slider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('slick_slider')->__('No'),
                ),
            ),
           )
        );

        $fieldset->addField(
            'speed',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Speed'),
                'name'  => 'speed',

           )
        );

        $fieldset->addField(
            'rtl',
            'select',
            array(
                'label' => Mage::helper('slick_slider')->__('RTL'),
                'name'  => 'rtl',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('slick_slider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('slick_slider')->__('No'),
                ),
            ),
           )
        );

        $fieldset->addField(
            'infinite',
            'select',
            array(
                'label' => Mage::helper('slick_slider')->__('Infinite'),
                'name'  => 'infinite',

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('slick_slider')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('slick_slider')->__('No'),
                ),
            ),
           )
        );

        $fieldset->addField(
            'class',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Style Class'),
                'name'  => 'class',

           )
        );

        $fieldset->addField(
            'spacing',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Spacing'),
                'name'  => 'spacing',
                'note' => Mage::helper('slick_slider')->__('Horizontal space between each slides')
           )
        );

        $fieldset->addField(
            'center_padding',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Center Padding'),
                'name'  => 'center_padding'
           )
        );

        $fieldset->addField(
            'fade',
            'select',
            array(
                'label'  => Mage::helper('slick_slider')->__('Fade'),
                'name'   => 'fade',
                'note'   => Mage::helper('slick_slider')->__('It will only works when Slides To Show option will be 1'),
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('slick_slider')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('slick_slider')->__('Disabled'),
                    ),
                ),
            )
        );

        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('slick_slider')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('slick_slider')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('slick_slider')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_slider')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSliderData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSliderData());
            Mage::getSingleton('adminhtml/session')->setSliderData(null);
        } elseif (Mage::registry('current_slider')) {
            $formValues = array_merge($formValues, Mage::registry('current_slider')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
