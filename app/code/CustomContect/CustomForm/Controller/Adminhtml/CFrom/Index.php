<?php
namespace CustomContect\CustomForm\Controller\Adminhtml\CFrom;
class Index extends \Magento\Backend\App\Action
{
	protected $CustomFormDataFactory;
	protected $resultPageFactory;
	
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\CustomContect\CustomForm\Model\CustomFormDataFactory $CustomFormDataFactory
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->CustomFormDataFactory = $CustomFormDataFactory;
	}

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend(__('Employees Data'));
		return $resultPage;


		// $Customform = $this->CustomFormDataFactory->create();
		// $CustomformCollection = $Customform->getCollection();
		
		// echo '<pre>';print_r($CustomformCollection->getData());
	}
}
?>
