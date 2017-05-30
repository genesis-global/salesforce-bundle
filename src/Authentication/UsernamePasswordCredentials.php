<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\Authentication;

use GenesisGlobal\Salesforce\Authentication\CredentialsKeeperInterface;

/**
 * Class UsernamePasswordCredentials
 * @package GenesisGlobal\Salesforce\SalesforceBundle\Authentication
 */
class UsernamePasswordCredentials implements CredentialsKeeperInterface
{
    /**
     * @var array
     */
    protected $credentials;

    /**
     * UsernamePasswordCredentials constructor.
     * @param $username
     * @param $password
     * @param $clientId
     * @param $clientSecret
     * @param $securityToken
     */
    public function __construct($username, $password, $clientId, $clientSecret, $securityToken)
    {
        $this->credentials = [
            'username' => $username,
            'password' => $password,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'security_token' => $securityToken
        ];
    }

    /**
     * @return array
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
}