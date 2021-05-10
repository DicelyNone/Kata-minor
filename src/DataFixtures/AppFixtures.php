<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        //"{\"0\":[null, null, null, null, 0, 0, null, null, 0, null], \"1\":[null, null, null, null, 0, 0, null, null, 0, null],\"2\":[null, null, null, null, 0, 0, null, null, 0, null],\"3\":[null, null, null, null, 0, 0, null, null, 0, null],\"4\":[null, null, null, null, 0, 0, null, null, 0, null],\"5\":[null, null, null, null, 0, 0, null, null, 0, null],\"6\":[null, null, null, null, 0, 0, null, null, 0, null],\"7\":[null, null, null, null, 0, 0, null, null, 0, null],\"8\":[null, null, null, null, 0, 0, null, null, 0, null],\"9\":[null, null, null, null, 0, 0, null, null, 0, null]}"
        $manager->flush();
    }
}
