<?php

namespace App\Controller;

use App\Entity\Bonus;
use App\Entity\Casino;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
