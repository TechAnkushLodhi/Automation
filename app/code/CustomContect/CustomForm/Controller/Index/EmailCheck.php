<?php
// File: CustomContect/CustomForm/Controller/Index/EmailCheck.php
namespace CustomContect\CustomForm\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use CustomContect\CustomForm\Model\ResourceModel\CustomFormData\CollectionFactory;

class EmailCheck extends Action
{
    protected $resultJsonFactory;
    protected $customformdataCollectionFactory;
    protected $collection;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CollectionFactory $customformdataCollectionFactory,
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->collection = $customformdataCollectionFactory->create();
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
    
        // Get the POST data from the request
        $postData = $this->getRequest()->getPost();

            if(isset($postData['id'])){
                
                if($postData['id']=="new"){


                    $fieldvalue = isset($postData['fieldvalue']) ? $postData['fieldvalue'] : null;
                    $fieldname = isset($postData['fieldname']) ? $postData['fieldname'] : null;

        
                    if ($fieldvalue) {
                        $this->collection->addFieldToFilter($fieldname, $fieldvalue);
                
                        // Check if email exists in the database
                        if ($this->collection->getSize() > 0) {
                            // Email is not unique, send 'error' status
                            return $result->setData(['status' => 'error']);
                        } else {
                            // Email is unique, send 'success' status
                            return $result->setData(['status' => 'success']);
                        }
                    }
                
                    // Invalid or empty email, you may handle this case as needed
                    return $result->setData(['status' => 'error']);
                }else{

                   // POST data se ID aur email nikale
                        $id = isset($postData['id']) ? $postData['id'] : null;
                        $fieldvalue = isset($postData['fieldvalue']) ? $postData['fieldvalue'] : null;
                        $fieldname = isset($postData['fieldname']) ? $postData['fieldname'] : null;
                        // Agar email set hai
                        if ($fieldvalue) {
                            // Collection ko email ke basis par filter karein
                            $this->collection->addFieldToFilter($fieldname, $fieldvalue);

                            // Check karne ke liye ki kya email database mein hai
                            // Agar ID bhi set hai, toh us record ko exclude karein
                            if ($id) {
                                $this->collection->addFieldToFilter('id', ['neq' => $id]);
                            }

                            // Agar email database mein hai
                            if ($this->collection->getSize() > 0) {
                                // Email unique nahi hai, 'error' status return karein
                                return $result->setData(['status' => 'error']);
                            } else {
                                // Email unique hai, 'success' status return karein
                                return $result->setData(['status' => 'success']);
                            }
                        }

                        // Invalid ya empty email, aap is case ko apne jarurat ke hisab se handle kar sakte hain
                        return $result->setData(['status' => 'error']);


                }
            }


    }
    
}


