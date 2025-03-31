# Domo Provider for OAuth 2.0 Client

[![Latest Version](https://img.shields.io/github/release/compwright/oauth2-domo.svg?style=flat-square)](https://github.com/compwright/oauth2-domo/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/compwright/oauth2-domo.svg?style=flat-square)](https://packagist.org/packages/compwright/oauth2-domo)

This package provides Domo OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require compwright/oauth2-domo
```

## Usage

Usage is the same as The League's OAuth client, using `\Compwright\OAuth2\Domo\DomoProvider` as the provider.

### Client Credentials Code Flow

```php
$domoProviderFactory = new DomoProviderFactory();

$provider = $domoProviderFactory->new(
    clientId: 'your_client_id',
    clientSecret: 'your_client_secret',
);

$token = $provider->getAccessToken('client_credentials', [
    'scope' => ['data', 'user'],
]);

echo $token->getToken() . PHP_EOL;

// requires 'user' scope
$user = $provider->getResourceOwner($token);

echo $user->getId() . PHP_EOL;
echo $user->getName() . PHP_EOL;
echo $user->getEmail() . PHP_EOL;
```

## Testing

``` bash
$ make test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/compwright/oauth2-domo/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Jonathon Hill](https://github.com/compwright)
- [All Contributors](https://github.com/compwright/oauth2-domo/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/compwright/oauth2-domo/blob/master/LICENSE) for more information.
