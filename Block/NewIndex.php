<?php

namespace Kitchen\News\Block;

class NewIndex extends \Magento\Framework\View\Element\Template
{
    protected $urlBuilder;
    protected $timezoneInterface;
    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $_json;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
        \Magento\Framework\Serialize\Serializer\Json $json
    ) {
        $this->timezoneInterface = $timezoneInterface;
        $this->_json = $json;
        parent::__construct($context);
    }

    public function show()
    {
        echo "111";
    }
}
