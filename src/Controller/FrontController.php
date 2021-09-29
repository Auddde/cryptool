<?php

namespace App\Controller;

use App\Entity\Transaction;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * Affiche la home page, une fois l'utilisateur connecté
     * @Route("/")
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        $transactions = $this->getDoctrine()->getRepository(Transaction::class)->findBy(
            [ 'user' => $user->getId() ]
        );

        // Calcul le solde initial pour toutes les transactions confondues du User
        $solde = $this->getDoctrine()->getRepository(Transaction::class)->soldeUser($user->getId());

        return $this->render('front/index.html.twig', [
            'transactions' => $transactions,
            'solde' => $solde
        ]);
    }

}
