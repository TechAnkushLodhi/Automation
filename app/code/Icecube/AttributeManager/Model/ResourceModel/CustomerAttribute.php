<?php
// Compare this snippet from app/code/Icecube/AttributeManager/Model/ResourceModel/CustomerAttribute.php:      
namespace Icecube\AttributeManager\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerAttribute extends AbstractDb
{
     /**
     * @var string
     */
    protected $_idFieldName = 'attribute_id';

     /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;


    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $resourcePrefix = null
    ) 
    {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
    }

    protected function _construct()
    {
        $this->_init('icecube_customer_attributes', 'attribute_id');
    }
}
?>