<?php
namespace Icecube\AttributeManager\Api\Data;

interface CustomerAttributeInterface
{
    const ATTRIBUTE_ID = 'attribute_id';
    const ATTRIBUTE_CODE = 'attribute_code';
    const FRONTEND_LABEL = 'frontend_label';
    const IS_REQUIRED = 'is_required';

    public function getAttributeId();
    public function setAttributeId($attributeId);

    public function getAttributeCode();
    public function setAttributeCode($attributeCode);

    public function getFrontendLabel();
    public function setFrontendLabel($frontendLabel);

    public function getIsRequired();
    public function setIsRequired($isRequired);
}
