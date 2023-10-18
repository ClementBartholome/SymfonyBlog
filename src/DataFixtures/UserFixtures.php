<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Clément');
        $user->setPassword('$2y$13$5b.VSWmuv3FDzE2FMQ043.nbdUp3dToIQNFVkKjp.OCa2KPbuk2tS');
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('Admin');
        $admin->setPassword('$2y$13$187ssE2oujqe4NFuujab7e9C82.9DULtxFtvMXfnk5MRMjXrJ/JTO');
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();
    }
}
