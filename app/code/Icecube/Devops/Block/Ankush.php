<?php
/**
 * @author Ankush Lodhi
 * @package Icecube_Devops
 */
namespace Icecube\Devops\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Ankush extends Template
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $context->getScopeConfig();
    }

    /**
     * Example method
     *
     * @return string
     */
    public function getWelcomeText()
    {
        return "Hello from Ankush!";
    }
}

