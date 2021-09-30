<?php

namespace App\Controller;

use app\Entity\Wallet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Uid\Uuid;

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
     *     requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function display(string $id): Response
    {
        // Récupère le user connecté
        $user = $this->getUser();

        //Génère l'objet wallet
        $uuid = Uuid::fromString($id);
        $wallet = $this->getDoctrine()->getRepository(Wallet::class)->generateWallet($uuid, $user);

        // Redirige vers 404
        if(is_null($wallet)) {
            throw $this->createNotFoundException(sprintf('Auncun droit d\'accès pour ce portefeuille'));
        }

        return $this->render('wallet/display.html.twig', [
            'wallet' => $wallet,
        ]);
    }


}
