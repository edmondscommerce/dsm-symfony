# dsm-symfony

## By [Edmonds Commerce](https://www.edmondscommerce.co.uk)
A symfony bundle that facilitates using [Doctrine Static Meta](https://github.com/edmondscommerce/doctrine-static-meta) 

## _THIS IS NOT PRODUCTION READY_


### Install

First you need to add the following to your `composer.json`:

```json
{
    "require": {
        "edmondscommerce/dsm-symfony": "dev-master"
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/edmondscommerce/dsm-symfony"
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

### Regenerating Entities in Existing Project

In order to avoid autowiring issues it is advised that you comment out any services in `config/services.yaml`
that reference your project code. For example:

```yaml
#    # makes classes in src/ available to be used as services
#    # this creates a service per class whose id is the fully-qualified class name
#    App\:
#        resource: '../src/*'
#        exclude: '../src/{Entities,Entity,Migrations,Tests,Kernel.php}'
```
This should only be needed when regenerating entities that are referenced elsewhere in the code. Once the generation is complete then these lines should be uncommented again. See [Issue 3](https://github.com/edmondscommerce/dsm-api-platform/issues/3) for more details

### Configuration

This will add the Symfony doctrine configuration to DSM. This is handled in the [Container](./DsmBundle/DependencyInjection/Container.php) file where we remove the DMS Entity Manager Factory and replace it with our [own](./DsmBundle/Doctrine/Common/EntityManagerFactory.php)
