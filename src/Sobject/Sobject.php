<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 14.06.2017
 * Time: 11:38
 */

namespace GenesisGlobal\Salesforce\SalesforceBundle\Sobject;


/**
 * Class Sobject
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Sobject
 */
class Sobject implements SobjectInterface
{
    /** @var  string */
    protected $name;

    /** @var  string */
    protected $id;

    /** @var  mixed */
    protected $content;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}