<?php
namespace CustomContect\CustomForm\Model\CustomFormData\Source;

use Magento\Framework\Option\ArrayInterface;

class GenderOptions implements ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'male', 'label' => __('Male')],
            ['value' => 'female', 'label' => __('Female')],
            ['value' => 'transgender', 'label' => __('Transgender')],
        ];
    }
}
