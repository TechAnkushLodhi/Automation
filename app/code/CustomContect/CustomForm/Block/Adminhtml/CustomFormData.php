<?php
namespace CustomContect\CustomForm\Block\Adminhtml;

class CustomFormData extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_cfrom';
        $this->_blockGroup = 'CustomContect_CustomForm';
        $this->_headerText = __('Manage CustomForm');

        parent::_construct();

        if ($this->_isAllowedAction('CustomContect_CustomForm::save')) {
            $this->buttonList->update('add', 'label', __('Add Employee'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
?>
