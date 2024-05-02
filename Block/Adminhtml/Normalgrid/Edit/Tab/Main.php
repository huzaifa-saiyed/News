<?php

namespace Kitchen\News\Block\Adminhtml\Normalgrid\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;


class Main extends Generic implements TabInterface
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_adminSession;

    /**
     * @var \Rh\Blog\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param \Magento\Backend\Model\Auth\Session     $adminSession
     * @param \Kitchen\News\Model\Status              $status
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Backend\Model\Auth\Session $adminSession,
        \Kitchen\News\Model\Status $status,
        array $data = []
    ) {
        $this->_adminSession = $adminSession;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare the form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('kitchen_news_form_data');

        $isElementDisabled = false;

        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('News Information')]);

        if ($model->getId()) {
            $fieldset->addField('news_id', 'hidden', ['name' => 'news_id']);
        }

        $fieldset->addField(
            'news_title',   //col_name
            'text', //datatype
            [
                'name' => 'news_title',
                'label' => __('News Name'),
                'title' => __('News Name'),
                'required' => true,
                'value' => $model->getNewsTitle(),
                'disabled' => $isElementDisabled,
            ]
        );

        $fieldset->addField(
            'news_desc',
            'textarea',
            [
                'name' => 'news_desc',
                'label' => __('News Description'),
                'title' => __('News Description'),
                'required' => true,
                'disabled' => $isElementDisabled,
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Status'),
                'title' => __('Status'),
                'required' => true,
                // 'options' => $this->_status->getOptionArray(),
                'options' => ['0' => __('De-Active'), '1' => __('Active')],
                'disabled' => $isElementDisabled,
            ]
        );

        $fieldset->addField(
            'a_id',
            'text',
            [
                'name' => 'a_id',
                'label' => __('Admin ID'),
                'title' => __('Admin ID'),
                'required' => true,
                'disabled' => $isElementDisabled,
            ]
        );

        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
            
            // Set default value for 'is_active' only when creating a new entry
            // $model->setData('is_active', '1');
        }

        $form->addValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Return Tab label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('News Information');
    }

    /**
     * Return Tab title
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('News Information');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}