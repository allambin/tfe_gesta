<?php
/**
 * Classe de generation du PDF Signaletiquedeplacement
 * @copyright  2008 Formatux Technologies
 * @author     info@formatux.be  Ernaelsten Gerard
 * @license    http://www.formatux.be/contact   Merci de prendre contact avec l'auteur
 * @version    Release: 0.3
 * @link       http://www.formatux.be
 * @since      Class available since Release 1.7.0
 * @deprecated Class deprecated in Release 2.0.0
 * @category   Pontaury
 * @package    Maitrepylos\Pdf
 * @subpackage paye
 */

namespace Maitrepylos\Pdf;


class Deplacement
{
    //public function pdf ($formData)
    /**
     *Genere le pdf Formation
     *@method pdf
     * @param array $formData[$z]
     * @return pdf
     */
    public static function pdf($rows)
    {

        $pdf = \Pdf::forge('fpdf', array('P', 'mm', 'A4'));
        $pdf->AddPage();
        $pdf->SetFont('times', '', 10);
        /**
         *Logo du forem
         */
        $pdf->Image('assets/img/administratif/Forem.jpg', 11, 8, 24, 24);

        $pdf->Line(11,39,196,39);
        $pdf->Line(11,52,196,52);

        $pdf->SetFont('times', 'B', 10);
        $pdf->SetXY(11,45);
        $pdf->Cell('','','FRAIS DE DEPLACEMENT DES STAGIAIRES EN FORMATION PROFESSIONNELLE','','','C');

        $pdf->SetFont('times', '', 10);
        $pdf->SetXY(11,60);
        $pdf->Cell('','','DR de Namur','','','C');
        $pdf->SetXY(11,64);
        $pdf->Cell('','','Service Des Relations Partenariales','','','C');

        $pdf->Line(11,74,196,74);

        $pdf->Text(11,80,utf8_decode('NOM et Prénom du stagiaire :').$rows['nom'].' '.$rows['t_prenom']);
        $pdf->Text(11,85,utf8_decode('Adresse Complète :').' '.$rows['t_nom_rue'].' - '.$rows['t_code_postal'].' '.$rows['t_commune']);

        $pdf->Line(11,93,196,93);

        $pdf->Text(11,105,utf8_decode('Je sousigné déclare effectuer mes déplacements journaliers :'));
        $pdf->Text(11,116,'-');
        $pdf->Text(20,116,utf8_decode('Véhicule personnel'));
        $pdf->Text(90,116,utf8_decode('auto-moto*'));
        $pdf->Text(20,121,utf8_decode('Nombre de kilomètre'));

        $pdf->Text(11,131,'-');
        $pdf->Text(20,131,utf8_decode('Transport en commun'));
        $pdf->Text(20,136,utf8_decode('Autobus : '));
        $pdf->Text(50,136,'de :');
        $pdf->Text(113,136,utf8_decode('à :'));
        $pdf->Text(50,139,'de :');
        $pdf->Text(113,139,utf8_decode('à :'));

        $pdf->Text(20,146,utf8_decode('Train : '));
        $pdf->Text(50,146,'de :');
        $pdf->Text(113,146,utf8_decode('à :'));
        $pdf->Text(50,149,'de :');
        $pdf->Text(113,149,utf8_decode('à :'));

        $pdf->Text(20,159,utf8_decode('Montant journalier aller-retour'));

        $pdf->SetXY(20, 179);
        $pdf->drawTextBox(utf8_decode('Je suis informé que le remboursement des frais exposés en utilisant mon véhicule personel sera limité au remboursement du montant de l\'abonnement hebdomadaire divisé par cinq,pour chaque jour de présence au centre.'),'' ,'' , '', '', 0);

        $pdf->SetXY(20, 189);
        $pdf->drawTextBox(utf8_decode('Je remettrais au service administratif les justificatifs de mes déplacements en transport en commun(abonnement,carte,tickets périmés).'),'' ,'' , '', '', 0);

        $pdf->Text(20,200,utf8_decode('Date et signature'));

        $pdf->SetFont('times', '', 8);
        $pdf->RotatedText(196, 242, utf8_decode('BC 1233.07 bis-01/03'), 270);

        $pdf->Line(11,282,65,282);

        $pdf->SetFont('times', '', 6);
        $pdf->Text(11,286,utf8_decode('* Biffer la mention inutile.'));

        $pdf->Output();

    }
}

?>