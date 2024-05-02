<?php

namespace Kitchen\News\Controller\Adminhtml\Normalgrid;

use Magento\Backend\App\Action\Context;
use Kitchen\News\Model\GalleryFactory;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
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
        $resultRedirect = $this->resultRedirectFactory->create();
        $varOne = $this->getRequest()->getPostValue();

        if (!$varOne) {
            $this->messageManager->addErrorMessage(__('Invalid data. Please try again.'));
        } else {
            try {
                if (!empty($varOne['news_id'])) {
                    $varModel = $this->galleryFactory->create()->load($varOne['news_id']);
                    $this->messageManager->addSuccessMessage(__('Data has been updated.'));
                } else {
                    $varModel = $this->galleryFactory->create();
                    $this->messageManager->addSuccessMessage(__('Data has been saved.'));
                }

                $varModel->setNewsTitle($varOne['news_title']);
                $varModel->setNewsDesc($varOne['news_desc']);
                $varModel->setAId($varOne['a_id']);
                $varModel->setIsActive($varOne['is_active']);

                $varModel->save();
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the user data.'));
            }
        }

        return $resultRedirect->setPath('news1/normalgrid/index');
    }
}
