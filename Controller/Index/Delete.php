<?php

namespace Kitchen\News\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Kitchen\News\Model\GalleryFactory;

class Delete extends Action
{
    protected $galleryFactory;
    protected $messageManager;

    public function __construct(
        Context $context,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        GalleryFactory $galleryFactory
    ) {
        $this->galleryFactory = $galleryFactory;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $varModel = $this->galleryFactory->create();

        if ($id) {
            $varModel->load($id);
            if ($varModel->getId()) {
                $varModel->delete();
                $this->messageManager->addSuccess(__("Deleted Successfully."));
            } else {
                $this->messageManager->addError(__("Oops! Record Not Found."));
            }
            $this->_redirect('news/index/index');
        } else {
            $this->messageManager->addWarning(__("Wrong ID"));
            $this->_redirect('news/index/index');
        }
    }
}
