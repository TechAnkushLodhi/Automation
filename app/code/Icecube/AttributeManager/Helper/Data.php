<?php
namespace Icecube\AttributeManager\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_CUSTOM_CONFIG = 'manage_attribute/general/custom_text';
    const XML_PATH_ENABLED = 'manage_attribute/general/enabled';

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getCustomConfig($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CUSTOM_CONFIG, $storeId);
    }

    public function isModuleEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
