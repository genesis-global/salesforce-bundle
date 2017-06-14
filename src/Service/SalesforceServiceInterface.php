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
     * @return SobjectInterface
     */
    public function create(SobjectInterface $sObject);

    /**
     * @param SobjectInterface $sObject
     * @param $externalIdName
     * @param $externalIdValue
     * @return SobjectInterface
     */
    public function upsert(SobjectInterface $sObject, $externalIdName, $externalIdValue);

    /**
     * @param $name
     * @param $id
     * @param fields
     * @return SobjectInterface
     */
    public function getBySobjectId($name, $id, $fields);

    /**
     * @param $name
     * @param $externalIdName
     * @param $externalIdValue
     * @param $fields
     * @return SobjectInterface
     */
    public function getByExternalId($name, $externalIdName, $externalIdValue, $fields);
}