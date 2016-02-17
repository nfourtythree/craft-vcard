<?php
/**
 * vCard plugin for Craft CMS
 *
 * VCard Model
 *
 * @author    nfourtythree
 * @copyright Copyright (c) 2016 nfourtythree
 * @link      http://n43.me
 * @package   VCard
 * @since     1.0.0
 */

namespace Craft;

class VCardModel extends BaseModel
{
    /**
     * Defines this model's attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'firstName'   => array(AttributeType::String, 'default' => '', 'required' => true),
            'lastName'    => array(AttributeType::String, 'default' => ''),
            'additional'  => array(AttributeType::String, 'default' => ''),
            'prefix'      => array(AttributeType::String, 'default' => ''),
            'suffix'      => array(AttributeType::String, 'default' => ''),
            'company'     => array(AttributeType::String, 'default' => ''),
            'jobTitle'    => array(AttributeType::String, 'default' => ''),
            'email'       => array(AttributeType::Mixed, 'default' => ''),
            'url'         => array(AttributeType::Mixed, 'default' => ''),
            'address'     => array(AttributeType::Mixed, 'default' => ''),
            'phoneNumber' => array(AttributeType::Mixed, 'default' => ''),
            'birthday'    => array(AttributeType::String, 'default' => ''),
            'note'        => array(AttributeType::String, 'default' => ''),
            'photo'       => array(AttributeType::String, 'default' => ''),
        ));
    }
}