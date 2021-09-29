<?php

namespace App\Controller;

use app\Entity\Wallet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class WalletController extends AbstractController
{
    /**
     * Affiche la liste des portefeuilles pour le user $id
     * @Route("/portefeuille")
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function index(): Response {

        // Récupère mon user connecté
        $user = $this->getUser();

        // Génère la liste de portefeuilles
        $wallets = $this->getDoctrine()->getRepository(Wallet::class)->findBy( [
            'user'=>$user->getId(),
        ]);

        return $this->render('wallet/index.html.twig', [
            'wallets' => $wallets,
        ]);
    }

    /**
     * Affiche une page portefeuille
     * @Route(
     *     "/portefeuille/{id}",
     *     requirements={"id"="\d+"})
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function display($id): Response
    {
        //Génère l'objet wallet
        $wallet = $this->getDoctrine()->getRepository(Wallet::class)->find($id);

        return $this->render('wallet/display.html.twig', [
            'wallet' => $wallet,
        ]);
    }


}
