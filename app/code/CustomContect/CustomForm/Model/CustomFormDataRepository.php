<?php

namespace CustomContect\CustomForm\Model;


use CustomContect\CustomForm\Api\Data;
use CustomContect\CustomForm\Api\CustomformRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use CustomContect\CustomForm\Model\ResourceModel\CustomFormData as ResourceCustomFormData;
use CustomContect\CustomForm\Model\ResourceModel\CustomFormData\CollectionFactory as CustomFormDataCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;





class CustomFormDataRepository implements CustomformRepositoryInterface
{
    protected $resource;

    protected $allnewsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataAllnewsFactory;

    private $storeManager;

  
    
    public function __construct(
        ResourceCustomFormData $resource,
        CustomFormDataFactory $allnewsFactory,
        Data\CustomformInterface $dataAllnewsFactory,
        DataObjectHelper $dataObjectHelper,
		DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        
        
    ) {
        $this->resource = $resource;
		$this->allnewsFactory = $allnewsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAllnewsFactory = $dataAllnewsFactory;
		$this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
       
        
    }

    public function save(\CustomContect\CustomForm\Api\Data\CustomformInterface $formdata)
    {
        if ($formdata->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $formdata->setStoreId($storeId);
        }
        try {
            $this->resource->save($formdata);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the news: %1', $exception->getMessage()),
                $exception
            );
        }
        return $formdata;
    }

    public function getById($Id)
    {
		$formdata = $this->allnewsFactory->create();
        $formdata->load($Id);
        if (!$formdata->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $Id));
        }
        return $formdata;
    }
	
    public function delete(\CustomContect\CustomForm\Api\Data\CustomformInterface $formdata)
    {
        try {
            $this->resource->delete($formdata);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the news: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($Id)
    {
        return $this->delete($this->getById($Id));
    }

    
    
   
}
?>
