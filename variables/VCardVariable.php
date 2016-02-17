<?php
/**
 * vCard plugin for Craft CMS
 *
 * vCard Variable
 *
 * @author    nfourtythree
 * @copyright Copyright (c) 2016 nfourtythree
 * @link      http://n43.me
 * @package   VCard
 * @since     1.0.0
 */

namespace Craft;

class VCardVariable
{
    public function link($options = array())
    {
        return craft()->vCard->generateLink($options);
    }

    public function output($options = array())
    {
        return craft()->vCard->generateOutput($options);
    }
}