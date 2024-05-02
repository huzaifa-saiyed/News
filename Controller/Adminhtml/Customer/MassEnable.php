<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kitchen\News\Controller\Adminhtml\Customer;

use Magento\Framework\App\Action\HttpPostActionInterface;
// use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Kitchen\News\Model\ResourceModel\Customer\CustomerCollectionFactory;

/**
 * Class MassEnable
 */
class MassEnable extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Cms::save';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CustomerCollectionFactory
     */
    protected $customerCollectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CustomerCollectionFactory $customerCollectionFactory
     */
    public function __construct(Context $context, Filter $filter, CustomerCollectionFactory $customerCollectionFactory)
    {
        $this->filter = $filter;
        $this->customerCollectionFactory = $customerCollectionFactory;
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
        $collection = $this->filter->getCollection($this->customerCollectionFactory->create());

        foreach ($collection as $item) {
            $item->setIsActive('1');
            $item->save();
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been enabled.', $collection->getSize())
        );

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        // $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        // return $resultRedirect->setPath('*/*/');
        $this->_redirect('news1/Customer/index');
    }
}
