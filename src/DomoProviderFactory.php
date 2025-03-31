<?php

namespace Compwright\OAuth2\Domo;

use League\OAuth2\Client\OptionProvider\HttpBasicAuthOptionProvider;

class DomoProviderFactory
{
    public function new(string $clientId, string $clientSecret): DomoProvider
    {
        $provider = new DomoProvider([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'accessTokenMethod' => 'GET',
            'accessTokenResourceOwnerId' => 'userId',
            'urlAuthorize' => '',
            'urlAccessToken' => 'https://api.domo.com/oauth/token',
            'urlResourceOwnerDetails' => 'https://api.domo.com/v1/users/',
            'scopes' => [
                'account',
                'audit',
                'buzz',
                'data',
                'dashboard',
                'user',
                'workflow',
            ],
        ]);
        $provider->setOptionProvider(new HttpBasicAuthOptionProvider());
        return $provider;
    }
}
