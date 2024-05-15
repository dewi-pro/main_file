<?php

declare(strict_types=1);

namespace Vonage\Conversion;

use Psr\Container\ContainerInterface;
use Vonage\Client\APIResource;
use Vonage\Client\Credentials\Handler\BasicHandler;

/**
 * @todo Finish this Namespace
 */
class ClientFactory
{

    public function __invoke(ContainerInterface $container): Client
    {
        /** @var APIResource $api */
        $api = $container->make(APIResource::class);
        $api->setBaseUri('/conversions/');
        $api->setAuthHandler(new BasicHandler());

        return new Client($api);
    }
}
