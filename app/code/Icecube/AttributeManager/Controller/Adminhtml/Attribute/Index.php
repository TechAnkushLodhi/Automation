<?php

namespace Icecube\AttributeManager\Controller\Adminhtml\Attribute;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\Redirect; 

class Index extends Action
{
    const ADMIN_RESOURCE = 'Icecube_AttributeManager::attributemanager'; // ACL Permission

    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        // 🔹 Check ACL Permission
        if (!$this->_isAllowed()) {
            return $this->resultRedirectFactory->create()->setPath('admin/noroute'); 
        }

        // 🔹 Admin Panel Page Create
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Icecube_AttributeManager::icecube');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Attributes'));

        return $resultPage;
    }

    // 🔹 Check ACL Permission Function
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}
