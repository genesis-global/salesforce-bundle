<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Class SalesforceExtension
 * @package GenesisGlobal\Salesforce\SalesforceBundle\DependencyInjection
 */
class SalesforceExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Authentication
        $container->setParameter('salesforce.authentication.endpoint', $config['authentication']['endpoint']);
        $container->setParameter('salesforce.authentication.client_id', $config['authentication']['client_id']);
        $container->setParameter('salesforce.authentication.client_secret', $config['authentication']['client_secret']);
        $container->setParameter('salesforce.authentication.username', $config['authentication']['username']);
        $container->setParameter('salesforce.authentication.password', $config['authentication']['password']);

        // Rest
        $container->setParameter('salesforce.rest.endpoint', $config['rest']['endpoint']);
        $container->setParameter('salesforce.rest.version', $config['rest']['version']);
    }
}