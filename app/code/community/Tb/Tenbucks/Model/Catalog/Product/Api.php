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
class Tb_Tenbucks_Model_Catalog_Product_Api extends Mage_Catalog_Model_Product_Api {

    /**
     * Retrieve list of products with basic info (id, sku, type, set, name)
     * assigned to at list one category
     *
     * @param null|object|array $filters
     * @param string|int $store
     * @return array
     */
    public function itemsInCategory($filters = null, $store = null) {
        $collection = Mage::getModel('catalog/product')->getCollection()
                ->addStoreFilter($this->_getStoreId($store))
                ->addAttributeToSelect('name');

        /** @var $apiHelper Mage_Api_Helper_Data */
        $apiHelper = Mage::helper('api');
        $filters = $apiHelper->parseFilters($filters, $this->_filtersMap);
        try {
            foreach ($filters as $field => $value) {
                $collection->addFieldToFilter($field, $value);
            }
        } catch (Mage_Core_Exception $e) {
            $this->_fault('filters_invalid', $e->getMessage());
        }
        $result = array();
        foreach ($collection as $product) {
            if (!empty($product->getCategoryIds())) {
                $result[] = array(
                    'product_id' => $product->getId(),
                    'sku' => $product->getSku(),
                    'name' => $product->getName(),
                    'set' => $product->getAttributeSetId(),
                    'type' => $product->getTypeId(),
                    'category_ids' => $product->getCategoryIds(),
                    'website_ids' => $product->getWebsiteIds()
                );
            }
        }
        return $result;
    }

}
