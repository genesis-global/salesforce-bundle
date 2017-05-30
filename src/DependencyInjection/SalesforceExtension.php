<?php

namespace GenesisGlobal\Salesforce\SalesforceBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class SalesforceExtension
 * @package GenesisGlobal\Salesforce\SalesforceBundle\DependencyInjection
 */
class SalesforceExtension extends Extension
{
    /**
     * @return string
     */
    public function getAlias()
    {
        return 'salesforce';
    }

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
        $container->setParameter('salesforce.authentication.security_token', $config['authentication']['security_token']);

        // Rest
        $container->setParameter('salesforce.rest.endpoint', $config['rest']['endpoint']);
        $container->setParameter('salesforce.rest.version', $config['rest']['version']);

        // load services for bundle
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');
    }
}