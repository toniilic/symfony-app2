<?php

namespace App\Controller;

use App\Entity\Bonus;
use App\Entity\Casino;
use App\Entity\Category;
use App\Entity\Location;
use App\Entity\PhoneNumber;
use App\Entity\Task;
use App\Entity\TaskApplication;
use App\Entity\User;
use App\Repository\TaskRepository;
use DateTime;
use Doctrine\ORM\EntityRepository;
use IntlDateFormatter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @Route("/bonus")
 */
class BonusController extends AbstractController
{

    /**
     * @Route("/show/{id}", name="bonus_show")
     */
    public function show(Bonus $bonus)
    {
        $user = $this->getUser();

        $is_owner = $user == $bonus->getAuthor();


        $allowedCountries = $this->extractSelectedCountries($bonus->getCasino());
        $allowedCountriesCSV = implode(',',$allowedCountries);

        return $this->render('bonus/show.html.twig', [
            'bonus' => $bonus,
            'category' => $bonus->getCategory(),
            'casino' => $bonus->getCasino(),
            'allowedCountriesCSV' => $allowedCountriesCSV,
            'is_owner' => $is_owner,
        ]);
    }

    protected function extractSelectedCountries(Casino $casino)
    {
        $extractedSelectedCountries = array();

        $selectedCountries = $casino->getAllowedCountries();

        $countries = Intl::getRegionBundle()->getCountryNames();

        foreach($selectedCountries as $k => $v) {
            // "AF" => "Afghanistan"
            if(array_key_exists($v, $countries)) {
                $extractedSelectedCountries[$v] = $countries[$v];
            }
        }

        return $extractedSelectedCountries;
    }
}
