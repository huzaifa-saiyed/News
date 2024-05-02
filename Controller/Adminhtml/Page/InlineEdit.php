<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kitchen\News\Controller\Adminhtml\Page;


use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Kitchen\News\Model\GalleryFactory;
use Kitchen\News\Model\ResourceModel\Gallery as GalleryResourceModel;

class InlineEdit extends \Magento\Backend\App\Action
{
    // const ADMIN_RESOURCE = 'Magento_Cms::save';

    protected $jsonFactory;
    private $galleryFactory;
    private $galleryResourceModel;

    public function __construct(
        Context $context,
        GalleryFactory $galleryFactory,
        JsonFactory $jsonFactory,
        GalleryResourceModel $galleryResourceModel
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->galleryFactory = $galleryFactory;
        $this->galleryResourceModel = $galleryResourceModel;
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if($this->getRequest()->getParam('isAjax')){
            $postItems = $this->getRequest()->getParam('items', []);
            if(!count($postItems)){
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $newsid) {
                $varInlineEdit = $this->galleryFactory->create();
                $this->galleryResourceModel->load($varInlineEdit, $newsid);
                $varInlineEdit->setData(array_merge($varInlineEdit->getData(), $postItems[$newsid]));
                $this->galleryResourceModel->save($varInlineEdit);
                }
            }
        }

        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error
            ]
        );
    }
}
