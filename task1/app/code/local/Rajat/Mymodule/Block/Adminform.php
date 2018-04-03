<?php

class Rajat_Mymodule_Block_Adminform extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        
        return parent::_prepareLayout();
    }
    public function getAdminform()
    {
        
        if (!$this->hasData('adminform')) {
            $this->setData('adminform', Mage::registry('adminform'));
        }

        return $this->getData('adminform');
    }

    public function checkPage(){
        
        $status = 0;
        $page = $this->getRequest()->getControllerName();
        
        if($page != ''){
            $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
            $sql        = "SELECT script FROM `adminform` WHERE `status`='".$page."' ORDER BY id DESC LIMIT 1";
            $rows       = $connection->fetchAll($sql);

            if(count($rows) > 0){
                    $html = '<script>'.$rows[0]['script'].'</script>';
                    return $html;
            }
        }
    }
}
