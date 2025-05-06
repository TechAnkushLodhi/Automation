<?php
namespace CustomContect\CustomForm\Block\Adminhtml\CustomFormData\Edit;

use Magento\Backend\Block\Widget\Context;
use CustomContect\CustomForm\Api\CustomformRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
   
    protected $customformdataRepository;
    
    public function __construct(
        Context $context,
        CustomformRepositoryInterface $customformdataRepository
    ) {
        $this->context = $context;
        $this->customformdataRepository = $customformdataRepository;
    }

    public function getId()
    {
        try {
            return $this->customformdataRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
?>
