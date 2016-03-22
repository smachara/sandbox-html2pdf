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

        $html=<<<EOD
                    <style type="text/css">
                        <!--
                            div.zone { border: none; border-radius: 6mm; background: #FFFFFF; border-collapse: collapse; padding:3mm; font-size: 2.7mm;}
                            h1 { padding: 0; margin: 0; color: #DD0000; font-size: 7mm; }
                            h2 { padding: 0; margin: 0; color: #222222; font-size: 5mm; position: relative; }
                        -->
                    </style>
                    <page format="100x200" orientation="L" backcolor="#AAAACC" style="font: arial;">
                        <div style="rotate: 90; position: absolute; width: 100mm; height: 4mm; left: 195mm; top: 0; font-style: italic; font-weight: normal; text-align: center; font-size: 2.5mm;">
                            Ceci est votre e-ticket à présenter au contrôle d'accès -
                            billet généré par <a href="http://html2pdf.fr/" style="color: #222222; text-decoration: none;">html2pdf</a>
                        </div>
                        <table style="width: 99%;border: none;" cellspacing="4mm" cellpadding="0">
                            <tr>
                                <td style="width: 25%;">
                                    <div class="zone" style="height: 40mm;vertical-align: middle;text-align: center;">
                                        <qrcode value="num.nom.date" ec="Q" style="width: 37mm; border: none;" ></qrcode>
                                    </div>
                                </td>
                                <td style="width: 75%">
                                    <div class="zone" style="height: 40mm;vertical-align: middle; text-align: justify">
                                        <b>Conditions d'utilisation du billet</b><br>
                                        Le billet est soumis aux conditions générales de vente que vous avez
                                        acceptées avant l'achat du billet. Le billet d'entrée est uniquement
                                        valable s'il est imprimé sur du papier A4 blanc, vierge recto et verso.
                                        L'entrée est soumise au contrôle de la validité de votre billet. Une bonne
                                        qualité d'impression est nécessaire. Les billets partiellement imprimés,
                                        souillés, endommagés ou illisibles ne seront pas acceptés et seront
                                        considérés comme non valables. En cas d'incident ou de mauvaise qualité
                                        d'impression, vous devez imprimer à nouveau votre fichier. Pour vérifier
                                        la bonne qualité de l'impression, assurez-vous que les informations écrites
                                        sur le billet, ainsi que les pictogrammes (code à barres 2D) sont bien
                                        lisibles. Ce titre doit être conservé jusqu'à la fin de la manifestation.
                                        Une pièce d'identité pourra être demandée conjointement à ce billet. En
                                        cas de non respect de l'ensemble des règles précisées ci-dessus, ce billet
                                        sera considéré comme non valable.<br>
                                        <br>
                                        <i>Ce billet est reconnu électroniquement lors de votre
                                            arrivée sur site. A ce titre, il ne doit être ni dupliqué, ni photocopié.
                                        Toute reproduction est frauduleuse et inutile.</i>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </page>
EOD;

        $pdf1->writeHTML($html1);

       // $pdf2 = $factory->create();
       // $pdf2->writeHTML("<html><body><p>foo</p></body></html>");
        //$pdf1->Output('my.pdf', 'S');

        //$response = new Response($pdf1->Output('my.pdf', 'S'));


       $response = new Response($pdf1->Output('test.pdf','D'));
//        $response->headers->set('Content-Type', 'application/pdf');
        return $response;
    }
}
