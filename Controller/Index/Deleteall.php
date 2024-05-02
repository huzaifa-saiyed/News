<?php

namespace Kitchen\News\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Kitchen\News\Model\GalleryFactory;

class Deleteall extends Action
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
        $varModel = $this->galleryFactory->create();
        $varCollection = $varModel->getCollection();
        if ($varCollection->getSize() > 0) {
            foreach ($varCollection as $varDelete) {
                $varDelete->delete();
            } 
            $this->messageManager->addSuccess(__("All Data Successfully Deleted."));
            $this->_redirect('news/index/index');
        } else {
            $this->messageManager->addError(__("No data to delete."));
            $this->_redirect('news/index/index');
        }
    }
}
