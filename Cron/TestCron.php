<?php

namespace Kitchen\News\Cron;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class TestCron
{
    /**
     * @var CollectionFactory
     */
    protected $customerCollectionFactory;
    protected $_transportBuilder;
    protected $inlineTranslation;
    protected $scopeConfig;

    /**
     * Testcron constructor.
     * @param CollectionFactory $customerCollectionFactory
     */
    public function __construct(
        CollectionFactory $customerCollectionFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->customerCollectionFactory = $customerCollectionFactory;
    }

    /**
     * Retrieve customer collection and do something with it
     *
     * @return void
     */
    public function execute()
    {
        $customerCollection = $this->customerCollectionFactory->create();
        $templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => 1);
        

        $fromEmail= $this->scopeConfig->getValue('info1/emails/from_emails', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $template= $this->scopeConfig->getValue('info1/emails/emails_template', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $this->inlineTranslation->suspend();
        foreach ($customerCollection as $customer) {
            $customerId = $customer->getId();
            $customerName = $customer->getName();
            $customerEmail = $customer->getEmail();
            print_r("Customer Id:" . $customerId . "= " . $customerEmail) . "<br>";
            $transport = $this->_transportBuilder->setTemplateIdentifier($template)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars([
                    'name' => $customerName,
                    'email' => $customerEmail,
                ])
                ->setFrom([
                    'name' => 'Test',
                    'email' => $fromEmail
                ])
                ->addTo([$customerEmail])
                ->addCc(['customerone@gmail.com'])

                // ->addBcc(['parikhaanchal12@gmail.com'])
                ->getTransport();
            $transport->sendMessage();
        }
        $this->inlineTranslation->resume(); // Move this outside the loop
    }
}


