<?php
 
namespace Kitchen\News\Controller\Adminhtml\Customer;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Kitchen\News\Model\CustomerFactory;
 
class Saveform extends Action
{
    protected $customerFactory;
 
    public function __construct(
        Context $context,
        CustomerFactory $customerFactory
    ) {
        $this->customerFactory = $customerFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $varOne = $this->getRequest()->getPostValue();
        if (!$varOne) {
            $this->messageManager->addErrorMessage(__('Invalid data. Please try again.'));
            $this->_redirect('news1/customer/index');
        }
 
        $varModel = $this->customerFactory->create();
        $varModel->setFirstName($varOne['first_name']);
        $varModel->setLastName($varOne['last_name']);
        $varModel->setEmail($varOne['email']);
        $varModel->setGender($varOne['gender']);
        $varModel->setBirthDate($varOne['birth_date']);
        $varModel->setAddress($varOne['address']);
        $varModel->setIsActive($varOne['is_active']);          
        
        $hobbies = implode(',', $varOne['hobbies']);
        $varModel->setHobbies($hobbies);


        $subscription = implode(',', $varOne['newsletter_subscription']);
        $varModel->setNewsletterSubscription($subscription);

        if (!empty($varOne['profile_image'][0]['name'])) {
            $profileImageName = $varOne['profile_image'][0]['name'];
            $varModel->setProfileImage($profileImageName);
        }
            
        try {
            $varModel->save();
            $this->messageManager->addSuccessMessage(__('data has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving the user data.'));
            $this->_getSession()->setFormData($varOne);
            $this->_redirect('news1/customer/index');
        }
        $this->_redirect('news1/customer/index');
    }

} 