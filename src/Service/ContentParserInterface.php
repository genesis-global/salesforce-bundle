<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\Service;

use GenesisGlobal\Salesforce\SalesforceBundle\Sobject\SobjectInterface;

/**
 * Interface ContentParserInterface
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Service
 */
interface ContentParserInterface
{
    /**
     * @param SobjectInterface $sObject
     * @return array
     */
    public function getContent(SobjectInterface $sObject);
}
