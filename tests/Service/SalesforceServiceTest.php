<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 16.08.2017
 * Time: 12:02
 */

use \GenesisGlobal\Salesforce\SalesforceBundle\Service\SalesforceService;
use \GenesisGlobal\Salesforce\Client\SalesforceClientInterface;
use \GenesisGlobal\Salesforce\SalesforceBundle\Service\ContentParserInterface;
use \GenesisGlobal\Salesforce\SalesforceBundle\Service\QueryBuilderInterface;

class SalesforceServiceTest extends \PHPUnit\Framework\TestCase
{
    protected $client;

    protected $parser;

    protected $builder;

    public function setUp()
    {
        $this->client = $this->createMock(SalesforceClientInterface::class);
        $this->parser = $this->createMock(ContentParserInterface::class);
        $this->builder = $this->createMock(QueryBuilderInterface::class);
    }

    public function testGetPickListForSobjectAndField()
    {
        // some picks to picklists
        $pick1 = new stdClass();
        $pick1->active = true;
        $pick1->value = 'Something';

        $pick2 = new stdClass();
        $pick2->active = true;
        $pick2->value = 'Another';

        $pick3 = new stdClass();
        $pick3->active = true;
        $pick3->value = 'One more';

        $pick4 = new stdClass();
        $pick4->active = true;
        $pick4->value = 'And even More';

        $pick5 = new stdClass();
        $pick5->active = false;
        $pick5->value = 'I should not be here';

        // some fields
        $type = new stdClass();
        $type->name = 'Type';
        $type->picklistValues = [$pick1, $pick2];

        $subType = new stdClass();
        $subType->name = 'Sub_Type__c';
        $subType->picklistValues = [$pick3, $pick4];

        $iOwner= new stdClass();
        $iOwner->name = 'Internal_Owner__c';
        $iOwner->picklistValues = [$pick1, $pick5];

        $extra = new stdClass();
        $extra->name = 'Extra_field__c';

        // content of response contains fields
        $content = new stdClass();
        $content->fields = [$type, $subType, $iOwner, $extra];

        // salesforce client response
        $result = new \GenesisGlobal\Salesforce\Http\Response\Response();
        $result->setSuccess(true);
        $result->setContent($content);

        $this->client->method('get')->willReturn($result);
        $service = new SalesforceService($this->client, $this->parser, $this->builder);
        $result = $service->getPickListForSobjectAndField('Case', ['Type', 'Sub_Type__c', 'Internal_Owner__c']);

        $this->assertEquals([
            'Type' => [
                'Something',
                'Another'
            ],
            'Sub_Type__c' => [
                'One more',
                'And even More'
            ],
            'Internal_Owner__c' => [
                'Something'
            ]
        ], $result);
    }
}