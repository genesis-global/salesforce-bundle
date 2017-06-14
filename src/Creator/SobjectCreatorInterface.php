<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 14.06.2017
 * Time: 11:45
 */

namespace GenesisGlobal\Salesforce\SalesforceBundle\Creator;


use GenesisGlobal\Salesforce\SalesforceBundle\Sobject\SobjectInterface;


/**
 * Interface SobjectCreatorInterface
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Creator
 */
interface SobjectCreatorInterface
{
    /**
     * @param $name
     * @param $data
     * @return SobjectInterface
     */
    public function create($name, $data);
}