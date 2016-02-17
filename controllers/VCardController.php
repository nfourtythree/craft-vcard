<?php
/**
 * vCard plugin for Craft CMS
 *
 * VCard Controller
 *
 * @author    nfourtythree
 * @copyright Copyright (c) 2016 nfourtythree
 * @link      http://n43.me
 * @package   VCard
 * @since     1.0.0
 */

namespace Craft;

class VCardController extends BaseController
{

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     * @access protected
     */
    protected $allowAnonymous = array('actionIndex',
        );

    /**
     * Handle a request going to our plugin's index action URL, e.g.: actions/vCard
     */
    public function actionIndex($vcard = "")
    {
        $options = craft()->vCard->decodeUrlParam($vcard);

        craft()->vCard->generateVcard($options);
    }
}