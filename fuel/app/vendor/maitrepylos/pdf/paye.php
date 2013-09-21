<?php
/**
 * Classe de generation du PDF fiche de paye
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


class Paye
{
    //public function pdf ($user, $rows, $heure, $deplacement, $salaire,$heureRecup,$count,$mois,$annee,$heureJustifier,$heureNonJustifier)
    /**
     *Genere le pdf
     *@method pdf
     * @param array $formData[$z]
     * @return pdf
     */
    public static function pdf($formData, $nombre_contrat)
    {
        $time = new \Maitrepylos\Timetosec();

        $tableau_schemas = array(

            '/',
            '%',
            '*'
        ); //initialisation d'un tableau pour vérifier si absence ou pas.
        //  $pdf = new textbox('P', 'mm', 'A4');
        $pdf = \Pdf::forge('fpdf', array('P', 'mm', 'A4'));
        for ($z = 0; $z < $nombre_contrat;$z++) {
            $a = 0; //initialisation d'un compteur pour la boucle ligne 70
            
            for ($b = 0; $b < $formData[$z]['count']; $b++) {
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 12);
                /**
                 * Pose des images
                 */
                $pdf->Image('assets/img/administratif/bandeau_nb.jpg', 12, 05, 186, 33.10); //entete
                $pdf->Image('assets/img/administratif/sigles_inf_nb.jpg', 12, 40, 11, 30); //sigles entete
                $pdf->Image('assets/img/administratif/lateral_nb.jpg', 195, 45, 6, 202); //lateral
                $pdf->Image('assets/img/administratif/inf_nb.jpg', 0, 292, 210, 6); //bandeau pied de page
                $pdf->Image('assets/img/administratif/sigles_inf_nb.jpg', 190, 250, 13, 40); //sigles pied de page
                $pdf->Image('assets/img/administratif/bas_nb.jpg', 60, 280, 125, 6); //pied de page
                $pdf->SetTextColor(255);
                $pdf->SetTextColor(0);
                $pdf->SetFont('Arial', '', 12);
                //$pdf->Text(25, 35, utf8_decode('Présences et défraiements stagiaires - Récapitulatif du mois : janvier 2008 '));
                $pdf->SetXY(25, 35);
                $pdf->Cell('', 5, utf8_decode('Fiche de défraiement de : ' . $formData[$z]['user'][0]['t_nom'] . ' ' . $formData[$z]['user'][0]['t_prenom']), '', '', 'C');
                $pdf->SetXY(25, 40);
                $pdf->Cell('', 5, 'Pour le mois : ' . $formData[$z]['mois'] . ' ' . $formData[$z]['annee'], '', '', 'C');
                $pdf->SetXY(25, 45);
                $pdf->Cell('', 5, utf8_decode('Groupe : ' . $formData[$z]['groupe'][0]['t_nom']), '', '', 'C');

                $pdf->SetXY(25, 55);
                $pdf->Cell(20, 5, utf8_decode('Dates'), 1);
                $pdf->SetXY(45, 55);
                $pdf->Cell(40, 5, utf8_decode('Présences'), 1, '', 'C');
                $pdf->SetXY(85, 55);
                $pdf->Cell(55, 5, utf8_decode('Absences'), 1, '', 'C');
                $pdf->SetXY(140, 55);
                $pdf->Cell(45, 5, utf8_decode('Motifs'), 1, '', 'C');
                $y = 60;
                for ($i = 0; $i < 28; $i++) {
                    $presence = null;
                    $absence = null;
                    (in_array($formData[$z]['rows'][$a]['t_schema'], $tableau_schemas)) ? $absence = $time->TimeToString($formData[$z]['rows'][$a]['i_secondes']) : $presence = $time->TimeToString($formData[$z]['rows'][$a]['i_secondes']);
                    $pdf->SetXY(25, $y);
                    $pdf->Cell(20, 5, $formData[$z]['rows'][$a]['d_date'], 1);
                    $pdf->SetXY(45, $y);
                    $pdf->Cell(40, 5, $presence, 1, '', 'C');
                    $pdf->SetXY(85, $y);
                    $pdf->Cell(55, 5, $absence, 1, '', 'C');
                    $pdf->SetXY(140, $y);
                    $pdf->Cell(45, 5, utf8_decode($formData[$z]['rows'][$a]['t_motif']), 1, '', 'C');
                    $y = $y + 5;
                    $a++;
                }
                $pdf->SetXY(25, $y + 5);
//            //$pdf->Cell(20, 5, utf8_decode('TOTAL'), 1);
//            //$pdf->Cell(140, 5, utf8_decode($heure[0]->fulltime), 1, '', 'C');
//            //$pdf->Text(25, $y + 20, 'soit : ' . $heure[0]->fulltime . utf8_decode(' Heures à ') . $formData[$z]['salaire'][0]->ren_tarif_horaire . ' euro/H pour un total de ' . $formData[$z]['salaire'][0]->total . utf8_decode(' euro'));
                $pdf->Text(25, $y + 5, utf8_decode('(H)eures de présences = H*P :	' . $time->TimeToString($formData[$z]['total_heures_mois'][0]['fulltime'])));
            $pdf->Text(25, $y + 8, utf8_decode('Heures supplémentaires :		' . $time->TimeToString($formData[$z]['heure_recup'])));
                $pdf->Text(25, $y + 11, utf8_decode('Heures absences justifiées :		' . $time->TimeToString($formData[$z]['heure_justifier'][0]['fulltime'])));
                $pdf->Text(25, $y + 14, utf8_decode('Heures absences non justifiées :		' . $time->TimeToString($formData[$z]['heure_non_justifier'][0]['fulltime'])));
            $pdf->Text(25,$y+17,utf8_decode('Heures de présence depuis le début de la formation :'.$time->TimeToString($formData[$z]['heure_total_formation'][0]['fullTime'])));
                $pdf->Text(25, $y + 20, 'Tansport : ' . $formData[$z]['user'][0]['t_moyen_transport']);
                //           $pdf->SetFont('Arial', 'B', 10);
                $pdf->Text(140, $y + 20, utf8_decode('Défraiement : ') . $formData[$z]['salaire'][0]['total'] . utf8_decode(' euro'));
//            //$pdf->SetFont('Arial', 'B', 10);
//            //$pdf->Text(25, $y + 25, utf8_decode('DEPLACEMENT'));
                $pdf->SetFont('Arial', '', 10);
//            if ($formData[$z]['deplacement'][0]->f70bis == null)
//            {
                $pdf->Text(25, $y + 25, utf8_decode('(A)bonnement :' . $formData[$z]['deplacement'][0]['t_abonnement'] . ' euro'));
                $pdf->Text(25, $y + 28, utf8_decode('(N)ombres de jours prévus :' . $formData[$z]['jours'] . ' jours'));
                //$pdf->Text(25, $y + 31, utf8_decode('Nombres de (j)ours de présences :' . $formData[$z]['contrat'][0]['jours'] . ' jours'));
                $pdf->Text(25, $y + 31, utf8_decode('Nombres de (j)ours de présences :' . $formData[$z]['nombres_jours'][0]['compteur'] . ' jours'));
//                $pdf->Text(25, $y + 35, utf8_decode('(P)articipation EFT : 100 %'));
                $pdf->Text(25, $y + 40, utf8_decode('Total (A/j)*N :' . $formData[$z]['deplacement'][0]['total'] . ' euro'));
                $pdf->SetFont('Arial', 'B', 10);
//                $pdf->Text(140, $y + 40, utf8_decode('Déplacement : ') . $formData[$z]['deplacement'][0]->somme . utf8_decode(' euro'));
                $pdf->Text(140, $y + 43, utf8_decode('Ajout déplacement : ') . $formData[$z]['ajout_deplacemement'] . utf8_decode(' euro'));
                $somme = $formData[$z]['deplacement'][0]['total'] + $formData[$z]['salaire'][0]['total'] + $formData[$z]['ajout_deplacemement'];
//            } else
//            {
//                $pdf->Text(25, $y + 25, utf8_decode('(A)bonnement :' . $formData[$z]['deplacement'][0]['t_abonnement'] . ' euro'));
//                $pdf->Text(25, $y + 28, utf8_decode('(N)ombres de jours prévu :' . $formData[$z]['contrat'][0]['jours'] . ' jours'));
//                $pdf->Text(25, $y + 31, utf8_decode('Nombres de (j)ours de présences :' . $formData[$z]['jours'][0]['compteur'] . ' jours'));
//                $pdf->Text(25, $y + 35, utf8_decode('(P)articipation EFT : ' . ((1 - $formData[$z]['deplacement'][0]->f70bis)*100) . '%'));
//                $pdf->Text(25, $y + 40, utf8_decode('Total ((A/j)*N)*P :' . $formData[$z]['deplacement'][0]->arrondi . ' euro'));
//                $pdf->SetFont('Arial', 'B', 10);
//                $pdf->Text(140, $y + 40, utf8_decode('Déplacement : ') . $formData[$z]['deplacement'][0]['total'] . utf8_decode(' euro'));
//                $pdf->Text(140, $y + 43, utf8_decode('Ajout déplacement : ') . $formData[$z]['ajout_deplacemement'] . utf8_decode(' euro'));
//                $somme = $formData[$z]['deplacement'][0]->arrondi + $formData[$z]['salaire'][0]->total + $formData[$z]['ajout_deplacemement'];
//            }
//
//            //$pdf->Text(140, $y + 60, utf8_decode('A percevoir : ' . $somme . ' euro.'));
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetXY(140, $y + 60);
                $pdf->drawTextBox(utf8_decode('Total à payer : ' . $somme . ' euro'), 50, 8);
                //$pdf->dra
                $pdf->Text(25, $y + 65, utf8_decode('Date : ' . date('d-m-Y')));
                //$pdf->Text(25,$y+70,utf8_decode('Mode de payement : '));
                $pdf->Text(125, $y + 75, utf8_decode('Sur le compte bancaire : ' . $formData[$z]['user'][0]['t_compte_bancaire']));
            }
        }
        $pdf->Output();
    }
}

?>