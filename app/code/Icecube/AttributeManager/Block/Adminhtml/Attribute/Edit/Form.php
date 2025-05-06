<?php
namespace Icecube\AttributeManager\Block\Adminhtml\Attribute\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Icecube\AttributeManager\Model\Status $options,
        array $data = []
    ) 
    {
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form', 
                            'enctype' => 'multipart/form-data', 
                            'action' => $this->getData('action'), 
                            'method' => 'post'
                        ]
            ]
        );

        $form->setHtmlIdPrefix('attribute_');
        if ($model->getEntityId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Attribute Details'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Attribute Details'), 'class' => 'fieldset-wide']
            );
        }
        // $fieldset->addField(
        //     'is_active',
        //     'select',
        //     [
        //         'name' => 'is_active',
        //         'label' => __('Status'),
        //         'id' => 'is_active',
        //         'title' => __('Status'),
        //         'values' => $this->_options->getOptionArray(),
        //         'class' => 'status',
        //         'required' => true,
        //     ]
        // );
        $fieldset->addField(
            'attribute_code',
            'text',
            [
                'name' => 'attribute_code',
                'label' => __('Attribute Code'),
                'id' => 'attribute_code',
                'title' => __('Attribute Code'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        $fieldset->addField(
            'attribute_label',
            'text',
            [
                'name' => 'attribute_label',
                'label' => __('Attribute Label'),
                'id' => 'attribute_label',
                'title' => __('Attribute Label'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'attribute_type',
            'select',
            [
                'name' => 'attribute_type',
                'label' => __('Attribute Type'),
                'id' => 'attribute_type',
                'title' => __('Attribute Type'),
                'class' => 'required-entry',
                'required' => true,
                'values' => [
                    ['value' => 'customer', 'label' => __('Customer')],
                    ['value' => 'customer_address', 'label' => __('Customer Address')],
                    ['value' => 'catalog_product', 'label' => __('Catalog Product')],
                    ['value' => 'catalog_category', 'label' => __('Catalog Category')],
                    ['value' => 'quote', 'label' => __('Quote')],
                    ['value' => 'order', 'label' => __('Order')],
                ]
            ]
        );
        // $fieldset->addField(
        //     'backend_type',
        //     'select',
        //     [
        //         'name' => 'backend_type',
        //         'label' => __('Backend Type'),
        //         'id' => 'backend_type',
        //         'title' => __('Backend Type'),
        //         'class' => 'required-entry',
        //         'required' => true,
        //         'values' => [
        //             ['value' => 'varchar', 'label' => __('Varchar (Small Text)')],
        //             ['value' => 'text', 'label' => __('Text (Large Text)')],
        //             ['value' => 'int', 'label' => __('Integer (Numbers)')],
        //             ['value' => 'decimal', 'label' => __('Decimal (Price, Weight)')],
        //             ['value' => 'datetime', 'label' => __('DateTime')],
        //             ['value' => 'boolean', 'label' => __('Boolean (Yes/No)')],
        //         ]
        //     ]
        // );
        
        
        $fieldset->addField(
            'is_required',
            'select',
            [
                'name' => 'is_required',
                'label' => __('Is Required'),
                'id' => 'is_required',
                'title' => __('Is Required'),
                'values' => [
                    ['value' => 1, 'label' => __('Yes')],
                    ['value' => 0, 'label' => __('No')]
                ],
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'is_visible',
            'select',
            [
                'name' => 'is_visible',
                'label' => __('Is Visible'),
                'id' => 'is_visible',
                'title' => __('Is Visible'),
                'values' => [
                    ['value' => 1, 'label' => __('Yes')],
                    ['value' => 0, 'label' => __('No')]
                ],
                'class' => 'required-entry',
                'required' => true,
            ]
        );
        

       

        // $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

        // $fieldset->addField(
        //     'content',
        //     'editor',
        //     [
        //         'name' => 'content',
        //         'label' => __('Content'),
        //         'style' => 'height:36em;',
        //         'required' => true,
        //         'config' => $wysiwygConfig
        //     ]
        // );

        // $fieldset->addField(
        //     'publish_date',
        //     'date',
        //     [
        //         'name' => 'publish_date',
        //         'label' => __('Publish Date'),
        //         'date_format' => $dateFormat,
        //         'time_format' => 'HH:mm:ss',
        //         'class' => 'validate-date validate-date-range date-range-custom_theme-from',
        //         'class' => 'required-entry',
        //         'style' => 'width:200px',
        //     ]
        // );
        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}