<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kitchen\News\Model\Config\Source\Customer;

use Kitchen\News\Model\CustomerFactory;

/**
 * @api
 * @since 100.0.2
 */
class IsActive implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */

    protected $customerFactory;

    public function __construct(
        CustomerFactory $customerFactory
    ) {
        $this->customerFactory = $customerFactory;
    }

    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => 'De-Active'],
            ['value' => '1', 'label' => 'Active']
        ];
        
        }
    }
