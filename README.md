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