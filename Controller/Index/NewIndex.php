<?php
namespace Kitchen\News\Controller\Index;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Model\QuoteRepository;

class NewIndex extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
    protected $checkoutSession;
	protected $jsonFactory;
	protected $quoteRepository;

	public function __construct(
        CheckoutSession $checkoutSession,
		JsonFactory $jsonFactory,
		QuoteRepository $quoteRepository,
		\Magento\Framework\App\Action\Context $context,
    ){
		$this->jsonFactory = $jsonFactory;
		$this->quoteRepository = $quoteRepository;
        $this->checkoutSession = $checkoutSession;
		return parent::__construct($context);
	}

	public function execute()
    {
 
        $jsonData = $this->getRequest()->getContent();
        $data = json_decode($jsonData, true);

		$customData = '';
 
        if (isset($data['value'])) {
            $customData = $data['value'];
        }
 
            $quote = $this->checkoutSession->getQuote();
            if ($quote->getId()) {
                $quote->setData('custom_option', $customData);
                $this->quoteRepository->save($quote);
				echo $quote->getId();
            } else {
                echo $quote->getId();
               echo "Not Found Quote";
            }
        
    }
}