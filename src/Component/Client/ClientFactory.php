<?php

declare(strict_types=1);

namespace App\Component\Client;

use App\Entity\Client;
use App\Entity\Company;
use App\Entity\MediaObject;
use DateTimeZone;
use Symfony\Component\Clock\DatePoint;

class ClientFactory
{
    public function create(
        string $email,
        string $givenName,
        Company $company,
        MediaObject $mediaObject,
    ): Client
    {
        $client = new Client();

        $client->setEmail($email);
        $client->setGivenName($givenName);
        $client->setCreatedAt(new DatePoint(timezone: new DateTimeZone('Asia/Tashkent')));
        $client->setCompany($company);
        $client->setImage($mediaObject);

        return $client;
    }
}
