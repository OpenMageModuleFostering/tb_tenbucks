<?php

/**
 * Tenbucks
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hello@tenbucks.io so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Tenbucks to newer
 * versions in the future.
 *
 * @category   Tenbucks
 * @package    Tb_Tenbucks
 * @copyright  Copyright (c) 2016 Tenbucks. (https://www.tenbucks.io)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Tenbucks <hello@tenbucks.io>
 */
class Tb_Tenbucks_Block_Adminhtml_Register_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        
         $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/register'),
            'method' => 'post',
         ));

        $form->setUseContainer(true);                        
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('edit_form', array('legend' => Mage::helper('tenbucks')->__('Please fill up details')));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('tenbucks')->__('Email'),
            'name' => 'email',
            'class' => 'validate-email',
            'required' => true,
            'value' => Mage::getStoreConfig('trans_email/ident_general/email'),
            'after_element_html' => '<p class="note"><span>'.Mage::helper('tenbucks')->__('Your password will be sent to this email so it must be valid. If you already have an account with us, this shop will be added to your account.').'</span></p>',            
        ));
        
        $fieldset->addField('email-confirm', 'text', array(
            'label' => Mage::helper('tenbucks')->__('Email Confirm'),
            'name' => 'email-confirm' ,
            'class' => 'validate-email',
            'required' => true,            
        ));
        
        $fieldset->addField('sponsor', 'text', array(
            'label' => Mage::helper('tenbucks')->__('Sponsor Email'),
            'name' => 'sponsor' ,
            'class' => 'require-valid  validate-email',            
        ));


        if ( Mage::registry('register_data') ) {
            $form->setValues(Mage::registry('register_data')->getData());
        } 
        return parent::_prepareForm();
    }

}
