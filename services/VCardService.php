<?php
/**
 * vCard plugin for Craft CMS
 *
 * VCard Service
 *
 * @author    nfourtythree
 * @copyright Copyright (c) 2016 nfourtythree
 * @link      http://n43.me
 * @package   VCard
 * @since     1.0.0
 */

namespace Craft;

require_once(CRAFT_PLUGINS_PATH.'vcard/vendor/autoload.php');

use JeroenDesloovere\VCard\VCard;

class VCardService extends BaseApplicationComponent
{
    public function generateLink($options = array())
    {
        if ($this->_validateOptions($options)) {
            $encodedOptions = $this->encodeUrlParam($options);
            return  UrlHelper::getActionUrl('vCard', array('vcard' => $encodedOptions));
        }
    }

    public function generateOutput($options = array())
    {
        return $this->generateVcard($options, "output");
    }

    public function generateVcard($options = array(), $action = "download")
    {
        if ($this->_validateOptions($options)) {

            if (isset($options['address'])) {
                $options['address'] = $this->_populateAddressModel($options['address']);
            }

            if (isset($options['phoneNumber'])) {
                $options['phoneNumber'] = $this->_populatePhoneNumberModel($options['phoneNumber']);
            }

            if (isset($options['email'])) {
                $options['email'] = $this->_populateEmailModel($options['email']);
            }

            if (isset($options['url'])) {
                $options['url'] = $this->_populateUrlModel($options['url']);
            }

            $vcard = VCardModel::populateModel($options);

            if ($vcard->validate()) {

                $vcardData = $this->_createVcardData($vcard);

                switch ($action) {
                    case 'output':
                        return $vcardData->getOutput();
                        break;
                    case 'download':
                    default:
                        $vcardData->download();
                        break;
                }

            } else {

                foreach ($vcard->getErrors() as $key => $error) {
                    throw new Exception(Craft::t($error));
                }

            }

        }
    }

    private function _validateoptions($options)
    {
        if (empty($options)) {

            throw new Exception(Craft::t('vCard Parameters must be supplied'));

        }

        return true;
    }

    private function _populateAddressModel($address)
    {
        if (is_array($address)) {
            // check to see if we are dealing with multiple addresses
            if (count($address) == count($address, COUNT_RECURSIVE)) {
                return array(VCard_AddressModel::populateModel($address));
            } else {
                return VCard_AddressModel::populateModels($address);
            }
        } else {
            return "";
        }
    }

    private function _populatePhoneNumberModel($phoneNumber)
    {
        if (is_array($phoneNumber) or (is_string($phoneNumber) and $phoneNumber)) {

            $phoneNumber = $this->_createArrayFromString("number", $phoneNumber);
            // check to see if we are dealing with multiple phoneNumbers
            if (count($phoneNumber) == count($phoneNumber, COUNT_RECURSIVE)) {
                return array(VCard_PhoneNumberModel::populateModel($phoneNumber));
            } else {
                foreach ($phoneNumber as $key => $row) {
                    $phoneNumber[$key] = $this->_createArrayFromString("number", $row);
                }
                return VCard_PhoneNumberModel::populateModels($phoneNumber);
            }
        } else {
            return "";
        }
    }

    private function _createArrayFromString($key, $value)
    {
        if (is_string($value)) {
            return array($key => $value);
        }
        // only switch if it is a string
        return $value;
    }

    private function _populateEmailModel($email)
    {
        if (is_array($email) or (is_string($email) and $email)) {

            $email = $this->_createArrayFromString("address", $email);
            // check to see if we are dealing with multiple emails
            if (count($email) == count($email, COUNT_RECURSIVE)) {
                return array(VCard_EmailModel::populateModel($email));
            } else {
                foreach ($email as $key => $row) {
                    $email[$key] = $this->_createArrayFromString("address", $row);
                }
                return VCard_EmailModel::populateModels($email);
            }
        } else {
            return "";
        }
    }

    private function _populateUrlModel($url)
    {
        if (is_array($url) or (is_string($url) and $url)) {

            $url = $this->_createArrayFromString("address", $url);
            // check to see if we are dealing with multiple emails
            if (count($url) == count($url, COUNT_RECURSIVE)) {
                return array(VCard_UrlModel::populateModel($url));
            } else {
                foreach ($url as $key => $row) {
                    $url[$key] = $this->_createArrayFromString("address", $row);
                }
                return VCard_UrlModel::populateModels($url);
            }

        } else {
            return "";
        }
    }

    private function _createVcardData(VCardModel $vcardModel)
    {
        $vcard = new VCard();

        $vcard->addName($vcardModel->lastName, $vcardModel->firstName, $vcardModel->additional, $vcardModel->prefix, $vcardModel->suffix);

        if ($vcardModel->company) {
            $vcard->addCompany($vcardModel->company);
        }

        if ($vcardModel->jobTitle) {
            $vcard->addJobtitle($vcardModel->jobTitle);
        }

        if ($vcardModel->url and is_array($vcardModel->url)) {
            foreach ($vcardModel->url as $url) {
                if ($url instanceof VCard_UrlModel) {
                    if ($url->validate()) {
                        $vcard->addUrl(
                            $url->address,
                            $url->type
                        );
                    }
                }
            }
        }

        if ($vcardModel->address and is_array($vcardModel->address)) {
            foreach ($vcardModel->address as $address) {
                if ($address instanceof VCard_AddressModel) {
                    if ($address->validate()) {
                        $vcard->addAddress(
                                $address->name,
                                $address->extended,
                                $address->street,
                                $address->city,
                                $address->region,
                                $address->zip,
                                $address->country,
                                $address->type
                        );
                    }
                }
            }
        }

        if ($vcardModel->phoneNumber and is_array($vcardModel->phoneNumber)) {
            foreach ($vcardModel->phoneNumber as $phoneNumber) {
                if ($phoneNumber instanceof VCard_PhoneNumberModel) {
                    if ($phoneNumber->validate()) {
                        $vcard->addPhoneNumber(
                            $phoneNumber->number,
                            $phoneNumber->type
                        );
                    }
                }
            }
        }

        if ($vcardModel->email and is_array($vcardModel->email)) {
            foreach ($vcardModel->email as $email) {
                if ($email instanceof VCard_EmailModel) {
                    if ($email->validate()) {
                        $vcard->addEmail(
                            $email->address,
                            $email->type
                        );
                    }
                }
            }
        }

        if ($vcardModel->photo) {
            $vcard->addPhoto($vcardModel->photo);
        }

        if ($vcardModel->note) {
            $vcard->addNote($vcardModel->note);
        }

        return $vcard;
    }

    public function encodeUrlParam($options = array())
    {
        $optionsString = serialize($options);

        $url = $this->encrypt($optionsString);

        return $url;
    }

    public function decodeUrlParam($optionsString = "")
    {
        $optionsString = $this->decrypt($optionsString);

        $options = unserialize($optionsString);

        return $options;
    }

    protected function encrypt($string)
    {
        $key = craft()->plugins->getPlugin("vCard")->getSettings()->salt;
        return rtrim(strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key)))), '+/', '-_'), '=');
    }

    public function decrypt($string)
    {
        $key = craft()->plugins->getPlugin("vCard")->getSettings()->salt;
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(str_pad(strtr($string, '-_', '+/'), strlen($string) % 4, '=', STR_PAD_RIGHT)), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    }

}