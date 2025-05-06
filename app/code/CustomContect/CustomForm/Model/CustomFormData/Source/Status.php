<?php

namespace CustomContect\CustomForm\Model\CustomFormData\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $customform;

    public function __construct(\CustomContect\CustomForm\Model\CustomFormData $customform)
    {
        $this->customform = $customform;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->customform->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
?>
