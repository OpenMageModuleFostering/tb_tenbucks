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
class Tb_Tenbucks_Block_Adminhtml_View extends Mage_Adminhtml_Block_Widget_Container {    
    
    public function __construct() {

        $this->_controller = 'adminhtml_tenbucks';
        $this->_blockGroup = 'tenbucks';
        $this->_headerText = Mage::helper('tenbucks')->__('My Applications');
        $this->_addButton('standalone', array(
            'label' => Mage::helper('tenbucks')->__('Standalone Mode'),
            'onclick' => "window.open('".$this->getIframeUrl(true)."')",
            'class' => 'add-widget'
        ));
        parent::__construct();
    }
    
    public function getIframeUrl($standalone = false) {
        
        $params['url'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        $params['platform'] = 'Magento';
        $params['cms_version'] = (string)Mage::getVersion();
        $params['module_version'] = Mage::helper('tenbucks')->getModuleVersion();                
        
        $redirect = $this->getRequest()->getParam('redirect');
        
        switch($redirect) {            
            case 'account':
                $params['redirect'] = 'account';
                break;
            
            default :
                $params['redirect'] = 'apps';
                break;
        }
        
        if ($standalone) {
            $params['standalone'] = 1;
        } else {
            $params['standalone'] = 0;
        }
        
        return Mage::helper('tenbucks')->getApiUrl('dispatch').'?'.http_build_query($params);
    }
    
    

}
