<?php

class Rajat_Mymodule_Block_Adminhtml_Adminform_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'adminform_form',
            array(
                'legend'=>Mage::helper('adminform')->__('Page Script')
            )
        );

        $fieldset->addField(
            'page',
            'select',
            array(
                'label' => Mage::helper('adminform')->__('Page'),
                'name' => 'status',
                'values' => array(
                    array(
                        'value' => 'index',
                        'label' => Mage::helper('adminform')->__('Home'),
                    ),

                    array(
                        'value' => 'product',
                        'label' => Mage::helper('adminform')->__('Product'),
                    ),
                ),
            )
        );

        $fieldset->addField( 
            'script',
            'textarea',
            array(
                'label' => Mage::helper('adminform')->__('Script'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'script',
            )
        );

        if (Mage::getSingleton('adminhtml/session')->getAdminformData()) {
            $form->setValues(
                Mage::getSingleton('adminhtml/session')->getAdminformData()
            );
            Mage::getSingleton('adminhtml/session')->setAdminformData(null);
        }
        elseif (Mage::registry('adminform_data')) {
            $form->setValues(
                Mage::registry('adminform_data')->getData()
            );
        }

        return parent::_prepareForm();
    }
}
