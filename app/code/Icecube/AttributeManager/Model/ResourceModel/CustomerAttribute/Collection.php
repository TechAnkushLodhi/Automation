<?php
namespace Icecube\AttributeManager\Model\ResourceModel\CustomerAttribute;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Icecube\AttributeManager\Model\CustomerAttribute as Model;
use Icecube\AttributeManager\Model\ResourceModel\CustomerAttribute as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'attribute_id';

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}

