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
        return self::parseToArray($sObject->getContent());
    }

    /**
     * @param $string
     * @return bool
     */
    public static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    public static function parseToArray($data)
    {
        if (is_array($data)) {

            return $data;
        } elseif (is_object($data)) {

            // typecasting here
            return (array)$data;
        } elseif (is_string($data)) {

            // decode json
            if (self::isJson($data)) {
                return json_decode($data, true);
            }
        }
        throw new InvalidContentTypeException();
    }
}
