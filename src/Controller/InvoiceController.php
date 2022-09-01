<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{

    public EntityManagerInterface $em;
    public FlashyNotifier $flashy;

    public function __construct(EntityManagerInterface $em, FlashyNotifier $flashy)
    {
        $this->em = $em;
        $this->flashy = $flashy;
    }

    // generate an invoice number
    // return an int
    private function generateInvoiceNumber(): int
    {
        $actualDate = new \DateTime();
        $dateInNumber = strtotime($actualDate->format('H:i:s'));
        $invoiceNumber = $dateInNumber;

        return (int)$invoiceNumber;

    }

    private function calculateTotalAmount($vat, $amount, $quantity): float
    {
        $totalAmount = $amount * $quantity;
        return $totalAmount + ($totalAmount * $vat / 100);
    }

    #[Route('/invoice', name: 'app_invoice')]
    public function createInvoice(Request $request): Response
    {

        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice->setInvoiceNumber($this->generateInvoiceNumber());
            // get all invoiceslines
            $invoiceLines = [];
            foreach ($form->get("invoiceLines")->getData() as $invoiceLine) {
                $totalAmountwithVat = $this->calculateTotalAmount($invoiceLine->getVatAmount(), $invoiceLine->getAmount(), $invoiceLine->getQuantity());
                $invoiceLine->setTotalVat($totalAmountwithVat);
                $invoice->addInvoiceLine($invoiceLine);
            }
//            $invoice->addInvoiceLine($invoiceLines);

            $invoice->setInvoiceDate(new \DateTime());
            $this->em->persist($invoice);
            $this->em->flush();
            $this->flashy->success('Invoice created!');
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('invoice/invoice.html.twig', [
            'controller_name' => 'InvoiceController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }
}
