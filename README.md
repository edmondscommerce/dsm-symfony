# dsm-api-platform

## By [Edmonds Commerce](https://www.edmondscommerce.co.uk)
A symfony bundle that facilitates using [Doctrine Static Meta](https://github.com/edmondscommerce/doctrine-static-meta) with [API Platform](https://api-platform.com/)

### Install

First you need to add the following to your `composer.json`:

```json
{
    "require": {
        "edmondscommerce/dsm-api-platform": "dev-master"
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/edmondscommerce/dsm-api-platform.git"
        }
    ]
}
```

Then you need to register the bundle by adding the following to `config/bundles.php`:

```php
return [
    EdmondsCommerce\DsmApiPlatformBundle\DsmApiPlatformBundle::class => ['all' => true]
];
```

You should now see the DSM commands when you run `./bin/console`:

```bash
./bin/console
# ...
 dsm
  dsm:generate:entity                     Generate an Entity
  dsm:generate:field                      Generate a field
  dsm:generate:relations                  Generate relations traits for your entities. Optionally filter down the list of entities to generate relationship traits for
  dsm:set:field                           Set an Entity as having a Field
  dsm:set:relation 
# ...
```