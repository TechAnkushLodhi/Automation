<?php
namespace CustomContect\CustomForm\Model\CustomFormData\Source;

use Magento\Framework\Option\ArrayInterface;

class HobbyOptions implements ArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'reading', 'label' => __('Reading')],
            ['value' => 'cooking', 'label' => __('Cooking')],
            ['value' => 'gaming', 'label' => __('Gaming')],
            ['value' => 'singing', 'label' => __('Singing')],
        ];
    }
}
