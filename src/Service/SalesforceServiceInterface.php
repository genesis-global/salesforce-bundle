<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\Service;

use GenesisGlobal\Salesforce\Http\Response\Response;
use GenesisGlobal\Salesforce\SalesforceBundle\Sobject\SobjectInterface;

/**
 * Interface SalesforceServiceInterface
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Service
 */
interface SalesforceServiceInterface
{
    /**
     * @param SobjectInterface $sObject
     * @return Response
     */
    public function create(SobjectInterface $sObject);

    /**
     * @param SobjectInterface $sObject
     * @param $externalIdName
     * @param $externalIdValue
     * @return Response
     */
    public function upsert(SobjectInterface $sObject, $externalIdName, $externalIdValue);

    /**
     * @param $sobjectName
     * @param $sObjectId
     * @param $fields
     * @return Response
     */
    public function update($sobjectName, $sObjectId, $fields);

    /**
     * @param $name
     * @param $id
     * @param fields
     * @return Response
     */
    public function getBySobjectId($name, $id, $fields);

    /**
     * @param $name
     * @param $externalIdName
     * @param $externalIdValue
     * @param $fields
     * @return Response
     */
    public function getByExternalId($name, $externalIdName, $externalIdValue, $fields);

    /**
     * @param $sobjectName
     * @return Response
     */
    public function getMetaDataForSobject($sobjectName);

    /**
     * @param $sobjectName
     * @param $fieldNames
     * @return array
     */
    public function getPickListForSobjectAndField($sobjectName, $fieldNames);
}