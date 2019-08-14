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
class Tb_Tenbucks_TenbucksController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {

        if (!Mage::helper('tenbucks')->getGtinCode()) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tenbucks')->__('Please configure first your GTIN matching attribute: <a href="%s">configure</a>', Mage::helper("adminhtml")->getUrl('adminhtml/system_config/edit/section/tenbucks')));
        }

        if (!Mage::getStoreConfig('general/store_information/name')) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tenbucks')->__('Please configure first your Store Name : <a href="%s">configure</a>', Mage::helper("adminhtml")->getUrl('adminhtml/system_config/edit/section/general')));
        }

        $this->loadLayout()
                ->_setActiveMenu('tenbucks');
        return $this;
    }

    public function indexAction() {

        $this->_initAction();

        if (Mage::helper('tenbucks')->isInstalled()) {
            $block = $this->getLayout()->createBlock('tenbucks/adminhtml_view');
            $block->setTemplate('tenbucks/view.phtml');
        } else {

            $block = $this->getLayout()->createBlock('tenbucks/adminhtml_register');
            $block->setChild('form', $this->getLayout()->createBlock('tenbucks/adminhtml_register_form'));
        }

        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    public function registerAction() {                

        if ($this->getRequest()->getPost() && Mage::helper('tenbucks')->canSignup()) {
            try {
                $postData = $this->getRequest()->getPost();

                require_once(Mage::getBaseDir('lib') . '/tenbucks/tenbucks_registration_client/src/TenbucksRegistrationClient.php');

                $api_key = Mage::helper('tenbucks/api')->createUser();

                // initialize TenbucksKeysClient library
                $client = new TenbucksRegistrationClient();

                // collect information
                $opts = array(
                    'email' => $postData['email'],
                    'company' => Mage::getStoreConfig('general/store_information/name'),
                    'platform' => 'Magento',
                    'sponsor' => $postData['sponsor'],
                    'locale' => substr(Mage::app()->getLocale()->getLocaleCode(), 0, 2),
                    'country' => Mage::getStoreConfig('general/country/default'),
                    'url' => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB),
                    'gtin' => Mage::helper('tenbucks')->getGtinCode(), // magento special attributes
                    'credentials' => array(
                        'api_key' => $api_key, // secret
                    )
                );

                // send information to tenbucks server (secure with HTTPS)
                $query = $client->send($opts);

                // test if information has been sent successfully
                if (array_key_exists('success', $query) && (bool) $query['success']) {
                    // success
                    Mage::helper('tenbucks')->setisInstalled();
                    // empty api key
                    Mage::helper('tenbucks')->setApiKey();
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('tenbucks')->__('You have successfully signup. Thank you.<br>You will receive your password by email in a few seconds. Please check your inbox.'));
                } else {
                    // Error
                    Mage::helper('tenbucks')->setApiKey($api_key);                    
                    Mage::throwException(print_r($query, TRUE));
                }
            } catch (Exception $e) {
                Mage::log($e->getMessage());
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tenbucks')->__('Error during signup : %s', $e->getMessage()));
                Mage::getSingleton('adminhtml/session')->setRegisterData($this->getRequest()->getPost());
            }
        }

        $this->_redirect('*/*/index');
    }

}
