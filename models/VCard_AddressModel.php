<?php
/**
 * vCard plugin for Craft CMS
 *
 * VCard Address Model
 *
 * @author    nfourtythree
 * @copyright Copyright (c) 2016 nfourtythree
 * @link      http://n43.me
 * @package   VCard
 * @since     1.0.0
 */

namespace Craft;

class VCard_AddressModel extends BaseModel
{
    /**
     * Defines this model's attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'name'     => array(AttributeType::String, 'default' => ''),
            'extended' => array(AttributeType::String, 'default' => ''),
            'street'   => array(AttributeType::String, 'default' => ''),
            'city'     => array(AttributeType::String, 'default' => ''),
            'region'   => array(AttributeType::String, 'default' => ''),
            'zip'      => array(AttributeType::String, 'default' => ''),
            'country'  => array(AttributeType::String, 'default' => ''),
            'type'     => array(AttributeType::String, 'default' => '')
        ));
    }

}