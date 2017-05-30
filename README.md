# Salesforce-bundle
Symfony bundle for Salesforce REST client which is base on username,password authentication

###Package instalation with composer

```console
$ composer require genesis-global/salesforce-bundle
```


###Enable bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new GenesisGlobal\Salesforce\SalesforceBundle\SalesforceBundle(),
        );

        // ...
    }

    // ...
}
```

###Required configuration:
```
salesforce:
    authentication:
        endpoint: "https://login.salesforce.com/"
        client_id: "id"
        client_secret: "secret"
        username: "name"
        password: "pass",
        security_token: '22s2sd233e3'
    rest:
        version: "v35.0"
        endpoint: "https://yourinstance.salesforce.com"
        
```

###Use in controller:

```
// custom class which implements SobjectInterface
$case = new Sobject();
$case->setName('Case');
$case->setContent(['someField' => 'someValue']);

$this->get('salesforce.service')->create($case);

if ($case->getId()){
    // if sobject has id, it means successfully insert
}
```