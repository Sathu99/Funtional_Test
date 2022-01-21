<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
       $user = new User();
       $user->setName('Sathu');
       $user->setEmail('test@gmail.com');
       $user->setPassword('ZX!@zx12');

       $manager->persist($user);
       $manager->flush();

        $manager->flush();
    }
}
