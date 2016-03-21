<?php

namespace PdfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TCPDF2DBarcode;

class PdfControllerController extends Controller
{
    /**
     * @Route("/preview", name= "pdf_preview")
     */
    public function previewAction()
    {
        $barcodeobj = new TCPDF2DBarcode('http://l.sandbox.com/app_dev.php/print-form', 'QRCODE,H');
        $qr = $barcodeobj->getBarcodeSVGcode( 3, 3, 'black');

        return $this->render('PdfBundle:Pdf:content.html.twig', array( 'preview' => true, 'qr' => $qr));
    }

    /**
     * @Route("/print", name= "pdf_print")
     */
    public function printAction()
    {
        $barcodeobj = new TCPDF2DBarcode('http://l.sandbox.com/app_dev.php/print-form', 'QRCODE,H');
        $qr = $barcodeobj->getBarcodeSVGcode( 3, 3, 'black');

        $html = $this->renderView('PdfBundle:Pdf:content.html.twig', array( 'preview' => false, 'qr' => $qr));
//        $response = new Response($pdf->Output('test.pdf','D'));
//        $response->headers->set('Content-Type', 'application/pdf');
//        return $response;
    }
}
