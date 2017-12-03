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
 * Slider admin controller
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Adminhtml_Slider_SliderController extends Slick_Slider_Controller_Adminhtml_Slider
{
    /**
     * init the slider
     *
     * @access protected
     * @return Slick_Slider_Model_Slider
     */
    protected function _initSlider()
    {
        $sliderId  = (int) $this->getRequest()->getParam('id');
        $slider    = Mage::getModel('slick_slider/slider');
        if ($sliderId) {
            $slider->load($sliderId);
        }
        Mage::register('current_slider', $slider);
        return $slider;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('slick_slider')->__('Slick Slider'))
             ->_title(Mage::helper('slick_slider')->__('Sliders'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit slider - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function editAction()
    {
        $sliderId    = $this->getRequest()->getParam('id');
        $slider      = $this->_initSlider();
        if ($sliderId && !$slider->getId()) {
            $this->_getSession()->addError(
                Mage::helper('slick_slider')->__('This slider no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSliderData(true);
        if (!empty($data)) {
            $slider->setData($data);
        }
        Mage::register('slider_data', $slider);
        $this->loadLayout();
        $this->_title(Mage::helper('slick_slider')->__('Slick Slider'))
             ->_title(Mage::helper('slick_slider')->__('Sliders'));
        if ($slider->getId()) {
            $this->_title($slider->getName());
        } else {
            $this->_title(Mage::helper('slick_slider')->__('Add slider'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new slider action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save slider - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('slider')) {
            try {
                $slider = $this->_initSlider();
                $slider->addData($data);
                $slider->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('slick_slider')->__('Slider was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $slider->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSliderData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was a problem saving the slider.')
                );
                Mage::getSingleton('adminhtml/session')->setSliderData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('slick_slider')->__('Unable to find slider to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete slider - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $slider = Mage::getModel('slick_slider/slider');
                $slider->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('slick_slider')->__('Slider was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error deleting slider.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('slick_slider')->__('Could not find slider to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete slider - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function massDeleteAction()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select sliders to delete.')
            );
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getModel('slick_slider/slider');
                    $slider->setId($sliderId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('slick_slider')->__('Total of %d sliders were successfully deleted.', count($sliderIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error deleting sliders.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function massStatusAction()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select sliders.')
            );
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('slick_slider/slider')->load($sliderId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sliders were successfully updated.', count($sliderIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error updating sliders.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Center Mode change - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function massCenterModeAction()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select sliders.')
            );
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('slick_slider/slider')->load($sliderId)
                    ->setCenterMode($this->getRequest()->getParam('flag_center_mode'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sliders were successfully updated.', count($sliderIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error updating sliders.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Show Dots change - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function massShowDotsAction()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select sliders.')
            );
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('slick_slider/slider')->load($sliderId)
                    ->setShowDots($this->getRequest()->getParam('flag_show_dots'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sliders were successfully updated.', count($sliderIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error updating sliders.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Show Arrows change - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function massShowArrowsAction()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select sliders.')
            );
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('slick_slider/slider')->load($sliderId)
                    ->setShowArrows($this->getRequest()->getParam('flag_show_arrows'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sliders were successfully updated.', count($sliderIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error updating sliders.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass RTL change - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function massRtlAction()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select sliders.')
            );
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('slick_slider/slider')->load($sliderId)
                    ->setRtl($this->getRequest()->getParam('flag_rtl'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sliders were successfully updated.', count($sliderIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error updating sliders.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass Infinite change - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function massInfiniteAction()
    {
        $sliderIds = $this->getRequest()->getParam('slider');
        if (!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select sliders.')
            );
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                $slider = Mage::getSingleton('slick_slider/slider')->load($sliderId)
                    ->setInfinite($this->getRequest()->getParam('flag_infinite'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d sliders were successfully updated.', count($sliderIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error updating sliders.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function exportCsvAction()
    {
        $fileName   = 'slider.csv';
        $content    = $this->getLayout()->createBlock('slick_slider/adminhtml_slider_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function exportExcelAction()
    {
        $fileName   = 'slider.xls';
        $content    = $this->getLayout()->createBlock('slick_slider/adminhtml_slider_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function exportXmlAction()
    {
        $fileName   = 'slider.xml';
        $content    = $this->getLayout()->createBlock('slick_slider/adminhtml_slider_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ali Kazim
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('slick_slider/slider');
    }
}
