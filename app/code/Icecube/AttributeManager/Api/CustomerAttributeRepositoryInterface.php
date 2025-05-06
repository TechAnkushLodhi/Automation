<?php
namespace Icecube\AttributeManager\Api;

use Icecube\AttributeManager\Api\Data\CustomerAttributeInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CustomerAttributeRepositoryInterface
{
    public function getById($id);
    public function save(CustomerAttributeInterface $attribute);
    public function delete(CustomerAttributeInterface $attribute);
    public function getList(SearchCriteriaInterface $searchCriteria);
}
