<?php

namespace Kitchen\News\Block\Adminhtml\Normalgrid\Edit;

/**
 * Adminhtml block grid edit form block
 */

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * Prepare the form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',       // Edit.php in block
                    'action' => $this->getData('action'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data', // for image uploading
                ],
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}