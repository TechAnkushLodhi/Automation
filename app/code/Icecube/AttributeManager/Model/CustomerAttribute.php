<?php
namespace Icecube\AttributeManager\Model;

use Magento\Framework\Model\AbstractModel;
use Icecube\AttributeManager\Api\Data\CustomerAttributeInterface;
use Icecube\AttributeManager\Model\ResourceModel\CustomerAttribute as ResourceModel;

class CustomerAttribute extends AbstractModel implements CustomerAttributeInterface
{

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getAttributeId()
    {
        return $this->getData(self::ATTRIBUTE_ID);
    }

    public function setAttributeId($attributeId)
    {
        return $this->setData(self::ATTRIBUTE_ID, $attributeId);
    }
  
    public function getAttributeCode()
    {
        return $this->getData(self::ATTRIBUTE_CODE);
    }

    public function setAttributeCode($attributeCode)
    {
        return $this->setData(self::ATTRIBUTE_CODE, $attributeCode);
    }

    public function getFrontendLabel()
    {
        return $this->getData(self::FRONTEND_LABEL);
    }

    public function setFrontendLabel($frontendLabel)
    {
        return $this->setData(self::FRONTEND_LABEL, $frontendLabel);
    }

    public function getIsRequired()
    {
        return $this->getData(self::IS_REQUIRED);
    }

    public function setIsRequired($isRequired)
    {
        return $this->setData(self::IS_REQUIRED, $isRequired);
    }
}
