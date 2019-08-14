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
class Tb_Tenbucks_Helper_Api extends Mage_Core_Helper_Abstract {

    public function createUser() {

        if (Mage::helper('tenbucks')->getApiKey()) {
            // if api key already generated.
            return Mage::helper('tenbucks')->getApiKey();
        } else {

            // generate API Key randomly
            $api_key = Mage::helper('core')->getHash(Mage::helper('core')->getRandomString($length = 7));

            // set API role
            $api_role = Mage::getModel('api/roles')
                    ->setName('Tenbucks API')
                    ->setPid(false)
                    ->setRoleType('G')
                    ->save();

            Mage::getModel('api/rules')
                    ->setRoleId($api_role->getId())
                    ->setResources(array('all'))
                    ->saveRel();

            // create API user
            $api_user = Mage::getModel('api/user');

            $api_user->setData(array(
                'username' => 'tenbucks',
                'firstname' => 'tenbucks',
                'lastname' => 'tenbucks',
                'email' => 'hello@tenbucks.io',
                'is_active' => 1,
                'user_roles' => '',
                'assigned_user_role' => '',
                'role_name' => '',
                'roles' => array($api_role->getId())
            ));

            $api_user->setApiKey($api_key);

            $api_user->save()->load($api_user->getId());

            $api_user->setRoleIds(array($api_role->getId()))
                    ->setRoleUserId($api_user->getUserId())
                    ->saveRelations();

            return $api_key;
        }
    }   

}
