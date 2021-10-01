<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Services\TransactionService;

use App\Form\TransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Uid\Uuid;

class TransactionController extends AbstractController
{
    /**
     * @Route(
     *     "/transaction-{id}",
     *     requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function display(string $id): Response
    {
        // Récupère le user connecté
        $user = $this->getUser();

        // Génère l'objet transaction en fonction de l'uuid de la transaction et de l'id du user.
        $uuid = Uuid::fromString($id);
        $transaction = $this->getDoctrine()->getRepository(Transaction::class)->generateTransaction($uuid, $user);

         // Redirige vers 404
         if(is_null($transaction)) {
             throw $this->createNotFoundException(sprintf('Auncun droit d\'accès pour cette transaction'));
        }

        return $this->render('transaction/index.html.twig',[
            'transaction' => $transaction,
            'itemname' => 'transaction',
            'itemid' => $transaction->getUuid(),
        ]);
    }

    /**
     * @Route("/add")
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function add(Request $request):Response
    {
        //J'instancie mon nouvel objet
        $transaction = new Transaction();

        //Génère le formulaire
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        //Traitement en BDD si soumis et validé
        if (($form->isSubmitted()) and ($form->isValid())) {
            $transaction->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            //Génère le Flash Message
            $this->generateFlashmessage('add');

            //Redirige vers la page transaction concernée
            return $this->redirectToRoute('app_transaction_display', ['id' => $transaction->getUuid()]);
        }

        //Affichage du formulaire
        return $this->render('transaction/add-edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route(
     *     "/transaction-{id}/edit",
     *     requirements={"id"="[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}"})
     */
    public function edit(Request $request, string $id):Response
    {
        //J'instancie mon nouvel objet et formate l'uuid
        $uuid = Uuid::fromString($id);
        $transaction = $this->getDoctrine()->getRepository(Transaction::class)->generateTransaction($uuid, $this->getUser());

        //Verifie l'appartenance de la transaction
        if(is_null($transaction)) {
            throw $this->createNotFoundException(sprintf('Auncun droit d\'accès pour cette transaction ou n\'existe pas'));
        }
        
        //Génère le formulaire
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        //Traitement en BDD si soumis et validé
        if (($form->isSubmitted()) and ($form->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            //Génère le Flash Message
            $this->generateFlashmessage('edit');

            //Redirige vers la page transaction concernée
            return $this->redirectToRoute('app_transaction_display', ['id' => $transaction->getUuid()]);
        }

        //Affichage du formulaire
        return $this->render('transaction/add-edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/transaction/remove")
     * @IsGranted ("ROLE_CUSTOMER")
     */
    public function remove(Request $request, TransactionService $transactionService) :Response
    {
        // Verifie la transaction postée
        $iditem = $request->get('iditem'); //recupère la donnée en post soit l'UUID
        $uuid = Uuid::fromString($iditem);

        if( (is_null($iditem)) ) {
            throw $this->createNotFoundException(sprintf ('Impossible de supprimer un id non défini'));
        } else {
            // Instancie la transaction à supprimer
            $transaction = $this->getDoctrine()->getRepository(Transaction::class)->generateTransaction($uuid, $this->getUser());

            if (is_null($transaction)) {
                throw $this->createNotFoundException('Impossible de supprimer la transaction car il n \'existe pas');
            } else {
                $this->getDoctrine()->getRepository(Transaction::class)->removeTransaction($transaction);

                //Génère le Flash Message
                $this->generateFlashmessage('remove');

                // Redirige vers la page de mes transactions
                return $this->redirectToRoute('app_front_index');
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
                'La transaction a bien été ajoutée'
            );
        }

        if ( $typeaction === 'edit' ) {
            $this->addFlash(
                'validation',
                'La transaction a bien été modifiée'
            );
        }

        if ( $typeaction === 'remove' ) {
            $this->addFlash(
                'validation',
                'La transaction a bien été supprimée'
            );
        }

    }


}
