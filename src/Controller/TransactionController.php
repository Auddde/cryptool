<?php

namespace App\Controller;

use App\Entity\Transaction;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            'transaction' => $transaction
        ]);
    }
}
