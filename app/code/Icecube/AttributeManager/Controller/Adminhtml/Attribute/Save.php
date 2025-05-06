<?php
namespace Icecube\AttributeManager\Controller\Adminhtml\Attribute;


class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Icecube\AttributeManager\Model\CustomerAttributeFactory
     */
    var $gridFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Icecube\AttributeManager\Model\CustomerAttributeFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Icecube\AttributeManager\Model\CustomerAttributeFactory $gridFactory
    ) {
        parent::__construct($context);
        $this->gridFactory = $gridFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
       
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('attribute_manager/attribute/addrow');
            return;
        }
        try {
            $rowData = $this->gridFactory->create();
            $rowData->setData($data);
           
            if (isset($data['id'])) {
                $rowData->setEntityId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Attribute data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('attribute_manager/attribute/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Icecube_AttributeManager::save');
    }
}