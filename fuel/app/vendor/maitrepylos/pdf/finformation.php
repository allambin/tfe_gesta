<?php
/**
 * Classe de generation du PDF de fin de formation
 * @copyright  2008 Formatux Technologies
 * @author     info@formatux.be  Ernaelsten Gerard
 * @license    http://www.formatux.be/contact   Merci de prendre contact avec l'auteur
 * @version    Release: 0.3
 * @link       http://www.formatux.be
 * @since      Class available since Release 1.6.1
 * @deprecated Class deprecated in Release 2.0.0
 * @category   Pontaury
 * @package    Maitrepylos\Pdf
 * @subpackage pdf/fin
 */

namespace Maitrepylos\Pdf;


class Finformation
{

    //public function pdf ($user, $rows, $heure, $deplacement, $salaire,$heureRecup,$count,$mois,$annee,$heureJustifier,$heureNonJustifier)
    /**
     *Genere le pdf
     *@method pdf
     * @param array $formData[$z]
     * @return pdf
     */
    public static function pdf($participant, $contrat)
    {
        $time = new \Maitrepylos\Timetosec();

        $pdf = \Pdf::forge('fpdf', array('P', 'mm', 'A4'));


        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 18);
        /**
         * Pose des images
         */
        $pdf->Image('assets/img/administratif/bandeau_nb.jpg', 12, 05, 186, 33.10); //entete
        $pdf->Image('assets/img/administratif/sigles_inf_nb.jpg', 12, 40, 11, 30); //sigles entete
        $pdf->Image('assets/img/administratif/lateral_nb.jpg', 195, 45, 6, 202); //lateral
        $pdf->Image('assets/img/administratif/inf_nb.jpg', 0, 292, 210, 6); //bandeau pied de page
        $pdf->Image('assets/img/administratif/sigles_inf_nb.jpg', 190, 250, 13, 40); //sigles pied de page
        $pdf->Image('assets/img/administratif/bas_nb.jpg', 60, 280, 125, 6); //pied de page
        //$pdf->SetTextColor(255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'U', 18);
        $pdf->SetXY(15, 45);
        $pdf->Cell(0, 5, 'FIN DE FORMATION', 0, 0, 'C');
        $pdf->SetFont('Arial', '', 14);
        $pdf->Text(25, 65, 'Stagiare : ' . $participant->t_nom . ' ' . $participant->t_prenom);
        $pdf->Text(100, 65, utf8_decode('N° RN :' . $participant->t_registre_national));
    //    foreach ($participant->adresses as $value) {
            $pdf->Text(25, 73, 'Adresse : ' . $participant->t_nom_rue . ' ' . $participant->t_code_postal . ' ' . $participant->t_commune);
      //  }
        $pdf->Text(25, 81, utf8_decode('Filière de formation : '.$contrat->t_nom));
        $pdf->Text(25, 89, utf8_decode('Date d\'entrée en formation : '.\Maitrepylos\Date::db_to_date($contrat->d_date_debut_contrat)));
        $pdf->Text(25, 97, utf8_decode('Date de fin de formation : '. \Maitrepylos\Date::db_to_date($contrat->d_date_fin_contrat)));

        $pdf->SetFont('Arial', 'U', 18);
        $pdf->SetXY(15, 105);
        $pdf->Cell(0, 5, 'MOTIF DE LA FIN DE FORMATION', 0, 0, 'C');
        $pdf->SetFont('Arial', '', 14);
        $pdf->Text(25, 120, utf8_decode('Formation arrivée à son terme'));
        $pdf->Rect(95, 117, 3, 3);
        $pdf->Text(25, 128, utf8_decode('Fin de formation anticipé '));
        $pdf->Rect(95, 125, 3, 3);
        $pdf->Text(50, 136, utf8_decode('Demandé par l\'opérateur '));
        $pdf->Rect(110, 133, 3, 3);
        $pdf->Text(125, 136, utf8_decode('Demandé par le stagiaire '));
        $pdf->Rect(185, 133, 3, 3);
        $pdf->Text(25, 144, utf8_decode('Emploi'));
        $pdf->Rect(45, 141, 3, 3);
        $pdf->Text(60, 144, utf8_decode('Quoi?'));
        $pdf->Text(60, 152, utf8_decode('Type de contre :'));

        $pdf->Text(25, 160, utf8_decode('Autre formation/dispositif :'));
        $pdf->Rect(85, 157, 3, 3);
        $pdf->Text(95, 160, utf8_decode('Quoi?'));

        $pdf->Text(25, 168, utf8_decode('Inaptitude à l\'apprentissage du métier (sans attitude fautive)'));
        $pdf->Rect(160, 165, 3, 3);

        $pdf->Text(25, 176, utf8_decode('Absence injustifié '));
        $pdf->Rect(65, 173, 3, 3);
        $pdf->Text(75, 176, utf8_decode('Date d\'avertissement : '));

        $pdf->Text(25, 184, utf8_decode('Attitude fautive '));
        $pdf->Rect(65, 181, 3, 3);
        $pdf->Text(75, 184, utf8_decode('Date d\'avertissement : '));

        $pdf->Text(25, 192, utf8_decode('Abandon'));
        $pdf->Rect(65, 189, 3, 3);

        $pdf->Text(25, 200, utf8_decode('Autre'));
        $pdf->Rect(65, 197, 3, 3);


        $pdf->Text(40, 220, utf8_decode('Signature coordinateur'));


        $pdf->Output();
    }
}