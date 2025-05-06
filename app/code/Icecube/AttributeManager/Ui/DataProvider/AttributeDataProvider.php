<?php
namespace Icecube\AttributeManager\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Icecube\AttributeManager\Model\ResourceModel\CustomerAttribute\CollectionFactory;

class AttributeDataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $data = $this->collection->toArray();
        return $data ?? [];
    }
}

