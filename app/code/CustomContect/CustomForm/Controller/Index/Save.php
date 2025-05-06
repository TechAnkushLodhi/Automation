<?php

namespace CustomContect\CustomForm\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use CustomContect\CustomForm\Model\CustomFormDataFactory;
use CustomContect\CustomForm\Api\CustomformRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;


class Save extends Action
{
    protected $dataPersistor;
    private $CustomFormDataFactory;
    private $CustomFormDataRepository;
  
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        CustomFormDataFactory $CustomFormDataFactory,
        CustomformRepositoryInterface $CustomFormDataRepository,
        
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->CustomFormDataFactory = $CustomFormDataFactory;
        $this->CustomFormDataRepository = $CustomFormDataRepository;
       
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                  
                // $existingModel = $this->CustomFormDataFactory->create()->getCollection()
                // ->addFieldToFilter('email', $data['email'])
                // ->getFirstItem();

                // if ($existingModel->getId()) {
                //     throw new LocalizedException(__('Email already exists. Please use a different email.'));
                // }

                
                $data['status']=1;
                
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    $fileUploader = $this->_objectManager->create(
                        'Magento\MediaStorage\Model\File\Uploader',
                        ['fileId' => 'image']
                    );
            
                    $fileUploader->setAllowedExtensions(['jpeg', 'jpg', 'png']);
                    $fileUploader->setAllowRenameFiles(true);
                    $fileUploader->setFilesDispersion(true);
            
                    $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                        ->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
            
                    $targetPath = $mediaDirectory->getAbsolutePath('form/images/');
                    $fileUploader->save($targetPath);
            
                    // Yahaan image ka complete path save karna hai
                    $data['image'] =$fileUploader->getUploadedFileName();
                     
                    

                }     


                   // Convert interests and hobby fields to JSON
                    $data['interests'] = isset($data['interests']) ? json_encode($data['interests']) : null;
                    $data['hobby'] = isset($data['hobby']) ? json_encode($data['hobby']) : null;
    

                $model = $this->CustomFormDataFactory->create();
                $model->setData($data);

                $this->_eventManager->dispatch(
                    'customform_cfrom_prepare_save',
                    ['customform' => $model, 'request' => $this->getRequest()]
                );

                $this->CustomFormDataRepository->save($model);
                $this->messageManager->addSuccessMessage(__('Form data has been saved.'));
                $this->dataPersistor->clear('customform_cfrom');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the form data.'));
            }
        }

        // Redirect or return a response based on your requirements
        return $this->_redirect('*/*/'); // Redirect to your form page
    }
}
