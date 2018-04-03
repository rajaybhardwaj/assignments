<?php

class Rajat_Mymodule_Model_Status extends Varien_Object 
{
    const STATUS_HOME = 'index';
    const STATUS_PRODUCT = 'product';

    static public function getOptionArray()
    {
        return array(
            self::STATUS_HOME    => Mage::helper('adminform')->__('Home'),
            self::STATUS_PRODUCT   => Mage::helper('adminform')->__('Product')
        );
    }
}
