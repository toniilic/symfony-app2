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

        $this->makeTask($manager, $this->getReference(UserFixtures::PUBLISHER_REFERENCE), $description,
            'Lorem Lipsum Dolor', 100, $this->getReference(CategoryFixtures::CLEANING_CATEGORY_REFERENCE)
            , Task::LEVEL_OF_EXPERTIES_NOVICE, 20);
        $this->makeTask($manager, $this->getReference(UserFixtures::PUBLISHER2_REFERENCE), $description,
            'Lorem Lipsum Dolor', 100, $this->getReference(CategoryFixtures::CLEANING_CATEGORY_REFERENCE),
            Task::LEVEL_OF_EXPERTIES_NOVICE, 20);

        $manager->flush();
    }

    private function makeTask(&$manager, User $user, $description, $title, $budget, $category,
                              $levelOfExpertise, $duration, $approved = true)
    {
        $task = new Bonus();
        $task->setAuthor($user);
        $task->setContent($description);
        $task->setTitle($title);
        $task->setBonusCode('Xdghse74');
        $task->setSlug($this->container->get('slugger')->slugify($title));
        //$task->setCategory($category);
/*        $task->setDueDate($dueDate);
        $task->setLevelOfExpertise($levelOfExpertise);
        $task->setDuration($duration);
        $task->setPhoneNumber($user->getPhoneNumbers()[0]);
        $task->setApproved($approved);*/

        $manager->persist($task);
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
