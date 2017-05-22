<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\Service;

use GenesisGlobal\Salesforce\SalesforceBundle\Sobject\SobjectInterface;

/**
 * Interface SalesforceServiceInterface
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Service
 */
interface SalesforceServiceInterface
{
    /**
     * @param SobjectInterface $sObject
     */
    public function create(SobjectInterface $sObject);
}