<?php
namespace Icecube\AttributeManager\Model;

use Icecube\AttributeManager\Api\CustomerAttributeRepositoryInterface;
use Icecube\AttributeManager\Api\Data\CustomerAttributeInterface;
use Icecube\AttributeManager\Model\ResourceModel\CustomerAttribute as ResourceModel;
use Icecube\AttributeManager\Model\CustomerAttributeFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

class CustomerAttributeRepository implements CustomerAttributeRepositoryInterface
{
    protected $resource;
    protected $attributeFactory;
    protected $searchResultsFactory;

    public function __construct(
        ResourceModel $resource,
        CustomerAttributeFactory $attributeFactory,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->attributeFactory = $attributeFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    public function getById($id)
    {
        $attribute = $this->attributeFactory->create();
        $this->resource->load($attribute, $id);
        return $attribute;
    }

    public function save(CustomerAttributeInterface $attribute)
    {
        $this->resource->save($attribute);
        return $attribute;
    }

    public function delete(CustomerAttributeInterface $attribute)
    {
        $this->resource->delete($attribute);
        return true;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->attributeFactory->create()->getCollection();
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }
}
