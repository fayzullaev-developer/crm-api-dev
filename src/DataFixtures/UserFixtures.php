<?php

namespace App\DataFixtures;

use App\Component\MediaObject\MediaObjectFactory;
use App\Component\User\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Vich\UploaderBundle\Handler\UploadHandler;

class UserFixtures extends Fixture
{
    private const USERS = [
        [
            'email' => 'ameliya.cer@gmail.com',
            'password' => '12345678',
            'givenName' => 'Ameliya',
            'image' => '/images/user/ameliya_cer.png',
        ],
        [
            'email' => 'lindsey.stroud@gmail.com',
            'password' => '12345678',
            'givenName' => 'Lindsey Stroud',
            'image' => '/images/user/lindsey_stroud.png',
        ],
        [
            'email' => 'nicci.troiani@gmail.com',
            'password' => '12345678',
            'givenName' => 'Nicci Troiani',
            'image' => '/images/user/nicci_troiani.png',
        ],
        [
            'email' => 'george.fields@gmail.com',
            'password' => '12345678',
            'givenName' => 'George Fields',
            'image' => '/images/user/george_fields.png',
        ],
        [
            'email' => 'rebecca.moore@gmail.com',
            'password' => '12345678',
            'givenName' => 'Rebecca Moore',
            'image' => '/images/user/rebecca_moore.png',
        ],
        [
            'email' => 'jane.doe@gmail.com',
            'password' => '12345678',
            'givenName' => 'Jane Doe',
            'image' => '/images/user/jane_doe.png',
        ],
        [
            'email' => 'dermot.jones@gmail.com',
            'password' => '12345678',
            'givenName' => 'Dermot Jones',
            'image' => '/images/user/dermot_jones.png',
        ],
        [
            'email' => 'martin.merces@gmail.com',
            'password' => '12345678',
            'givenName' => 'Martin Merces',
            'image' => '/images/user/martin_merces.png',
        ],
        [
            'email' => 'franz.ferdiand@gmail.com',
            'password' => '12345678',
            'givenName' => 'Franz Ferdiand',
            'image' => '/images/user/franz_ferdiand.png',
        ],
        [
            'email' => 'john.smith@gmail.com',
            'password' => '12345678',
            'givenName' => 'John Smith',
            'image' => '/images/user/john_smith.png',
        ],
        [
            'email' => 'judith.williams@gmail.com',
            'password' => '12345678',
            'givenName' => 'Judith Williams',
            'image' => '/images/user/judith_williams.png',
        ]
    ];

    public function __construct(
        private readonly UploadHandler $uploadHandler,
        private readonly MediaObjectFactory $mediaObjectFactory,
        private readonly UserFactory $userFactory
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $user) {
            $mediaObject = $this->mediaObjectFactory->create(
                $user["image"],
                'image/' . explode(".", $user["image"])[1],
                '/public/static'
            );

            $this->uploadHandler->upload($mediaObject, 'file');

            $manager->persist($mediaObject);

            $newUser = $this->userFactory->create(
                $user['email'],
                $user['password'],
                $user['givenName'],
                $mediaObject,
            );

            $manager->persist($newUser);
        }

        $manager->flush();
    }
}
