<?php
/**
 * Copyright © Icecube Digital All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);
namespace Icecube\EavManager\Block\Adminhtml\EavManager\Edit;


use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class ResetButton
 */
class ResetButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];
    }
}
?>
