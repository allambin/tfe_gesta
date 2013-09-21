<?php
/**
 * Classe de generation du PDF L2
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


class Etatprestation
{
    //public function pdf ($formData)
    /**
     *Genere le pdf L2
     *@method pdf
     * @param array $formData[$z]
     * @return pdf
     */
    public static function pdf($formData)
    {
        $time = new \Maitrepylos\Timetosec();
        $a = 0; //initialisation d'un compteur pour la boucle ligne 80
        $pdf = \Pdf::forge('fpdf');

        for ($b = 0; $b < $formData['count']; $b ++) {

            $pdf->AddPage('L','A4');
            $pdf->SetFont('Times', '', '10');
            /**
             *Logo du forem
             */
            $pdf->Image('assets/img/administratif/Forem.jpg', 11, 17, 24, 24);
            $pdf->SetXY(55, 12);
            $pdf->Cell(215, 28, '', 1);
            $pdf->Text(58, 18, utf8_decode('Nom de l\'opérateur : '.$formData['xml']->denomination));
            $pdf->Text(170, 18, utf8_decode('Service client :'));
            $pdf->Text(58, 28, utf8_decode('Année d\'entrée : '.date('Y')));
            $pdf->Text(120, 28, utf8_decode('Site :'));
            $pdf->Text(170, 28, utf8_decode('Période de prestations : '.$formData['date'].' au '.$formData['date2'] ));
            $pdf->Text(58, 38, utf8_decode('N° convention'));
            $pdf->SetY(53);
            $pdf->Cell('', '', utf8_decode('ETAT DE PRESTATION DES STAGIAIRES'), '', '', 'C');
            //première ligne
            $pdf->SetXY(5, 56);
            $pdf->Cell(45, 20, utf8_decode('Nom et prénom'), 1);
            $pdf->SetXY(50, 56);
            $pdf->Cell(30, 20, utf8_decode('N° National'),1);
            $pdf->SetXY(80, 56);
            $pdf->Cell(40, 8, utf8_decode('Nombres de jours global'),1);
            $pdf->SetXY(120, 56);
            $pdf->Cell(58, 8, utf8_decode('Nombres d\'heures'), 1, '', 'C');
            $pdf->SetXY(178, 56);
            $pdf->Cell(60, 8, utf8_decode('Frais de déplacement') , 1,'','C');
            $pdf->SetXY(238, 56);
            $pdf->Cell(42, 8, utf8_decode('Frais de garderie'), 1, '', 'C');
            //deuxième ligne
            $pdf->SetXY(80, 64);
            $pdf->drawTextBox('Jours formation', 20, 12,'C');
            $pdf->SetXY(100, 64);
            $pdf->drawTextBox('Jours stage', 20, 12,'C');
            $pdf->SetXY(120, 64);
            $pdf->drawTextBox('NB d\'heures formation', 20, 12,'C');
            $pdf->SetXY(140, 64);
            $pdf->drawTextBox('NB d\'heures de stage', 20, 12,'C');
            $pdf->SetXY(160, 64);
            $pdf->drawTextBox('Total', 18, 12,'C');
            $pdf->SetXY(178, 64);
            $pdf->drawTextBox(utf8_decode('Frais dépl. formation'), 20, 12,'C');
            $pdf->SetXY(198, 64);
            $pdf->drawTextBox(utf8_decode('Frais dépl. stage'), 20, 12,'C');
            $pdf->SetXY(218, 64);
            $pdf->drawTextBox(utf8_decode('Total'), 20, 12,'C');
            $pdf->SetXY(238, 64);
            $pdf->drawTextBox(utf8_decode('Crèche'), 21, 12,'C');
            $pdf->SetXY(259, 64);
            $pdf->drawTextBox(utf8_decode('Garde scolaire'), 21, 12,'C');


            $y = 69;
            for ($i = 0; $i < 11; $i ++) {
                $y = $y+7;
                $pdf->SetXY(5, $y);
                //$pdf->Cell(45, 7, $formData['rows'][$a]->par_nom.' '.$formData['rows'][$a]->par_prenom, 1);
                $pdf->drawTextBox($formData['rows'][$a]['t_nom'].' '.$formData['rows'][$a]['t_prenom'], 45, 7);
                $pdf->SetXY(50, $y);
                $pdf->Cell(30, 7, $formData['rows'][$a]['t_registre_national'],1);
                $pdf->SetXY(80, $y);
                $pdf->drawTextBox($formData['rows'][$a]['compteur_formation'], 20, 7,'C');
                $pdf->SetXY(100, $y);
                $pdf->drawTextBox($formData['rows'][$a]['compteur_stage'], 20, 7,'C');
                $pdf->SetXY(120, $y);
                $pdf->drawTextBox($time->TimeToString($formData['rows'][$a]['time_partenaire_formation']), 20, 7,'C');
                $pdf->SetXY(140, $y);
                $pdf->drawTextBox($time->TimeToString($formData['rows'][$a]['time_partenaire_stage']), 20, 7,'C');
                $pdf->SetXY(160, $y);
                $pdf->drawTextBox($time->TimeToString($formData['rows'][$a]['time_partenaire_formation'] + $formData['rows'][$a]['time_partenaire_stage']), 18, 7,'C');
                $pdf->SetXY(178, $y);
                $pdf->drawTextBox($formData['rows'][$a]['deplacement'], 20, 7,'C');
                $pdf->SetXY(198, $y);
                $pdf->drawTextBox(utf8_decode(''), 20, 7,'C');
                $pdf->SetXY(218, $y);
                $pdf->drawTextBox(utf8_decode(''), 20, 7,'C');
                $pdf->SetXY(238, $y);
                $pdf->drawTextBox(utf8_decode(''), 21, 7,'C');
                $pdf->SetXY(259, $y);
                $pdf->drawTextBox(utf8_decode(''), 21, 7,'C');

                $a++;
            }

            $pdf->SetXY(145,160);
            $pdf->Text(148,163,utf8_decode('Certifié exact,'));
            $pdf->Text(233,163,utf8_decode('Le Directeur de la D.R.'));
            $pdf->Text(235,168,utf8_decode('ou son délégué'));

            $pdf->Text(148,173,'Date : '.date('d-m-Y'));
            $pdf->Text(148,178,utf8_decode('Nom du responsable de formation ou son délégué : '));
            $pdf->Text(148, 183, utf8_decode($formData['xml']->responsable));
            $pdf->Text(148,188,'Signature :');

            $pdf->Cell(135,29,'',1);
            ob_end_clean();
        }
        $pdf->Output();
    }
}

?>