<?php

namespace CustomContect\CustomForm\Controller\Adminhtml\CFrom;

use Magento\Backend\App\Action;
use CustomContect\CustomForm\Model\CustomFormDataRepository;
use CustomContect\CustomForm\Model\CustomFormData;
use CustomContect\CustomForm\Api\CustomformRepositoryInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Data\FormFactory;


class Save extends \Magento\Backend\App\Action
{
    protected $resultJsonFactory;

    protected $customFormDataRepository;
    protected $formFactory;


    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \CustomContect\CustomForm\Model\CustomFormDataFactory
     */
    private $allnewsFactory;

    /**
     * @var \CustomContect\CustomForm\Api\CustomformRepositoryInterface
     */
    private $allnewsRepository;

    /**
     * @param Action\Context $context
     * @param JsonFactory $resultJsonFactory
     * @param CustomFormDataRepository $customFormDataRepository
     * @param DataPersistorInterface $dataPersistor
     * @param \CustomContect\CustomForm\Model\CustomFormDataFactory $allnewsFactory
     * @param \CustomContect\CustomForm\Api\CustomformRepositoryInterface $allnewsRepository
     */
    public function __construct(
        Action\Context $context,
        JsonFactory $resultJsonFactory,
        CustomFormDataRepository $customFormDataRepository,
        DataPersistorInterface $dataPersistor,
        \CustomContect\CustomForm\Model\CustomFormDataFactory $allnewsFactory,
        CustomformRepositoryInterface $allnewsRepository,
        FormFactory $formFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->customFormDataRepository = $customFormDataRepository;
        $this->dataPersistor = $dataPersistor;
        $this->allnewsFactory = $allnewsFactory;
        $this->allnewsRepository = $allnewsRepository;
        $this->formFactory = $formFactory;
        parent::__construct($context);
    }

    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CustomContect_CustomForm::save');
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        

        $data = $this->getRequest()->getPostValue();
              

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
                $isEmailExists = $this->checkEmailExistence($data['email']);

                if ($isEmailExists) {
                    $this->messageManager->addError(__('This email is already in use. Please use a different email.'));
                    $this->_getSession()->setFormData($data);
                    $this->_getSession()->setData('custom_form_data', json_encode($data));
                    return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
                }
    
        if (isset($data['status']) && $data['status'] === 'true') {
            $data['status'] = customfromdata::STATUS_ENABLED;
        }
        if (empty($data['id'])) {
            $data['id'] = null;
        }
        if (isset($data['image']) && is_array($data['image']) && !empty($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        }
        // Convert interests and hobby fields to JSON
        $data['interests'] = isset($data['interests']) ? json_encode($data['interests']) : null;
        $data['hobby'] = isset($data['hobby']) ? json_encode($data['hobby']) : null;

        /** @var \CustomContect\CustomForm\Model\Allnews $model */
        $model = $this->allnewsFactory->create();

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->allnewsRepository->getById($id);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(__('This Employee no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'customform_cfrom_prepare_save',
                ['customform' => $model, 'request' => $this->getRequest()]
            );

            try {
                $this->allnewsRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Employee.'));
                $this->dataPersistor->clear('customform_cfrom');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the news.'));
            }

            $this->dataPersistor->set('customform_cfrom', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }


    protected function checkEmailExistence($email)
    {
        $yourModel = $this->allnewsFactory->create(); // Assuming $allnewsFactory is an instance of \CustomContect\CustomForm\Model\CustomFormDataFactory
        $yourModel->loadByEmail($email);
    
        return $yourModel->getId() && $yourModel->getId() != $this->getRequest()->getParam('id');
    }
    
}
