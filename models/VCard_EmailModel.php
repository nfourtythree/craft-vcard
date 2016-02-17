<?php
/**
 * vCard plugin for Craft CMS
 *
 * VCard Email Model
 *
 * @author    nfourtythree
 * @copyright Copyright (c) 2016 nfourtythree
 * @link      http://n43.me
 * @package   VCard
 * @since     1.0.0
 */

namespace Craft;

class VCard_EmailModel extends BaseModel
{
    /**
     * Defines this model's attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'address' => array(AttributeType::String, 'default' => ''),
            'type'   => array(AttributeType::String, 'default' => ''),
        ));
    }

}