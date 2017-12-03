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
 * Slide edit form tab
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Block_Adminhtml_Slide_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Slick_Slider_Block_Adminhtml_Slide_Edit_Tab_Form
     * @author Ali Kazim
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('slide_');
        $form->setFieldNameSuffix('slide');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'slide_form',
            array('legend' => Mage::helper('slick_slider')->__('Slide'))
        );
        $fieldset->addType(
            'image',
            Mage::getConfig()->getBlockClassName('slick_slider/adminhtml_slide_helper_image')
        );
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('slick_slider/adminhtml_slide_helper_file')
        );
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $values = Mage::getResourceModel('slick_slider/slider_collection')
            ->toOptionArray();
        array_unshift($values, array('label' => '', 'value' => ''));

        $html = '<a href="{#url}" id="slide_slider_id_link" target="_blank"></a>';
        $html .= '<script type="text/javascript">
            function changeSliderIdLink() {
                if ($(\'slide_slider_id\').value == \'\') {
                    $(\'slide_slider_id_link\').hide();
                } else {
                    $(\'slide_slider_id_link\').show();
                    var url = \''.$this->getUrl('adminhtml/slider_slider/edit', array('id'=>'{#id}', 'clear'=>1)).'\';
                    var text = \''.Mage::helper('core')->escapeHtml($this->__('View {#name}')).'\';
                    var realUrl = url.replace(\'{#id}\', $(\'slide_slider_id\').value);
                    $(\'slide_slider_id_link\').href = realUrl;
                    $(\'slide_slider_id_link\').innerHTML = text.replace(\'{#name}\', $(\'slide_slider_id\').options[$(\'slide_slider_id\').selectedIndex].innerHTML);
                }
            }
            $(\'slide_slider_id\').observe(\'change\', changeSliderIdLink);
            changeSliderIdLink();
            </script>';

        $fieldset->addField(
            'slider_id',
            'select',
            array(
                'label'     => Mage::helper('slick_slider')->__('Slider'),
                'name'      => 'slider_id',
                'required'  => true,
                'values'    => $values,
                'after_element_html' => $html,
                'class' => 'required-entry'
            )
        );

        $fieldset->addField(
            'title',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Title'),
                'name'  => 'title',
                'required'  => true,
                'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'image',
            'image',
            array(
                'label' => Mage::helper('slick_slider')->__('Image'),
                'name'  => 'image',

           )
        );

        /*$fieldset->addField(
            'video',
            'file',
            array(
                'label' => Mage::helper('slick_slider')->__('Video'),
                'name'  => 'video',
                'note'	=> $this->__('.mpv, mp4'),

           )
        );

        $fieldset->addField(
            'poster',
            'file',
            array(
                'label' => Mage::helper('slick_slider')->__('Video Poster'),
                'name'  => 'poster',

           )
        );*/

        $fieldset->addField(
            'content',
            'editor',
            array(
                'label' => Mage::helper('slick_slider')->__('Content'),
                'name'  => 'content',
            'config' => $wysiwygConfig,

           )
        );

        $fieldset->addField(
            'link',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Link'),
                'name'  => 'link',

           )
        );

        $fieldset->addField(
            'class',
            'text',
            array(
                'label' => Mage::helper('slick_slider')->__('Style Class'),
                'name'  => 'class'

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
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_slide')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_slide')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSlideData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSlideData());
            Mage::getSingleton('adminhtml/session')->setSlideData(null);
        } elseif (Mage::registry('current_slide')) {
            $formValues = array_merge($formValues, Mage::registry('current_slide')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
