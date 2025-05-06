<?php
namespace CustomContect\CustomForm\Api;



interface CustomformRepositoryInterface
{
	public function save(\CustomContect\CustomForm\Api\Data\CustomformInterface $formdata);

    public function getById($Id);

    public function delete(\CustomContect\CustomForm\Api\Data\CustomformInterface $formdata);

    public function deleteById($Id);

    
}
?>
