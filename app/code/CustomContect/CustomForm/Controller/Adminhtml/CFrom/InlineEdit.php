<?php
namespace CustomContect\CustomForm\Controller\Adminhtml\CFrom;

use Magento\Backend\App\Action\Context;
use CustomContect\CustomForm\Api\CustomformRepositoryInterface as CustomformRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use CustomContect\CustomForm\Api\Data\CustomformInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    protected $allnewsRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    public function __construct(
        Context $context,
        CustomformRepository $allnewsRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->allnewsRepository = $allnewsRepository;
        $this->jsonFactory = $jsonFactory;
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
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $Id) {
            $news = $this->allnewsRepository->getById($Id);
            try {
                $newsData = $postItems[$Id];
                $extendedNewsData = $news->getData();
                $this->setNewsData($news, $extendedNewsData, $newsData);
                $this->allnewsRepository->save($news);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithNewsId($news, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithNewsId($news, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithNewsId(
                    $news,
                    __('Something went wrong while saving the news.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    protected function getErrorWithNewsId(CustomformInterface $news, $errorText)
    {
        return '[ID: ' . $news->getId() . '] ' . $errorText;
    }

    public function setNewsData(\CustomContect\CustomForm\Model\CustomFormData $news, array $extendedNewsData, array $newsData)
    {
        $news->setData(array_merge($news->getData(), $extendedNewsData, $newsData));
        return $this;
    }
}
?>
