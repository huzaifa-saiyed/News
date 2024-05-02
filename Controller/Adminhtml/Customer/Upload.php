<?php
 
namespace Kitchen\News\Controller\Adminhtml\Customer;
 
use Magento\Framework\Controller\ResultFactory;
 
class Upload extends \Magento\Backend\App\Action
{
 
    /**
     * @var \Kitchen\News\Model\ImageUploader
     */
    public $imageUploader;
 
    /**
     * Upload constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Kitchen\News\Model\ImageUploader $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Kitchen\News\Model\ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }
 
    /**
     * @return mixed
     */
    public function _isAllowed() {
        return $this->_authorization->isAllowed('Kitchen_News::customer_grid');
    }
 
    /**
     * @return mixed
     */
    public function execute() {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('profile_image');
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}