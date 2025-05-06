<?php
namespace CustomContect\CustomForm\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomFormData extends AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('registration_form', 'id');
    }


    /**
     * Load object by email
     *
     * @param \CustomContect\CustomForm\Model\CustomFormData $object
     * @param string $email
     * @return $this
     */
    public function loadByEmail(\CustomContect\CustomForm\Model\CustomFormData $object, $email)
    {
        $connection = $this->getConnection();
        $bind = [':email' => $email];
        $select = $this->getConnection()->select()->from(
            $this->getMainTable()
        )->where(
            'email = :email'
        );
        $data = $connection->fetchRow($select, $bind);
        if ($data) {
            $object->setData($data);
        }
        return $this;
    }
}
