# Domo Provider for OAuth 2.0 Client
[![Latest Version](https://img.shields.io/github/release/compwright/oauth2-domo.svg?style=flat-square)](https://github.com/compwright/oauth2-domo/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/compwright/oauth2-domo/master.svg?style=flat-square)](https://travis-ci.org/compwright/oauth2-domo)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/compwright/oauth2-domo.svg?style=flat-square)](https://scrutinizer-ci.com/g/compwright/oauth2-domo/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/compwright/oauth2-domo.svg?style=flat-square)](https://scrutinizer-ci.com/g/compwright/oauth2-domo)
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
$provider = new \Compwright\OAuth2\Domo\DomoProvider([
    'clientId'          => '{domo-client-id}',
    'clientSecret'      => '{domo-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

// Try to get an access token (using the authorization code grant)
$token = $provider->getAccessToken('client_credentials');

// We got an access token, let's now get the user's details
$user = $provider->getResourceOwner($token);

// Use these details to create a new profile
printf('Hello %s!', $user->getNickname());

// Use this to interact with an API on the users behalf
echo $token->getToken();
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
