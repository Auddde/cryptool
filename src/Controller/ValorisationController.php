<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Valorisation;
use App\Services\CoinMarketCapService;
use App\Services\CryptoService;
use App\Services\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ValorisationController extends AbstractController
{

    /**
     * @Route("/valorisation")
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function index(ChartBuilderInterface $chartBuilder) {

        //je fournis mes données à charte JS sous forme de tableau de données au Chartbuilder de symfonyUX
        //Symfony UX intègre chartJS

        $valorisations = $this->getDoctrine()->getRepository(Valorisation::class)->findBy([
            'user' => $this->getUser()
        ]);

        var_dump($valorisations);

        $date = []; // date pour mon graphique
        $originalSolde = [];
        $soldeOfDay = [];

        foreach($valorisations as $valorisation) {

            $date[] = $valorisation->getDate()->format('d/m');
            $originalSolde[] = $valorisation->getSoldeinitial();
            $soldeOfDay[] = $valorisation->getSoldeofday();
        }

        // Je créer mon graph avc chrt builder et symfony ux
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ($date),
            'datasets' => [
                [
                    'label' => 'Solde original',
                    'borderColor' => 'rgb(226, 102, 2)',
                    'data' => ($originalSolde),
                ],
                [
                    'label' => 'Valeur du jour',
                    'borderColor' => 'rgb(255, 168, 48)',
                    'data' => ($soldeOfDay)
                ],
            ]
        ]);


        return $this->render('valorisation/index.html.twig', [
            'chart' => $chart,
        ]);
    }




}
