<?php

namespace App\Controller;

use App\Entity\Transaction;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TransactionController extends AbstractController
{
    /**
     * @Route(
     *     "/transaction-{id}",
     *     requirements={"id"="\d+"})
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function display(int $id): Response
    {

        // Génère l'objet transaction
        $transaction = $this->getDoctrine()->getRepository(Transaction::class)->find($id);

        //dd($transaction);
        return $this->render('transaction/index.html.twig',[
            'transaction' => $transaction
        ]);
    }
}
