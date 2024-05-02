<?php

namespace Kitchen\News\Block\Adminhtml\Normalgrid\Edit;

/**
 * Admin blog left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('news_id');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('News Information'));
    }
}