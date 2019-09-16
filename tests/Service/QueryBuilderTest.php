<?php
/**
 * Created by PhpStorm.
 * User: coderaf
 */

namespace GenesisGlobal\Salesforce\SalesforceBundle\Tests;

use GenesisGlobal\Salesforce\SalesforceBundle\Service\QueryBuilder;

class QueryBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testBuildWithSimpleConditions()
    {
        $build = new QueryBuilder();

        $query = $build->build(['Some_field', 'Other_field'], 'Case', [
            'Other_field' => 'dupa'
        ]);

        $this->assertEquals("SELECT+Some_field,Other_field+from+Case+where+Other_field+=+'dupa'", $query);
    }

    public function testBuildWithExtraOperatorConditions()
    {
        $build = new QueryBuilder();

        $query = $build->build(['Some_field', 'Other_field'], 'Case', [
            "Other_field != 'dupa'"
        ]);

        $this->assertEquals("SELECT+Some_field,Other_field+from+Case+where+Other_field+!=+'dupa'", $query);
    }
}