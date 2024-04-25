<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {

    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('siracuse.harichandra@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword($user, 'azed'))
            ->setName('Harichandra')
            ->setFirstname('SIRACUSE')
            ->setVerified(true);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('toto.@gmail.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->hasher->hashPassword($user2, 'toto'))
            ->setName('toto')
            ->setFirstname('toto')
            ->setVerified(true);
        $manager->persist($user2);

        $manager->flush();
    }
}
