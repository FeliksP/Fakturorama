<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Invoices;
use App\Entity\System;

class PrintController extends AbstractController
{
    /**
     * @Route("/print-invoice/{id}", name="print_invoice")
     */
    public function printIndex(Invoices $invoiceObj)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(System::class);
        $systemObj = $repo->getSystemSettings();
        
        $invoiceItemsObj = $invoiceObj->getItems();
        return $this->render('print/print_invoice_html.twig', [
            'invoiceObj' => $invoiceObj,
            'systemObj' =>$systemObj,
            'invoiceItemsObj' => $invoiceItemsObj
                
        ]);
    }
}
