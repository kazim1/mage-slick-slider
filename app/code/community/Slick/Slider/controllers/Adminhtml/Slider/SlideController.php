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
 * Slide admin controller
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Adminhtml_Slider_SlideController extends Slick_Slider_Controller_Adminhtml_Slider
{
    /**
     * init the slide
     *
     * @access protected
     * @return Slick_Slider_Model_Slide
     */
    protected function _initSlide()
    {
        $slideId  = (int) $this->getRequest()->getParam('id');
        $slide    = Mage::getModel('slick_slider/slide');
        if ($slideId) {
            $slide->load($slideId);
        }
        Mage::register('current_slide', $slide);
        return $slide;
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
             ->_title(Mage::helper('slick_slider')->__('Slides'));
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
     * edit slide - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function editAction()
    {
        $slideId    = $this->getRequest()->getParam('id');
        $slide      = $this->_initSlide();
        if ($slideId && !$slide->getId()) {
            $this->_getSession()->addError(
                Mage::helper('slick_slider')->__('This slide no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSlideData(true);
        if (!empty($data)) {
            $slide->setData($data);
        }
        Mage::register('slide_data', $slide);
        $this->loadLayout();
        $this->_title(Mage::helper('slick_slider')->__('Slick Slider'))
             ->_title(Mage::helper('slick_slider')->__('Slides'));
        if ($slide->getId()) {
            $this->_title($slide->getClass());
        } else {
            $this->_title(Mage::helper('slick_slider')->__('Add slide'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new slide action
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
     * save slide - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('slide')) {
            try {
                $slide = $this->_initSlide();
                $slide->addData($data);
                $imageName = $this->_uploadAndGetName(
                    'image',
                    Mage::helper('slick_slider/slide_image')->getImageBaseDir(),
                    $data
                );
                $slide->setData('image', $imageName);
                $videoName = $this->_uploadAndGetName(
                    'video',
                    Mage::helper('slick_slider/slide')->getFileBaseDir(),
                    $data
                );
                $slide->setData('video', $videoName);
                $posterName = $this->_uploadAndGetName(
                    'poster',
                    Mage::helper('slick_slider/slide')->getFileBaseDir(),
                    $data
                );
                $slide->setData('poster', $posterName);
                $slide->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('slick_slider')->__('Slide was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $slide->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                if (isset($data['image']['value'])) {
                    $data['image'] = $data['image']['value'];
                }
                if (isset($data['video']['value'])) {
                    $data['video'] = $data['video']['value'];
                }
                if (isset($data['poster']['value'])) {
                    $data['poster'] = $data['poster']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSlideData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['image']['value'])) {
                    $data['image'] = $data['image']['value'];
                }
                if (isset($data['video']['value'])) {
                    $data['video'] = $data['video']['value'];
                }
                if (isset($data['poster']['value'])) {
                    $data['poster'] = $data['poster']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was a problem saving the slide.')
                );
                Mage::getSingleton('adminhtml/session')->setSlideData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('slick_slider')->__('Unable to find slide to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete slide - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $slide = Mage::getModel('slick_slider/slide');
                $slide->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('slick_slider')->__('Slide was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error deleting slide.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('slick_slider')->__('Could not find slide to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete slide - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function massDeleteAction()
    {
        $slideIds = $this->getRequest()->getParam('slide');
        if (!is_array($slideIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select slides to delete.')
            );
        } else {
            try {
                foreach ($slideIds as $slideId) {
                    $slide = Mage::getModel('slick_slider/slide');
                    $slide->setId($slideId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('slick_slider')->__('Total of %d slides were successfully deleted.', count($slideIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error deleting slides.')
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
        $slideIds = $this->getRequest()->getParam('slide');
        if (!is_array($slideIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select slides.')
            );
        } else {
            try {
                foreach ($slideIds as $slideId) {
                $slide = Mage::getSingleton('slick_slider/slide')->load($slideId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d slides were successfully updated.', count($slideIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error updating slides.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass slider change - action
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function massSliderIdAction()
    {
        $slideIds = $this->getRequest()->getParam('slide');
        if (!is_array($slideIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('slick_slider')->__('Please select slides.')
            );
        } else {
            try {
                foreach ($slideIds as $slideId) {
                $slide = Mage::getSingleton('slick_slider/slide')->load($slideId)
                    ->setSliderId($this->getRequest()->getParam('flag_slider_id'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d slides were successfully updated.', count($slideIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('slick_slider')->__('There was an error updating slides.')
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
        $fileName   = 'slide.csv';
        $content    = $this->getLayout()->createBlock('slick_slider/adminhtml_slide_grid')
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
        $fileName   = 'slide.xls';
        $content    = $this->getLayout()->createBlock('slick_slider/adminhtml_slide_grid')
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
        $fileName   = 'slide.xml';
        $content    = $this->getLayout()->createBlock('slick_slider/adminhtml_slide_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('slick_slider/slide');
    }
}
