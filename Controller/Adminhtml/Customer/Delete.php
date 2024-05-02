<?php
namespace Kitchen\News\Controller\Adminhtml\Customer;
 
use Magento\Framework\App\Action\HttpPostActionInterface;
use Kitchen\News\Model\CustomerFactory;
 
class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    //const ADMIN_RESOURCE = 'Magento_Cms::page_delete';
 
    protected $customerFactory;
 
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        CustomerFactory $customerFactory,
    ) {
        parent::__construct($context);
        $this->customerFactory = $customerFactory;
    }
 
    public function execute()
    {
        $id = $this->getRequest()->getParam('customer_id');
       // $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($id) {
            try {
                
                $pageModel = $this->customerFactory->create()->load($id);
                $pageModel->delete();
                
                $this->messageManager->addSuccessMessage(__('The page has been deleted.'));
               // return $resultRedirect->setPath('*/*/');
            } catch (\Exception  $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                //return $resultRedirect->setPath('*/*/edit', ['blog_id' => $id]);
            }
        }
        
        $this->messageManager->addErrorMessage(__('We can\'t find a page to delete.'));
       $this->_redirect('news1/Customer/index');
    }
}