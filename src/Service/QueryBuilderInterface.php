<?php
/**
 * Created by PhpStorm.
 * User: coderaf
 */

namespace GenesisGlobal\Salesforce\SalesforceBundle\Service;


/**
 * Class QueryBuilder
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Service
 */
interface QueryBuilderInterface
{
    /**
     * @param $fields
     * @param $from
     * @param null $conditions
     * @return string
     */
    public function build($fields, $from, $conditions = null);
}