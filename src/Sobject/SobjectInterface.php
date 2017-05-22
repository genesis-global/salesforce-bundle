<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\Sobject;

/**
 * Interface SobjectInterface
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Sobject
 */
/**
 * Interface SobjectInterface
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Sobject
 */
interface SobjectInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * id setter
     * @param string $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getContent();

    /**
     * content setter
     * @param array $content
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function getName();

    /**
     * name of resource setter
     * @param string $name
     */
    public function setName($name);

    /**
     * @return array
     */
    public function toArray();
}
