<?php

namespace App\DataFixtures;

use App\Component\Client\ClientFactory;
use App\Component\MediaObject\MediaObjectFactory;
use App\Repository\CompanyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Vich\UploaderBundle\Handler\UploadHandler;

class ClientFixtures extends Fixture implements DependentFixtureInterface
{
    private const CLIENTS = [
        [
            'email' => 'judith.williams@gmail.com',
            'givenName' => 'Judith Williams',
            'company_id' => 1,
            'image' => '/images/client/judith_williams.png',
        ],
        [
            'email' => 'john.smith@gmail.com',
            'givenName' => 'John Smith',
            'company_id' => 4,
            'image' => '/images/client/john_smith.png',
        ],
        [
            'email' => 'franz.ferdiand@gmail.com',
            'givenName' => 'Franz Ferdiand',
            'company_id' => 3,
            'image' => '/images/client/franz_ferdiand.png',
        ],
        [
            'email' => 'martin.merces@gmail.com',
            'givenName' => 'Martin Merces',
            'company_id' => 2,
            'image' => '/images/client/martin_merces.png',
        ],
        [
            'email' => 'dermot.jones@gmail.com',
            'givenName' => 'Dermot Jones',
            'company_id' => 6,
            'image' => '/images/client/dermot_jones.png',
        ],
        [
            'email' => 'jane.doe@gmail.com',
            'givenName' => 'Jane Doe',
            'company_id' => 5,
            'image' => '/images/client/jane_doe.png',
        ],
        [
            'email' => 'rebecca.moore@gmail.com',
            'givenName' => 'Rebecca Moore',
            'company_id' => 3,
            'image' => '/images/client/rebecca_moore.png',
        ],
        [
            'email' => 'george.fields@gmail.com',
            'givenName' => 'George Fields',
            'company_id' => 5,
            'image' => '/images/client/george_fields.png',
        ],
        [
            'email' => 'nicci.troiani@gmail.com',
            'givenName' => 'Nicci Troiani',
            'company_id' => 4,
            'image' => '/images/client/nicci_troiani.png',
        ],
        [
            'email' => 'lindsey.stroud@gmail.com',
            'givenName' => 'Lindsey Stroud',
            'company_id' => 2,
            'image' => '/images/client/lindsey_stroud.png',
        ],
        [
            'email' => 'ameliya.cer@gmail.com',
            'givenName' => 'Ameliya',
            'company_id' => 1,
            'image' => '/images/client/ameliya_cer.png',
        ],
    ];

    public function __construct(
        private readonly UploadHandler $uploadHandler,
        private readonly MediaObjectFactory $mediaObjectFactory,
        private readonly CompanyRepository $companyRepository,
        private readonly ClientFactory $clientFactory,
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::CLIENTS as $client) {
            $company = $this->companyRepository->find($client['company_id']);

            $mediaObject = $this->mediaObjectFactory->create(
                $client["image"],
                'image/' . explode(".", $client["image"])[1],
                '/public/static'
            );

            $this->uploadHandler->upload($mediaObject, 'file');

            $manager->persist($mediaObject);

            $newClient = $this->clientFactory->create(
                $client['email'],
                $client['givenName'],
                $company,
                $mediaObject,
            );

            $manager->persist($newClient);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CompanyFixtures::class];
    }
}
