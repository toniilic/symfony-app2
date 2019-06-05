<?php

namespace App\DataFixtures;

use App\Entity\Bonus;
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

class BonusFixtures extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface
{
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

        $this->makeBonus($manager, $this->getReference(UserFixtures::PUBLISHER_REFERENCE), $description,
            'Lorem Lipsum Dolor', 100, $this->getReference(CategoryFixtures::FREE_SPINS)
            , Task::LEVEL_OF_EXPERTIES_NOVICE, 20);
        $this->makeBonus($manager, $this->getReference(UserFixtures::PUBLISHER2_REFERENCE), $description,
            'Lorem Lipsum Dolor', 100, $this->getReference(CategoryFixtures::FREE_SPINS),
            Task::LEVEL_OF_EXPERTIES_NOVICE, 20);
        $this->makeBonus($manager, $this->getReference(UserFixtures::PUBLISHER2_REFERENCE), $description,
            'Lorem Lipsum Dolor', 100, $this->getReference(CategoryFixtures::FREE_SPINS),
            Task::LEVEL_OF_EXPERTIES_NOVICE, 20);
        $this->makeBonus($manager, $this->getReference(UserFixtures::PUBLISHER2_REFERENCE), $description,
            'Lorem Lipsum Dolor', 100, $this->getReference(CategoryFixtures::FREE_SPINS),
            Task::LEVEL_OF_EXPERTIES_NOVICE, 20);

        $manager->flush();
    }

    private function makeBonus(&$manager, User $user, $description, $title, $budget, $category,
                              $levelOfExpertise, $duration, $approved = true)
    {
        $bonus = new Bonus();
        $bonus->setAuthor($user);
        $bonus->setContent($description);
        $bonus->setTitle($title);
        $bonus->setBonusCode('Xdghse74');
        $bonus->setCategory($category);
        $bonus->setCasino($this->getReference(CasinoFixtures::CASINO_1));
        
/*        $bonus->setDueDate($dueDate);
        $bonus->setLevelOfExpertise($levelOfExpertise);
        $bonus->setDuration($duration);
        $bonus->setPhoneNumber($user->getPhoneNumbers()[0]);
        $bonus->setApproved($approved);*/

        $manager->persist($bonus);
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 7;
    }
}
