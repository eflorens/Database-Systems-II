<?php


namespace App\DataFixtures;


use App\Entity\Travel;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Intl\Countries;


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

            $codes = Countries::getCountryCodes();
            $randomOriginCode = random_int(0, count($codes) - 1);
            $randomDestinationCode = random_int(0, count($codes) - 1);

            $origin = $codes[$randomOriginCode];
            $destination = $codes[$randomDestinationCode];

            $travel = new Travel();
            $travel
                ->setTitle($faker->words($nb = 3, $asText = true))
                ->setDescription($faker->text($maxNbChars = 2000))
                ->setOrigin($origin)
                ->setDestination($destination)
                ->setCost($faker->numberBetween(1000, 45000))
                ->setRating($faker->numberBetween(1, 5))
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