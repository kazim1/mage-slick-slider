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
 * Slider admin block
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */

class Slick_Slider_Block_Slider extends Mage_Core_Block_Template 
{

	public $template = 'slick_slider/slider.phtml';

	public $_collection = array();

	public $_slider;

	/**
	 * void setting slides collection and slider instance
	 */
	protected function _beforeToHtml()
	{
		parent::_beforeToHtml();

		if(!$this->getTemplate()) {
			$this->setTemplate($this->template);
		}

		$sliderSlug = $this->getData('slider_slug');

		$this->_slider = Mage::getModel('slick_slider/slider')
					->getCollection()
					->addFieldToFilter('slug', $sliderSlug)
					->getFirstItem();

	}

	/**
	 * Gets the slider.
	 *
	 * @return     Slick_Slider_Model_Slider  The slider.
	 */
	public function getSlider()
	{
		return $this->_slider;
	}

	/**
	 * Gets the slide collection.
	 *
	 * @return     Slick_Slider_Model_Slide_Collection  The slide collection.
	 */
	public function getSlideCollection()
	{
		return $this->_slider->getSelectedSlidesCollection();
	}

	/**
	 * Gets the slider parameters.
	 *
	 * @return     array  The slider parameters.
	 */
	public function getSliderParameters()
	{
		$params = array();

		if(!$this->_slider) {
			return $params;
		}

		$params = array(
			'slidesToShow' => intval($this->_slider->getData('slides_to_show')),
			'slidesToScroll' => intval($this->_slider->getData('slides_to_scroll')),
			'infinite' => boolval($this->_slider->getData('infinite')),
			'rtl' => boolval($this->_slider->getData('rtl')),
			'centerMode' => boolval($this->_slider->getData('center_mode')),
			'speed' => intval($this->_slider->getData('speed')),
			'dots' => boolval($this->_slider->getData('show_dots')),
			'arrows' => boolval($this->_slider->getData('show_arrows')),
			'margin' => intval($this->_slider->getData('spacing')),
			'fade' => boolval($this->_slider->getData('fade')),
			'centerPadding' => intval($this->_slider->getData('center_padding')) . 'px'		
		);

		return $params;
	}

}