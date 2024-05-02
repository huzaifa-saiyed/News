<?php

namespace Kitchen\News\Controller\Adminhtml\Form;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Kitchen\News\Model\GalleryFactory; 

class Saveform extends Action
{
    protected $galleryFactory;

    public function __construct(
        Context $context,
        GalleryFactory $galleryFactory
    ) {
        $this->galleryFactory = $galleryFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $varOne = $this->getRequest()->getPostValue();

        if (!$varOne) {
            $this->messageManager->addErrorMessage(__('Invalid data. Please try again.'));
            // return $resultRedirect->setPath('user2/page/index');
            $this->_redirect('news1/news/index');
        }

        $varModel = $this->galleryFactory->create();
        $varModel->setNewsTitle($varOne['news_title'])
            ->setNewsDesc($varOne['news_desc'])
            ->setIsActive($varOne["is_active"])
            ->setAId($varOne["a_id"]);
        
        try {
            $varModel->save();
            $this->messageManager->addSuccessMessage(__('data has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the user data.'));
            $this->_getSession()->setFormData($varOne);
            $this->_redirect('news1/news/index');
        }
        $this->_redirect('news1/news/index');
    }
}
