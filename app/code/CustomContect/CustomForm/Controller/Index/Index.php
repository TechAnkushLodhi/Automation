<?php
namespace CustomContect\CustomForm\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use CustomContect\CustomForm\Helper\Data as CustomModuleHelper;
class Index extends Action
{
    protected $resultPageFactory;
    protected $customModuleHelper;


    public function __construct(Context $context, PageFactory $resultPageFactory, CustomModuleHelper $customModuleHelper)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->customModuleHelper = $customModuleHelper;
    }

    public function execute()
    {
        if ($this->customModuleHelper->isEnabled()) {
            return $this->resultPageFactory->create();
        } else {
            $this->_forward('noroute');
        }
    }
}
