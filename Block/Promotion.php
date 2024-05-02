<?php

namespace Kitchen\News\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Promotion extends Template
{
    protected $scopeConfig;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

    public function isModuleEnabled()
    {
        return $this->scopeConfig->getValue('info/general1/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getDisplayName()
    {
        return $this->scopeConfig->getValue('info/general1/name', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getDisplayDescription()
    {
        return $this->scopeConfig->getValue('info/general1/description', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getStartDate()
    {
        return $this->scopeConfig->getValue('info/general1/startDate', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getEndDate()
    {
        return $this->scopeConfig->getValue('info/general1/endDate', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isActive()
    {
        return $this->scopeConfig->getValue('info/general1/isActive', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function fileUpload()
    {
        return $this->scopeConfig->getValue('info/general1/fileUpload', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
