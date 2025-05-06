<?php
namespace CustomContect\CustomForm\Api\Data;

interface CustomformInterface
{
	const ID = 'id';
    const NAME = 'name';
    const DATE_OF_BIRTH = 'date_of_birth';
    const BIRTH_PLACE = 'birth_place';
    const MARITAL_STATUS = 'marital_status';
    const EDUCATION = 'education';
    const JOB_TITLE = 'job_title';
    const GRADUATED_SCHOOL = 'graduated_school';
    const CONTACT_NUMBER = 'contact_number';
    const ADDRESS = 'address';
    const EMAIL = 'email';
    const GENDER = 'gender';
    const IMAGE = 'image';
    const INTERESTS = 'interests';
    const HOBBY = 'hobby';
    const EMERGENCY_INFORMATION = 'emergency_information';
    const RELATION = 'relations';
    const EMERGENCY_CONTACT = 'emergency_contact';
    const STATUS = 'status';

	
	public function getId();

	public function getName();

	public function getDate_of_birth();
    
	public function getBirth_Place();

	public function getMarital_Status();

	public function getEducation();

	public function getJob_Title();

	public function getGraduated_School();

	public function getContact_Number();

	public function getAddress();

	public function getEmail();

	public function getGender();

	public function getImage();

	public function getInterests();

	public function getHobby();

	public function getEmergency_Information();

	public function getRelation();

	public function getEmergency_Contact();

	public function getStatus();

	

	public function setId(?int $id);

	public function setName();

	public function setDate_of_birth();
    
	public function setBirth_Place();

	public function setMarital_Status();

	public function setEducation();

	public function setJob_Title();

	public function setGraduated_School();

	public function setContact_Number();

	public function setAddress();

	public function setEmail();

	public function setGender();

	public function setImage();

	public function setInterests();

	public function setHobby();

	public function setEmergency_Information();

	public function setRelation();

	public function setEmergency_Contact();

	
	public function setStatus(?int $status);

	
}
?>
