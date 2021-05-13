<?php

namespace App\DataFixtures;

use App\Entity\Form;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $form = new Form("{\"0\":[null, null, null, null, null, null, null, null, null, null], \"1\":[null, null, null, null, null, null, null, null, null, null],\"2\":[null, null, null, null, 0, 0, 0, null, null, null],\"3\":[null, null, null, null, null, 0, null, 0, 0, 0],\"4\":[null, null, null, null, 0, 0, null, null, 0, null],\"5\":[null, null, null, null, null, null, null, null, null, null],\"6\":[null, null, null, null, null, null, null, null, null, null],\"7\":[null, null, null, null, null, null, null, null, null, null],\"8\":[null, null, null, null, null, null, null, null, null, null],\"9\":[null, null, null, null, null, null, null, null, null, null]}");
        $manager->persist($form);

        $form = new Form("{\"0\":[null, null, null, null, null, null, null, null, null, null], \"1\":[null, null, null, null, null, null, null, null, null, null],\"2\":[null, null, null, null, null, null, null, null, null, null],\"3\":[null, null, null, null, null, null, null, null, null, null],\"4\":[null, null, null, null, null, null, null, null, null, null],\"5\":[null, null, null, null, null, 0, null, null, null, null],\"6\":[null, null, null, null, null, null, null, null, null, null],\"7\":[null, null, null, null, null, null, null, null, null, null],\"8\":[null, null, null, null, null, null, null, null, null, null],\"9\":[null, null, null, null, null, null, null, null, null, null]}");
        $manager->persist($form);

        $form = new Form("{\"0\":[0, 0, null, 0, null, null, null, null, null, null], \"1\":[null, null, null, null, null, null, null, null, null, null],\"2\":[null, null, null, null, null, null, null, null, null, null],\"3\":[null, null, null, null, null, null, null, null, null, null],\"4\":[null, null, null, null, null, null, null, null, null, null],\"5\":[null, null, null, null, null, 0, null, null, null, null],\"6\":[null, null, null, null, null, null, null, null, null, null],\"7\":[null, null, null, null, null, null, null, null, null, null],\"8\":[null, null, null, null, null, null, null, null, null, null],\"9\":[null, null, null, null, null, null, null, null, null, null]}");
        $manager->persist($form);

        $form = new Form("{\"0\":[null, null, null, null, null, null, null, null, null, null], \"1\":[null, null, null, null, null, null, null, null, null, null],\"2\":[null, null, null, null, null, null, null, null, null, null],\"3\":[null, null, null, null, null, null, null, null, null, null],\"4\":[0, null, null, null, null, null, null, null, null, null],\"5\":[null, null, null, null, null, 0, null, null, null, null],\"6\":[null, null, null, null, null, null, null, null, null, null],\"7\":[null, null, null, null, null, null, null, null, null, null],\"8\":[null, null, null, null, null, null, null, null, null, null],\"9\":[null, null, null, null, 0, null, null, null, null, null]}");
        $manager->persist($form);

        $form = new Form("{\"0\":[null, null, null, null, null, null, null, null, null, null], \"1\":[null, null, null, null, null, null, null, null, null, null],\"2\":[null, null, null, null, null, null, null, null, null, null],\"3\":[null, null, null, null, null, null, null, null, null, null],\"4\":[null, null, null, null, null, null, null, null, null, null],\"5\":[null, null, null, null, null, null, null, null, null, null],\"6\":[null, null, null, null, null, null, null, null, null, null],\"7\":[null, null, null, null, null, null, null, null, 0, null],\"8\":[null, null, null, null, null, null, null, 0, 0, 0],\"9\":[null, null, null, null, null, null, null, null, 0, null]}");
        $manager->persist($form);

        $user1 = new User();
        $password = $this->encoder->encodePassword($user1, 'user1');
        $user1->setPassword($password);
        $user1->setEmail('user1@yandex.ru');
        $user1->setUsername('user1');
        $manager->persist($user1);

        $user2 = new User();
        $password = $this->encoder->encodePassword($user2, 'user2');
        $user2->setPassword($password);
        $user2->setEmail('user2@yandex.ru');
        $user2->setUsername('user2');
        $manager->persist($user2);

        $admin = new User();
        $password = $this->encoder->encodePassword($admin, 'admin');
        $admin->setPassword($password);
        $admin->setEmail('admin@yandex.ru');
        $admin->setUsername('admin');
        $manager->persist($admin);

        $manager->flush();
    }
}
