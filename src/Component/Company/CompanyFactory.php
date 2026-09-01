<?php

declare(strict_types=1);

namespace App\Component\Company;

use App\Entity\Company;
use App\Entity\MediaObject;
use DateTimeZone;
use Symfony\Component\Clock\DatePoint;

class CompanyFactory
{
    public function create(
        string $email,
        string $name,
        string $address,
        MediaObject $mediaObject,
    ): Company
    {
        $company = new Company();

        $company->setEmail($email);
        $company->setName($name);
        $company->setAddress($address);
        $company->setCreatedAt(new DatePoint(timezone: new DateTimeZone('Asia/Tashkent')));
        $company->setImage($mediaObject);

        return $company;
    }
}
