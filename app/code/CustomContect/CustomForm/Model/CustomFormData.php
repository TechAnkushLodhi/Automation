<?php
namespace CustomContect\CustomForm\Model;

use CustomContect\CustomForm\Api\Data\CustomformInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class CustomFormData extends AbstractModel implements CustomformInterface, IdentityInterface
{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'registration_form';
     
    //Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;

    protected function _construct()
    {
        $this->_init(\CustomContect\CustomForm\Model\ResourceModel\CustomFormData::class);
    }


    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }



   

    
    public function getId()
	{
		return parent::getData(self::ID);
	}

	public function getName()
	{
		return parent::getData(self::NAME);
	}

	public function getDate_of_birth()
	{
		return parent::getData(self::DATE_OF_BIRTH);
	}
    
    public function getBirth_Place()
	{
		return parent::getData(self::BIRTH_PLACE);
	}

    public function getMarital_Status()
	{
		return parent::getData(self::MARITAL_STATUS);
	}

    public function getEducation()
	{
		return parent::getData(self::EDUCATION);
	}

    public function getJob_Title()
	{
		return parent::getData(self::JOB_TITLE);
	}

    public function getGraduated_School()
	{
		return parent::getData(self::GRADUATED_SCHOOL);
	}

    public function getContact_Number()
	{
		return parent::getData(self::CONTACT_NUMBER);
	}

    public function getAddress()
	{
		return parent::getData(self::ADDRESS);
	}

    public function getEmail()
	{
		return parent::getData(self::EMAIL);
	}
    
    public function getGender()
	{
		return parent::getData(self::GENDER);
	}
    

    public function getImage()
	{
		return parent::getData(self::IMAGE);
	}

    public function getInterests()
	{
		return parent::getData(self::INTERESTS);
	}

    public function getHobby()
	{
		return parent::getData(self::HOBBY);
	}
    public function getEmergency_Information()
	{
		return parent::getData(self::EMEERGENCY_INFORMATION);
	}
    public function getRelation()
	{
		return parent::getData(self::RELATION);
	}
    public function getEmergency_Contact()
	{
		return parent::getData(self::EMERGENCY_CONTACT);
	}

	public function getStatus()
	{
		return parent::getData(self::STATUS);
	}

	

	public function setId($id)
{
    return $this->setData(self::ID, $id);
}
  
	public function setName()
	{
		return $this->setData(self::NAME, $name);
	}

	public function setDate_of_birth()
	{
		return $this->setData(self::DATE_OF_BIRTH, $date_of_birth);
	}
    
    public function setBirth_Place()
	{
		return $this->setData(self::BIRTH_PLACE, $birth_place);
	}

    public function setMarital_Status()
	{
		return $this->setData(self::MARITAL_STATUS, $marital_status);
	}

    public function setEducation()
	{
		return $this->setData(self::EDUCATION ,$education);
	}

    public function setJob_Title()
	{
		return $this->setData(self::JOB_TITLE, $job_title);
	}

    public function setGraduated_School()
	{
		return $this->setData(self::GRADUATED_SCHOOL, $graduated_school);
	}

    public function setContact_Number()
	{
		return $this->setData(self::CONTACT_NUMBER, $contact_number);
	}

    public function setAddress()
	{
		return $this->setData(self::ADDRESS, $address);
	}

    public function setEmail()
	{
		return $this->setData(self::EMAIL, $email);
	}
    public function setGender()
	{
		return $this->setData(self::GENDER, $email);
	}


    public function setImage()
	{
		return $this->setData(self::IMAGE, $image);
	}

    public function setInterests()
	{
		return $this->setData(self::INTERESTS, $interests);
	}

    public function setHobby()
	{
		return $this->setData(self::HOBBY, $hobby);
	}
    public function setEmergency_Information()
	{
		return $this->setData(self::EMERGENCY_INFORMATION, $emergency_information );
	}
    public function setRelation()
	{
		return $this->setData(self::RELATION, $relation);
	}
    public function setEmergency_Contact()
	{
		return $this->setData(self::EMERGENCY_CONTACT, $emergency_contact);
	}

    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
	

   /**
     * Load by email
     *
     * @param string $email
     * @return $this
     */
    public function loadByEmail($email)
    {
        $this->_getResource()->loadByEmail($this, $email);
        return $this;
    }
	
}
