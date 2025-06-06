<?php

namespace Icecube\AttributeManager\Ui\Component\Listing\Grid\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;

/**
 * Class AllnewsActions
 */
class Action extends Column
{
    /** Url path */
    const ATTRIBUTE_URL_PATH_EDIT = 'attribute_manager/attribute/edit';
    const ATTRIBUTE_URL_PATH_DELETE = 'attribute_manager/attribute/delete';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::ATTRIBUTE_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['attribute_id'])) {
                    $title = $this->getEscaper()->escapeHtml($item['attribute_label']);
    
                    $item['actions'] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                $this->editUrl, 
                                ['attribute_id' => $item['attribute_id']]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::ATTRIBUTE_URL_PATH_DELETE,
                                ['attribute_id' => $item['attribute_id']]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete %1', $title),
                                'message' => __('Are you sure you want to delete this record?')
                            ]
                        ]
                    ];
                }
            }
        }
    
        return $dataSource;
    }
    
    /**
     * Get instance of escaper
     * @return Escaper
     * @deprecated 101.0.7
     */
    private function getEscaper()
    {
        if (!$this->escaper) {
            $this->escaper = ObjectManager::getInstance()->get(Escaper::class);
        }
        return $this->escaper;
    }
}

?>