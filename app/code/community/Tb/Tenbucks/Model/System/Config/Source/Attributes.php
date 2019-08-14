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


class Tb_Tenbucks_Model_System_Config_Source_Attributes {

        
    /**
     * Convert to Admin System Dropdow Array
     *
     * @return array
     */
    public function toOptionArray() {
        
        $attributes = $this->getExternalAttributes();
        array_unshift($attributes, array("value" => "", "label" => Mage::helper('tenbucks')->__("Select attribute to map")));
        
        return $attributes;
    }
    
    /**
     * Retrieve accessible external product attributes
     *
     * @return array
     */
    public function getExternalAttributes()
    {
    	$productAttributes = array();
    	if(file_exists(Mage::getModuleDir(null,'Mage_Catalog') ."Model/Resource/Eav/Mysql4/Product/Attribute/Collection"))
        	$productAttributes  = Mage::getResourceModel('catalog/product_attribute_collection')->load();
        else
        {
        	
	        $entityTypeId = Mage::getSingleton('eav/config')->getEntityType('catalog_product')->getId();
	        $productAttributes = Mage::getResourceModel('eav/entity_attribute_collection')
	            ->setEntityTypeFilter($entityTypeId)
	            ->load();
        }
        
        $attributes = array();

        foreach ($productAttributes as $attr) {
            $code = $attr->getAttributeCode();
            if ($attr->getFrontendInput() == 'hidden') {
                continue;
            }
            $attributes[$code] = $code;
        }


        return $attributes;
    }

}
