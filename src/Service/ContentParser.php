<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\Service;


use GenesisGlobal\Salesforce\SalesforceBundle\Exception\InvalidContentTypeException;
use GenesisGlobal\Salesforce\SalesforceBundle\Sobject\SobjectInterface;

/**
 * Class ContentParser
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Service
 */
class ContentParser implements ContentParserInterface
{

    /**
     * @param SobjectInterface $sObject
     * @return array|mixed
     */
    public function getContent(SobjectInterface $sObject)
    {
        return $this->toArray($sObject);
    }

    /**
     * @param SobjectInterface $sObject
     * @return array|mixed
     * @throws InvalidContentTypeException
     */
    protected function toArray(SobjectInterface $sObject)
    {
        if (is_array($sObject->getContent())) {

            return $sObject->getContent();
        } elseif (is_object($sObject->getContent())) {

            //
            return (array)$sObject->getContent();
        } elseif (is_string($sObject->getContent())) {

            // decode json
            if ($this->isJson($sObject->getContent())) {
                return json_decode($sObject->getContent(), true);
            }

        }
        throw new InvalidContentTypeException();
    }

    /**
     * @param $string
     * @return bool
     */
    protected function isJson($string)
    {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }
}
