<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\Creator;


use GenesisGlobal\Salesforce\SalesforceBundle\Service\ContentParser;
use GenesisGlobal\Salesforce\SalesforceBundle\Sobject\Sobject;

/**
 * Class SobjectCreator
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Creator
 */
class SobjectCreator implements SobjectCreatorInterface
{
    /**
     * @param $name
     * @param $data
     * @return mixed
     */
    public function create($name, $data)
    {
        $sobject = new Sobject();
        $sobject->setName($name);
        if ($data) {
            $sobject->setContent(ContentParser::parseToArray($data));
        }
        if ($sobject->getContent() && isset($sobject->getContent()['Id'])) {
            $sobject->setId($sobject->getContent()['Id']);
        }
        return $sobject;
    }
}