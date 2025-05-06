<?php

namespace Icecube\AttributeManager\Controller\Adminhtml\Attribute;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Icecube\AttributeManager\Model\CustomerAttribute; 

class Edit extends Action
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Icecube\AttributeManager\Model\CustomerAttribute
     */
    protected $attributeModel;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     * @param CustomerAttribute $attributeModel
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        CustomerAttribute $attributeModel
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->attributeModel = $attributeModel;
        parent::__construct($context);
    }

    /**
     * Authorization level
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Icecube_AttributeManager::save');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Icecube_AttributeManager::icecube')
            ->addBreadcrumb(__('Attribute Manager'), __('Attribute Manager'))
            ->addBreadcrumb(__('Manage Attributes'), __('Manage Attributes'));

        return $resultPage;
    }

    /**
     * Edit Attribute
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->attributeModel;

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This attribute no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('attribute_data', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Attribute') : __('New Attribute'),
            $id ? __('Edit Attribute') : __('New Attribute')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Attribute Manager'));
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId() ? $model->getTitle() : __('New Attribute')
        );
        return $resultPage;
    }
}
