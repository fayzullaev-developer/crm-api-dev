<?php

namespace App\DataFixtures;

use App\Component\Company\CompanyFactory;
use App\Component\MediaObject\MediaObjectFactory;
use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Vich\UploaderBundle\Handler\UploadHandler;

class CompanyFixtures extends Fixture
{
    private const COMPANIES = [
        [
            'email' => 'info@meta.com',
            'name' => 'Meta',
            'address' => 'USA, California, Menlo Park',
            'image' => '/images/company/meta.svg',
        ],
        [
            'email' => 'info@google.com',
            'name' => 'Google',
            'address' => 'USA, California, Mountain View, Googleplex',
            'image' => '/images/company/google.svg',
        ],
        [
            'email' => 'info@microsoft.com',
            'name' => 'Microsoft',
            'address' => 'USA, Washington, Redmond, Microsoft campus',
            'image' => '/images/company/microsoft.svg',
        ],
        [
            'email' => 'info@apple.com',
            'name' => 'Apple',
            'address' => 'USA, California, Cupertino, Apple Park',
            'image' => '/images/company/apple.svg',
        ],
        [
            'email' => 'info@amazon.com',
            'name' => 'Amazon',
            'address' => 'USA, Washington, Seattle',
            'image' => '/images/company/amazon.svg',
        ],
        [
            'email' => 'info@epam.com',
            'name' => 'Epam',
            'address' => 'USA, Newtown, Suite 202, 41 University Drive',
            'image' => '/images/company/epam.svg',
        ],
    ];

    public function __construct(
        private readonly UploadHandler $uploadHandler,
        private readonly CompanyFactory $companyFactory,
        private readonly MediaObjectFactory $mediaObjectFactory
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::COMPANIES as $company) {
            $mediaObject = $this->mediaObjectFactory->create(
                $company["image"],
                'image/' . explode(".", $company["image"])[1],
                '/public/static'
            );

            $this->uploadHandler->upload($mediaObject, 'file');

            $manager->persist($mediaObject);

            $company = $this->companyFactory->create(
                $company['email'],
                $company['name'],
                $company['address'],
                $mediaObject,
            );

            $manager->persist($company);
        }

        $manager->flush();
    }
}
