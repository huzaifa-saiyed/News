<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kitchen\News\Controller\Adminhtml\Normalgrid;

use Magento\Framework\App\Action\HttpPostActionInterface;
// use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Kitchen\News\Model\ResourceModel\Gallery\CollectionFactory;

/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    // const ADMIN_RESOURCE = 'Magento_Cms::page_delete';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $ids = $this->getRequest()->getParam('news');
        if (!is_array($ids)) {
            $this->messageManager->addErrorMessage(__('Please select user(s).'));
        } else {
            try {
                $collection = $this->collectionFactory->create();
                $collection->addFieldToFilter('news_id', ['in' => $ids]);
                $collectionSize = $collection->getSize();
 
                // foreach ($collection as $user) {
                //     $user->delete();
                // }
        // $collection = $this->filter->getCollection($this->collectionFactory->create());
        // $collectionSize = $collection->getSize();

                foreach ($collection as $page) {
                    $page->delete();
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

    } catch (\Exception $e) {
        $this->messageManager->addExceptionMessage(
            $e,
            __('Something went wrong while deleting these records.')
        );
    }
}
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        // $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        
        // return $resultRedirect->setPath('*/*/');
        $this->_redirect('news1/normalgrid/index');
    }
}
