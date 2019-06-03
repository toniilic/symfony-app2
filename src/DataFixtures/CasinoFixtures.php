<?php

namespace App\DataFixtures;

use App\Entity\Bonus;
use App\Entity\Casino;
use App\Entity\Task;
use App\Entity\User;
use AppBundle\Utils\Slugger;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CasinoFixtures extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    public const CASINO_1 = 'casino-1';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
        Aliquam sagittis accumsan nisi ac tempor. Cras arcu ex, bibendum dapibus 
        dui et, fringilla laoreet lacus.';

        $casino = $this->makeCasino($manager, $this->getReference(UserFixtures::PUBLISHER_REFERENCE), $description,
            'Lorem Casino Dolor', 100, $this->getReference(CategoryFixtures::FREE_SPINS)
            , Task::LEVEL_OF_EXPERTIES_NOVICE, 20);
        $this->addReference(self::CASINO_1, $casino);
        $this->makeCasino($manager, $this->getReference(UserFixtures::PUBLISHER2_REFERENCE), $description,
            'Lorem Casino Dolor', 100, $this->getReference(CategoryFixtures::FREE_SPINS),
            Task::LEVEL_OF_EXPERTIES_NOVICE, 20);
        $this->makeCasino($manager, $this->getReference(UserFixtures::PUBLISHER2_REFERENCE), $description,
            'Lorem Casino Dolor', 100, $this->getReference(CategoryFixtures::FREE_SPINS),
            Task::LEVEL_OF_EXPERTIES_NOVICE, 20);
        $this->makeCasino($manager, $this->getReference(UserFixtures::PUBLISHER2_REFERENCE), $description,
            'Lorem Casino Dolor', 100, $this->getReference(CategoryFixtures::FREE_SPINS),
            Task::LEVEL_OF_EXPERTIES_NOVICE, 20);

        $manager->flush();
    }

    private function makeCasino(&$manager, User $user, $description, $title, $budget, $category,
                               $levelOfExpertise, $duration, $approved = true)
    {
        $casino = new Casino();
        $casino->setAuthor($user);
        $casino->setContent($description);
        $casino->setTitle($title);
        $casino->setUrl('http://www.dummycasino.com');
        $casino->setSlug($this->container->get('slugger')->slugify($title));
        $casino->setAllowedCountries(['United States', 'Great Britain']);

        $manager->persist($casino);

        return $casino;
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 6;
    }
}
