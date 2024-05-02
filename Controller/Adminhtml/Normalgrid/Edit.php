<?php

namespace Kitchen\News\Controller\Adminhtml\Normalgrid;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Edit form controller
 */
class Edit extends \Magento\Backend\App\Action
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $adminSession;

    /**
     * @var \Rh\Blog\Model\BlogFactory
     */
    protected $blogFactory;

    /**
     * @param Action\Context                 $context
     * @param \Magento\Framework\Registry    $registry
     * @param \Magento\Backend\Model\Session $adminSession
     * @param \Kitchen\News\Model\GalleryFactory     $galleryFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\Model\Session $adminSession,
        \Kitchen\News\Model\GalleryFactory $galleryFactory
    ) {
        $this->_coreRegistry = $registry;
        $this->adminSession = $adminSession;
        $this->galleryFactory = $galleryFactory;
        parent::__construct($context);
    }

    /**
     * @return boolean
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Add blog breadcrumbs
     *
     * @return $this
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Kitchen_News::customer')->addBreadcrumb(__('News'), __('News'))->addBreadcrumb(__('Manage News'), __('Manage News'));
        return $resultPage;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('news_id');
        $model = $this->galleryFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This news record no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                // return $resultRedirect->setPath('*/*/');
                $this->_redirect('news1/Normalgrid/index');
            }
        }
        $data = $this->adminSession->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        // Main.php
        $this->_coreRegistry->register('kitchen_news_form_data', $model);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb($id ? __('Edit Post') : __('New News'), $id ? __('Edit Post') : __('New News'));
        $resultPage->getConfig()->getTitle()->prepend(__('Grids'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New News'));

        return $resultPage;
    }
}