<?php

namespace Kitchen\News\Block\Adminhtml;

/**
 * Backend grid container block
 */
class Grid extends \Magento\Backend\Block\Widget\Container
{

    /**
     * @var string
     */
    protected $_template = 'grid/view.phtml';

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {

        $addButtonProps = [
            'id' => 'add_new_news',
            'label' => __('Add News'),
            'class' => 'add',
            'button_class' => '',
            'class_name' => 'Magento\Backend\Block\Widget\Button\SplitButton',
            'options' => $this->_getAddButtonOptions(),
        ];

        $this->buttonList->add('add_new', $addButtonProps);

        $this->setChild('news', $this->getLayout()->createBlock('Kitchen\News\Block\Adminhtml\Normalgrid\Grid', 'news.view.grid'));     // controller > grid.php
        return parent::_prepareLayout();
    }

    /**
     * @return array
     */
    protected function _getAddButtonOptions()
    {

        $splitButtonOptions[] = [
            'label' => __('Add New'),
            'onclick' => "setLocation('" . $this->_getCreateUrl() . "')",
        ];
        return $splitButtonOptions;
    }

    /**
     * @return string
     */
    protected function _getCreateUrl()
    {
        return $this->getUrl('news1/normalgrid/new');
    }

    /**
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('news');
    }
}