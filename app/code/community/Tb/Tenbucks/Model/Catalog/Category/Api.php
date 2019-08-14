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

class Tb_Tenbucks_Model_Catalog_Category_Api extends Mage_Catalog_Model_Category_Api
{
    
    /**
     * Retrieve list of assigned products to category
     *
     * @param int $categoryId
     * @param string|int $store
     * @return array
     */
    public function assignedProducts($categoryId, $store = null)
    {
        $category = $this->_initCategory($categoryId);

        $storeId = $this->_getStoreId($store);
        $collection = $category->setStoreId($storeId)->getProductCollection()
                ->addAttributeToSelect('name');
        ($storeId == 0)? $collection->addOrder('position', 'asc') : $collection->setOrder('position', 'asc');;

        $result = array();

        foreach ($collection as $product) {            
            
            $result[] = array(
                'product_id' => $product->getId(),
                'type'       => $product->getTypeId(),
                'set'        => $product->getAttributeSetId(),
                'sku'        => $product->getSku(),
                'name'       => $product->getName(),
                'position'   => $product->getCatIndexPosition()
            );
        }

        return $result;
    }
}