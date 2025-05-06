<?php

namespace CustomContect\CustomForm\Model\CustomFormData;

use CustomContect\CustomForm\Model\ResourceModel\CustomFormData\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;



class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $customformdataCollectionFactory;
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $storeManager;


    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $customformdataCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $customformdataCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->meta = $this->prepareMeta($this->meta);
    }

    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $item) {
            $data = $item->getData();
            
            // Check if the 'image' field exists and is not empty
            if (isset($data['image']) && !empty($data['image'])) {
                $image = [];
                $image[0]['name'] = $data['image'];
                $image[0]['url'] = $this->getMediaUrl($data['image']);
                $data['image'] = $image;
            }
            if (isset($data['hobby'])) {
                $data['hobby'] = json_decode($data['hobby'], true);
            }
            if (isset($data['interests'])) {
                $data['interests'] = json_decode($data['interests'], true);
            }

            $this->loadedData[$item->getId()] = $data;
        }

        $data = $this->dataPersistor->get("customform_cfrom");
        if (!empty($data)) {
                  
           
            $news = $this->collection->getNewEmptyItem();
            $news->setData($data);
              
            // Check if the 'image' field exists and is not empty
            if (isset($data['image']) && !empty($data['image'])) {
                $image = [];
                $image[0]['name'] = $data['image'];
                $image[0]['url'] = $this->getMediaUrl($data['image']);
                $data['image'] = $image;
            }

            $this->loadedData[$news->getId()] = $data;
            $this->dataPersistor->clear("customform_cfrom");
        }
    
        return $this->loadedData;
    }

    // Add this function to get the media URL
    protected function getMediaUrl($imageName)
    {
        return $this->storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'form/images/' . $imageName;
    }

   
}
