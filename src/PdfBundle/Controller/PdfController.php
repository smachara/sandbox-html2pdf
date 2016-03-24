<?php

namespace PdfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use TCPDF2DBarcode;

class PdfController extends Controller
{
    /**
     * @Route("/preview", name= "pdf_preview")
     */
    public function previewAction()
    {
        $barcodeObj = new TCPDF2DBarcode('http://l.sandbox.com/app_dev.php/print-form', 'QRCODE,H');
        $qr = $barcodeObj->getBarcodeSVGcode( 3, 3, 'black');

        return $this->render('PdfBundle:Pdf:content.html.twig', array( 'preview' => true, 'qr' => $qr));
    }

    /**
     * @Route("/print", name= "pdf_print")
     */
    public function printAction()
    {
        $pdf1 = $this->get('html2pdf_factory')->create('P', 'A4', 'fr', true, 'UTF-8', 0);

        $html1 = $this->renderView('PdfBundle:Pdf:content.html.twig', array( 'preview' => false));


        $pdf1->writeHTML($html1);
        $response = new Response($pdf1->Output('test.pdf','D'));
        return $response;
    }
}
