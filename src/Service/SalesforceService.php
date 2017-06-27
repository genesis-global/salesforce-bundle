<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\Service;


use GenesisGlobal\Salesforce\Client\SalesforceClientInterface;
use GenesisGlobal\Salesforce\SalesforceBundle\Creator\SobjectCreatorInterface;
use GenesisGlobal\Salesforce\SalesforceBundle\Exception\CreateSobjectException;
use GenesisGlobal\Salesforce\SalesforceBundle\Exception\UpdateSobjectException;
use GenesisGlobal\Salesforce\SalesforceBundle\Sobject\SobjectInterface;

/**
 * Class SalesforceService
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Service
 */
class SalesforceService implements SalesforceServiceInterface
{
    /**
     * constant for sobjects resources
     */
    const SOBJECTS_ACTION = 'sobjects';

    /**
     * @var SalesforceClientInterface
     */
    protected $client;

    /**
     * @var ContentParserInterface
     */
    protected $contentParser;

    /**
     * @var SobjectCreatorInterface
     */
    protected $sobjectCreator;

    /**
     * SalesforceService constructor.
     * @param SalesforceClientInterface $salesforceClient
     * @param ContentParserInterface $contentParser
     * @param SobjectCreatorInterface $sobjectCreator
     */
    public function __construct(
        SalesforceClientInterface $salesforceClient,
        ContentParserInterface $contentParser,
        SobjectCreatorInterface $sobjectCreator
    )
    {
        $this->client = $salesforceClient;
        $this->contentParser = $contentParser;
        $this->sobjectCreator = $sobjectCreator;
    }

    /**
     * @param $name
     * @param $externalIdName
     * @param $externalIdValue
     * @param $fields
     * @return SobjectInterface
     */
    public function getByExternalId($name, $externalIdName, $externalIdValue, $fields)
    {
        $params = [ $externalIdName, $externalIdValue ] + [ 'fields' => $fields ];
        $result = $this->client->get(
            $this->createAction($name, $params)
        );
        $sobject = $this->sobjectCreator->create($name, $result);
        return $sobject;
    }

    /**
     * @param $name
     * @param $id
     * @param $fields
     * @return SobjectInterface
     */
    public function getBySobjectId($name, $id, $fields)
    {
        $params = [ $id ] + [ 'fields' => $fields ];
        $result = $this->client->get(
            $this->createAction($name, $params)
        );
        $sobject = $this->sobjectCreator->create($name, $result);
        return $sobject;
    }

    /**
     * @param SobjectInterface $sObject
     * @return SobjectInterface
     */
    public function create(SobjectInterface $sObject)
    {
        $response = $this->client->post(
            $this->createAction($sObject->getName()),
            $this->contentParser->getContent($sObject)
        );

        if (isset($response->body->id)) {
            $sObject->setId($response->body->id);
        }
        return $sObject;
    }

    /**
     * @param $sobjectName
     * @param $sObjectId
     * @param $fields
     * @throws UpdateSobjectException
     */
    public function update($sobjectName, $sObjectId, $fields)
    {
        $response = $this->client->patch(
            $this->createAction($sobjectName, [ $sObjectId ]),
            $this->contentParser->getContent($fields)
        );
        if (isset($response->body) && isset($response->body->errorCode)) {
            throw new UpdateSobjectException($response->body->messsage);
        }
    }

    /**
     * @param SobjectInterface $sObject
     * @param $customIdName
     * @param $customIdValue
     * @return SobjectInterface
     */
    public function upsert(SobjectInterface $sObject, $customIdName, $customIdValue)
    {
        $response = $this->client->patch(
            $this->createAction($sObject->getName(), [ $customIdName, $customIdValue ]),
            $this->contentParser->getContent($sObject)
        );
        if (isset($response->body->id)) {
            $sObject->setId($response->body->id);
        }
        return $sObject;
    }

    /**
     * @param $sobjectName
     * @param $params
     * @return string
     * @throws CreateSobjectException
     */
    protected function createAction($sobjectName, $params = null)
    {
        $uri = '';
        if (!$sobjectName) {
            throw new CreateSobjectException();
        }
        $uri .= self::SOBJECTS_ACTION . '/' . $sobjectName;
        $querySeparator = '?';
        if (is_array($params)) {
            foreach ($params as $k => $v) {

                # if numeric just put it after slash
                if (is_numeric($k)) {
                    $uri .= '/' . $v;
                }
                # if string, use more fun logic
                else {

                    # if value is array, implode values by comas
                    if (is_array($v)) {
                        $uri .= $querySeparator . $k . '=' . implode(',', $v);
                    }else {
                        $uri .= $querySeparator . $k . '=' . $v;
                    }
                    $querySeparator = '&';
                }
            }
        }
        return $uri;
    }

}
