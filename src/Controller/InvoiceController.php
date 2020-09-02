<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Invoices;
use App\Form\InvoiceType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\InvoiceItems;
use App\Entity\System;
use App\Utils\Flasher;

class InvoiceController extends AbstractController {

    /**
     * @Route("/invoice-list/{page}", defaults={"page": "1"}, name="invoice_list")
     */
    public function invoiceList($page) {
        $entityManager = $this->getDoctrine()->getManager();
        $repoInvoice = $entityManager->getRepository(Invoices::class);

        $recordCountInt = $repoInvoice->countAllRecords();
        $invoicesObj = $repoInvoice->findAllPaginated($page);

        $repoSystem = $entityManager->getRepository(System::class);
        $systemObj = $repoSystem->getSystemSettings();

        return $this->render('invoice/crud_table.html.twig', [
                    'invoicesObj' => $invoicesObj,
                    'recordCountInt' => $recordCountInt,
                    'systemObj' => $systemObj
        ]);
    }

    /**
     * @Route("/add_invoice", name="add_invoice", methods={"POST"})
     */
    public function addInvoice(Request $request, Flasher $flasher) {
        $invoiceObj = new Invoices();

        $invoiceObj = $this->processInvoiceDataFromForm($request, $invoiceObj);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($invoiceObj);
        $entityManager->flush();
        $flasher->flashSuccess('New invoice recorded.');
        return $this->redirectToRoute("invoice_list");
    }

    /**
     * @Route("/edit_invoice", name="edit_invoice", methods={"POST"})
     */
    public function editInvoice(Request $request, Flasher $flasher) {
        $success = false;
        $invoice_id = $request->request->get('edit_invoice_id');
        if (isset($invoice_id)) {
            $entityManager = $this->getDoctrine()->getManager();
            $repo = $entityManager->getRepository(Invoices::class);
            $invoiceObj = $repo->find($invoice_id);
            if (isset($invoiceObj)) {
                $invoiceObj = $this->processInvoiceDataFromForm($request, $invoiceObj, true);

                $entityManager->persist($invoiceObj);
                $entityManager->flush();
                $success = true;
            }
        }
        if ($success) {
            $flasher->flashSuccess('Invoice data updated.');
        } else {
            $success = $flasher->flashError('Failed to update the invoice!');
        }
        return $this->redirectToRoute("invoice_list");
    }

    /**
     * @Route("/process-invoice/{id}", name="process_invoice")
     */
    public function processInvoice(Invoices $invoiceObj) {
        $invoiceItemsObj = $invoiceObj->getItems();

        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(System::class);
        $systemObj = $repo->getSystemSettings();


        return $this->render('invoice/process_invoice.html.twig', [
                    'invoiceObj' => $invoiceObj,
                    'invoiceItemsObj' => $invoiceItemsObj,
                    'systemObj' => $systemObj
        ]);
    }

    /**
     * @Route("/delete-invoice", name="delete_invoice", methods={"POST"})
     */
    public function deleteInvoice(Request $request, Flasher $flasher) {
        $success = false;
        $invoice_id = $request->request->get('delete_invoice_id');
        if (isset($invoice_id)) {
            $entityManager = $this->getDoctrine()->getManager();
            $repo = $entityManager->getRepository(Invoices::class);
            $invoiceObj = $repo->find($invoice_id);

            if (isset($invoiceObj)) {
                $entityManager->remove($invoiceObj);
                $entityManager->flush();
                $success = true;
            }
        }
        if ($success) {
            $flasher->flashSuccess('Invoice deleted');
        } else {
            $success = $flasher->flashError('Failed to delete the invoice!');
        }

        return $this->redirectToRoute("invoice_list");
    }

    /**
     * @Route("/delete-invoice_item/{id}", name="delete_invoice_item")
     */
    public function deleteInvoiceItem(InvoiceItems $invoiceItemObj, Flasher $flasher) {
        $invoiceId = $invoiceItemObj->getInvoiceId()->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($invoiceItemObj);
        $entityManager->flush();
        $flasher->flashSuccess('Invoice item deleted');
        return $this->redirectToRoute("process_invoice", ['id' => $invoiceId]);
    }

    private function processInvoiceDataFromForm(Request $request, Invoices $invoiceObj, bool $editMode = false): Invoices {
        if ($editMode) {
            $suffix = 'edit_';
        } else {
            $suffix = '';
        }
        $buyer = $request->request->get($suffix . 'buyer');
        $buyerTaxId = $request->request->get($suffix . 'buyerTaxId');
        $buyerAddress = $request->request->get($suffix . 'buyerAddress');
        $dueDate = $request->request->get($suffix . 'dueDate');

        $invoiceObj->setBuyerName(trim($buyer));
        $invoiceObj->setBuyerTaxID(trim($buyerTaxId));
        $invoiceObj->setBuyerAddress(trim($buyerAddress));
        $invoiceObj->setDueDate(new \DateTime($dueDate));

        return $invoiceObj;
    }

    private function processInvoiceItemDataFromForm(Request $request, InvoiceItems $invoiceItemObj, bool $editMode = false): ?InvoiceItems {
        if ($editMode) {
            $suffix = 'edit_';
        } else {
            $suffix = '';
        }
        $product = $request->request->get($suffix . 'product');
        $price = $request->request->get($suffix . 'price');
        $quantity = $request->request->get($suffix . 'quantity');
        if (!is_numeric($quantity) || !(is_numeric($price))) {
            return null;
        }

        $invoiceItemObj->setProduct(trim($product));
        $invoiceItemObj->setPrice($price * 100);
        $invoiceItemObj->setQuantity($quantity);
        $invoiceItemObj->setTotal($price * 100 * $quantity);

        return $invoiceItemObj;
    }

    /**
     * @Route("/edit_invoice_item", name="edit_invoice_item", methods={"POST"})
     */
    public function editInvoiceItem(Request $request, Flasher $flasher) {
        $invoice_item_id = $request->request->get('edit_item_id');
        if (isset($invoice_item_id)) {

            $entityManager = $this->getDoctrine()->getManager();
            $repo = $entityManager->getRepository(InvoiceItems::class);
            $invoiceItemObj = $repo->find($invoice_item_id);

            $result = $this->processInvoiceItemDataFromForm($request, $invoiceItemObj, true);
            if ($result !== null) {
                $invoiceItemObj = $result;
                $entityManager->persist($invoiceItemObj);
                $entityManager->flush();
            } else {
                $flasher->flashError("Non-numeric values provided when numeric expected!");
            }
        } else {
            $flasher->flashError('Failed to update the invoice item!');
            return $this->redirectToRoute("invoice_list");
        }
        $flasher->flashSuccess('Item updated.');
        return $this->redirectToRoute("process_invoice", ['id' => $invoiceItemObj->getInvoiceId()->getId()]);
    }

    /**
     * @Route("/add_invoice_item/{id}", name="add_invoice_item", methods={"POST"})
     */
    public function addInvoiceItem(Invoices $invoiceObj, Request $request, Flasher $flasher) {
        $invoiceItemObj = new InvoiceItems();
        $invoiceItemObj->setInvoiceId($invoiceObj);
        $invoiceItemObj = $this->processInvoiceItemDataFromForm($request, $invoiceItemObj);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($invoiceItemObj);
        $entityManager->flush();
        $flasher->flashSuccess('New invoice item recorded.');
        return $this->redirectToRoute("process_invoice", ['id' => $invoiceObj->getId()]);
    }

}
