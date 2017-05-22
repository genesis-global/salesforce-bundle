# Salesforce-bundle
Symfony bundle for Salesforce REST client which is base on username,password authentication


Required configuration:
```
salesforce_api:
    authentication:
        endpoint: 'https://login.salesforce.com/'
        client_id: 'id'
        client_secret:'secret'
        username: 'name'
        password: 'pass'
    
    rest:
        version:'v35.0'
        endpoint: 'https://yourinstance.salesforce.com'
        
```

Use in controller:

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