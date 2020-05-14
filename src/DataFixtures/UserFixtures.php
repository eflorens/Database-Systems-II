<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setUsername("florian");
        $user1->setPassword($this->passwordEncoder->encodePassword($user1, 'root'));
        $user1->setRoles(["ROLE_USER"]);


        $user2 = new User();
        $user2->setUsername("hugo");
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'root'));
        $user2->setRoles(["ROLE_USER"]);


        $user3 = new User();
        $user3->setUsername("spardha");
        $user3->setPassword($this->passwordEncoder->encodePassword($user3, 'root'));
        $user3->setRoles(["ROLE_USER"]);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
