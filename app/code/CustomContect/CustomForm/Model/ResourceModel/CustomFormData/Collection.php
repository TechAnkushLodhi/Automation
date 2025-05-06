<?php
namespace CustomContect\CustomForm\Model\ResourceModel\CustomFormData;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
	
	protected $_eventPrefix = 'custome_form_collection';

    protected $_eventObject = 'customeform_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('CustomContect\CustomForm\Model\CustomFormData', 'CustomContect\CustomForm\Model\ResourceModel\CustomFormData');
	}
}
?>
