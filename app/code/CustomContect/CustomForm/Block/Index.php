<?php
namespace CustomContect\CustomForm\Block;

use Magento\Framework\View\Element\Template;
use CustomContect\CustomForm\Model\CustomFormDataFactory;

class Index extends Template
{
    protected $customFormDataFactory;

    public function __construct(
        Template\Context $context,
        CustomFormDataFactory $customFormDataFactory
    ) {
        $this->customFormDataFactory = $customFormDataFactory;
        parent::__construct($context);
    }

    public function getAllFormData()
    {
        $collection = $this->customFormDataFactory->create()->getCollection();
        return $collection;
    }
    

    public function getFormAction()
    {
        return $this->getUrl('customform/index/save', ['_secure' => true]);
    }
}
