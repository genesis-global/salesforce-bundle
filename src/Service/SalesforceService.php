<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\Service;


use GenesisGlobal\Salesforce\Client\SalesforceClientInterface;
use GenesisGlobal\Salesforce\SalesforceBundle\Creator\SobjectCreatorInterface;
use GenesisGlobal\Salesforce\SalesforceBundle\Exception\CreateSobjectException;
use GenesisGlobal\Salesforce\SalesforceBundle\Sobject\SobjectInterface;
use GenesisGlobal\Salesforce\Http\Response\Response;

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
     * @param $fields
     * @param $from
     * @param null $conditions should be array of conditions [field => value] which parse to where+field='value'
     * @return Response
     */
    public function query($fields, $from, $conditions = null)
    {
        $format = "SELECT+%s+from+%s";
        $query = sprintf($format, implode(',', $fields), $from);

        // add conditions
        if (is_array($conditions) && !empty($conditions)) {
            $where = "+where+%s";
            $query = $query . sprintf($where, implode('+and+', $conditions));
        }
        return $this->client->get('query', $query);
    }

    /**
     * @param $name
     * @param $externalIdName
     * @param $externalIdValue
     * @param $fields
     * @return Response
     */
    public function getByExternalId($name, $externalIdName, $externalIdValue, $fields)
    {
        $params = [ $externalIdName, $externalIdValue ] + [ 'fields' => $fields ];
        $response = $this->client->get(
            $this->createAction($name, $params)
        );
        return $response;
    }

    /**
     * @param $name
     * @param $id
     * @param $fields
     * @return Response
     */
    public function getBySobjectId($name, $id, $fields)
    {
        $params = [ $id ] + [ 'fields' => $fields ];
        $response = $this->client->get(
            $this->createAction($name, $params)
        );
        return $response;
    }

    /**
     * @param SobjectInterface $sObject
     * @return Response
     */
    public function create(SobjectInterface $sObject)
    {
        $response = $this->client->post(
            $this->createAction($sObject->getName()),
            $this->contentParser->getContent($sObject)
        );
        return $response;
    }

    /**
     * @param $sobjectName
     * @param $sObjectId
     * @param $fields
     * @return Response
     */
    public function update($sobjectName, $sObjectId, $fields)
    {
        $response = $this->client->patch(
            $this->createAction($sobjectName, [ $sObjectId ]),
            $fields
        );
        return $response;
    }

    /**
     * @param SobjectInterface $sObject
     * @param $customIdName
     * @param $customIdValue
     * @return Response
     */
    public function upsert(SobjectInterface $sObject, $customIdName, $customIdValue)
    {
        $response = $this->client->patch(
            $this->createAction($sObject->getName(), [ $customIdName, $customIdValue ]),
            $this->contentParser->getContent($sObject)
        );
        return $response;
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
