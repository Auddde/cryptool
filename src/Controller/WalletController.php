<?php

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\WalletType;

use App\Services\TransactionService;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



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
            'itemname' => 'portefeuille',
            'itemid' => $wallet->getUuid(),
        ]);
    }

    /**
     * Formulaire d'ajout d'un portefeuille
     * @Route("/portefeuille/add")
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function add(Request $request):Response
    {
        //Instancie mon nouvel objet
        $wallet = new Wallet();

        //Génère le formulaire
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        //Traite en BDD mon formulaire si il est valide et soumis, via Entity Manager
        if (($form->isSubmitted()) and ($form->isValid())) {

            $wallet->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($wallet);
            $em->flush();

            //Génère le Flash Message
            $this->generateFlashmessage('add');

            //Redirige vers la page Wallet concernée
            return $this->redirectToRoute('app_wallet_display', ['id' => $wallet->getUuid()]);
        }

        //Affichage du formulaire
        return $this->render('wallet/add-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Formulaire d'ajout d'un portefeuille
     * @Route(
     *     "/portefeuille/{id}/edit",
     *     requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * ) //id = uuid
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function edit(Request $request, string $id):Response
    {
        //Instancie mon objet et formate l'uuid
        $uuid = Uuid::fromString($id);
        $wallet = $this->getDoctrine()->getRepository(Wallet::class)->generateWallet($uuid, $this->getUser());

        //Verifie l'appartenance du portefeuille
        if(is_null($wallet)) {
            throw $this->createNotFoundException(sprintf('Auncun droit d\'accès pour ce portefeuille'));
        }

        //Génère le formulaire
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        //Traite en BDD mon formulaire si il est valide et soumis, via Entity Manager
        if (($form->isSubmitted()) and ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            //Génère le Flash Message
            $this->generateFlashmessage('edit');

            //Redirige vers la page Wallet concernée
            return $this->redirectToRoute('app_wallet_display', ['id' => $wallet->getUuid()]);
        }

        //Affichage du formulaire
        return $this->render('wallet/add-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/portefeuille/remove")
     * @IsGranted ("ROLE_CUSTOMER")
     */
    public function remove(Request $request, TransactionService $transactionService) :Response
    {
        // Verifie le portefeuille posté
        $iditem = $request->get('iditem'); //recupère la donnée en post soit l'UUID
        $uuid = Uuid::fromString($iditem);

        if( (is_null($iditem)) ) {
            throw $this->createNotFoundException(sprintf ('Impossible de supprimer un id non défini'));
        } else {
            // Instancie le portefeuille à supprimer
            $wallet = $this->getDoctrine()->getRepository(Wallet::class)->generateWallet($uuid, $this->getUser());

            if (is_null($wallet)) {
                throw $this->createNotFoundException('Impossible de supprimer le portefeuille car il n \'existe pas');
            } else {
                // Remplace par NULL les valeurs portefeuilles dans la table transacation (relation ManytoOne)
                $transactionService->updateNullWalletForAllTransactions($wallet);

                // Supprime le portefeuille en BDD si il existe
                $this->getDoctrine()->getRepository(Wallet::class)->removeWallet($wallet);

                //Génère le Flash Message
                $this->generateFlashmessage('remove');

                // Redirige vers la page de mes portefeuilles
                return $this->redirectToRoute('app_wallet_index');
            }
        }
    }

    /**
     * Génére flash message
     */
    private function generateFlashmessage( string $typeaction) {

        if ( $typeaction === 'add' ) {
            $this->addFlash(
                'validation',
                'Le portefeuille a bien été ajouté'
            );
        }

        if ( $typeaction === 'edit' ) {
            $this->addFlash(
                'validation',
                'Le portefeuille a bien été modifié'
            );
        }

        if ( $typeaction === 'remove' ) {
            $this->addFlash(
                'validation',
                'Le portefeuille a bien été supprimé'
            );
        }

    }

}
