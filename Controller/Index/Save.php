<?php

namespace Kitchen\News\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Kitchen\News\Model\GalleryFactory; 

class Save extends Action
{
    protected $galleryFactory;
    protected $messageManager;

    public function __construct(
        Context $context,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        GalleryFactory $galleryFactory
    ) {
        $this->messageManager = $messageManager;
        $this->galleryFactory = $galleryFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $varOne = $this->getRequest()->getPostValue();
        $varModel = $this->galleryFactory->create();

        if (isset($varOne['news_id']) && $varOne['news_id'] > 0) {
            $varModel->load($varOne['news_id']);
            $varModel->setNewsTitle($varOne["newsTitle"]);
            $varModel->setNewsDesc($varOne["newsDesc"]);
            $varModel->setIsActive($varOne["newsFilter"]);
            $varModel->save();
            $this->messageManager->addSuccess(__("Updated Successfully."));
            $this->_redirect('news/index/index');
        } else {
            $varModel->setNewsTitle($varOne['newsTitle']);
            $varModel->setNewsDesc($varOne['newsDesc']);
            $varModel->setIsActive($varOne["newsFilter"]);
            $varModel->save();
            $this->messageManager->addSuccess(__("Inserted Successfully."));
            $this->_redirect('news/index/index');
        }
    }
}
