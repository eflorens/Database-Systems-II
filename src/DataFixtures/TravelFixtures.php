<?php


namespace App\DataFixtures;


use App\Entity\Travel;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class TravelFixtures extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $repository = $manager->getRepository(User::class);
        $users = $repository->findBy(['username' => array('florian', 'hugo', 'spardha')]);

        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $random = $faker->numberBetween($min = 0, $max = 2);

            $owner = $users[$random];
            $travel = new Travel();

            $travel
                ->setTitle($faker->words($nb = 3, $asText = true))
                ->setDescription($faker->text($maxNbChars = 500))
                ->setCountry($faker->country)
                ->setUser($owner);
            $manager->persist($travel);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}