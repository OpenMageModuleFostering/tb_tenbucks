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
class Tb_Tenbucks_Model_Catalog_Product_Attribute_Api extends Mage_Catalog_Model_Product_Attribute_Api {

    /**
     * Retrieve attributes list
     *
     * @param int $setId
     * @return array
     */
    public function items($setId = null) {
        $attributes = Mage::getModel('catalog/product')->getResource()
                ->loadAllAttributes()
                ->getSortedAttributes($setId);
        $result = array();

        foreach ($attributes as $attribute) {             
            /* @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
            if ($attribute->getId() && $this->_isAllowedAttribute($attribute)) {   
                if ($attribute->isInSet($setId) || $setId == null) {                   
                    if (!$attribute->getId() || $attribute->isScopeGlobal()) {
                        $scope = 'global';
                    } elseif ($attribute->isScopeWebsite()) {
                        $scope = 'website';
                    } else {
                        $scope = 'store';
                    }

                    $result[] = array(
                        'attribute_id' => $attribute->getId(),
                        'code' => $attribute->getAttributeCode(),
                        'type' => $attribute->getFrontendInput(),
                        'required' => $attribute->getIsRequired(),
                        'scope' => $scope
                    );
                }
            }
        }

        return $result;
    }

}
