<?php
/**
 * Classe de generation du PDF fiche de c98
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


class c98
{

    /**
     *Genere le Pdf
     *@method pdf
     * @param array $info
     * @param array $xml
     * @param String $mois
     * @param integer $annee
     * @return pdf
     */
    public static function pdf($info, $xml,\DateTime $date)
    {
        $count = count($info);
        $pdf = \Pdf::forge('fpdf', array('P', 'mm', 'A4'));
        for ($i = 0; $i < $count; $i++) {
            $row = $info[$i];
            //$pdf->SetMargins(15, 25);
            $pdf->AddPage();
            $pdf->Image('assets/img/administratif/logoOnem.png', 25, 12, 18, 18);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 0, 'OFFICE NATIONAL DE L\'EMPLOI', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Ln(4);
            $pdf->Cell(0, 0, utf8_decode('ATTESTATION DE PRESENCE '), 0, 1, 'C');
            $pdf->Ln(3);
            $pdf->Cell(0, 0, '(AR DU 25.11.1991)', 0, 1, 'C');

            /**
             * Titre rubrique1
             */
            $pdf->SetXY(15, 35);
            $pdf->SetFillColor(152, 152, 152);
            $pdf->Cell(0, 5, 'RUBRIQUE I-IDENTITE DU CHOMEUR', 1, 1, 'C', 1);
            /**
             * Titre Rubrique 2
             */
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(15, 60);
            $pdf->Cell(0, 5, 'RUBRIQUE II-ATTESTATION DE PRESENCE RELATIVE AU MOIS DE ' . $date->format('m') . ' ' . $date->format('Y'), 1, 1, 'C', 1);
            /**
             * Texte Rubrique1
             */
            $pdf->SetXY(15, 43);
            $pdf->Cell('', '', 'NN :' . $row['t_registre_national']);
            $pdf->SetXY(70, 43);
            $pdf->Cell('', '', 'Nom: ' . $row['t_nom'] . ' ' . utf8_decode('Prénom:') . $row['t_prenom']);
            $pdf->SetXY(70, 46);
            $pdf->Cell('', '', 'Rue: ' . $row['t_nom_rue'] . ' ' . 'Bte: ' . $row['t_bte']);
            $pdf->SetXY(70, 49);
            $pdf->Cell('', '', $row['t_code_postal'] . ' ' . $row['t_commune']);
            $pdf->SetXY(15, 57);
            $pdf->Cell('', '', utf8_decode('organisme de paiement: ') . $row['t_organisme_paiement']);
            /**
             * TEXTE RUBRIQUE 2
             */
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(15, 70);
            $pdf->Cell(0, 0, 'A COMPLETER PAR :', 0, 1);
            $pdf->SetXY(18, 75);
            $pdf->drawTextBox(utf8_decode('Case A: centre de formation professionnelle ou, en cas de formation professionnelle individuelle, l\'entreprise ou l\'établissement d\'enseignement (art. 36ter à 36quinquies dispense art. 91 A.R.) ou le centre de formation à une profession indépendante (art. 92 A.R)'),'','');
            $pdf->SetXY(15, 84);
            $pdf->Cell(0, 0, utf8_decode('Case B : établissement d\'enseignement ou centre de formation (allocations de transition – art. 35 et 63 AR)'), 0, 1);
            $pdf->SetXY(15, 87);
            $pdf->Cell(0, 0, utf8_decode('Case C : établissement d\'enseignement (dispense pour autres études ou formations art. 94 A.R.)'), 0, 1);
            $pdf->SetXY(15, 90);
            $pdf->Cell(0, 0, utf8_decode('Case D : responsable de la formation (mesure spécifique - ex.art. 131octies AR/ art. 94§ 5 coopérative d\'activités)'), 0, 1);
            $pdf->SetXY(15, 93);
            $pdf->Cell(0, 0, utf8_decode('Case E : Le représentant de l\'autorité militaire compétente pour le EVMI(art.94 § 6AR'), 0, 1);
            /**
             * Ligne
             */
            $pdf->Line(15, 98, 190, 98);
            /**
             * CaseA
             */
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetXY(15, 101);
            $pdf->drawTextBox('Case A','','');
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(28, 101);
            $pdf->drawTextBox(utf8_decode('(si une dispense a été accordé pour une formation de classes moyennes d\'une durée d\'au moins une année scolaire complète, aucune attestation ne doit être introduite pour les mois de juillet et août)'),'','');
            //$pdf->Cell('', '', utf8_decode('Case A si une'));
            $pdf->SetFont('Arial', '', 8);
            $pdf->Rect(15, 108, 1.5, 1.5);
            $pdf->SetXY(16, 109.5);
            $pdf->Cell('', '', utf8_decode('Le chômeur a suivi tous les cours ou activités.'));

            $pdf->Rect(15, 113, 1.5, 1.5);

            $pdf->Text(18, 115, utf8_decode('Fermeture du centre, de l\'entreprise ou de l\'etablissement pour vacance du .................au...................'));


            $pdf->Rect(15, 117, 1.5, 1.5);

            $pdf->Text(18, 119, utf8_decode('Le chômeur a été absent sans justification ou absent pour cause d\'inaptitude au travail les jours suivants :'));

            $pdf->Line(15, 123, 190, 123);


            $pdf->Rect(15, 125, 1.5, 1.5);
            $pdf->Text(18, 127, utf8_decode('La formation professionnelle ou le stage d\'insertion ou la formation à une profession indépendante a pris fin dans le courant du mois, à savoir le ......'));
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->SetXY(15, 130);
            $pdf->Cell('', '', utf8_decode('Case B'));
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->SetXY(25, 130);
            $pdf->Cell('', '', utf8_decode('(aucune attestation ne doit être introduite pour les mois de juillet et août)'));

            $pdf->SetFont('Arial', '', 8);
            $pdf->Rect(15, 133, 1.5, 1.5);
            $pdf->SetXY(21, 134);
            $pdf->Cell('', '', utf8_decode('Le jeune est inscrit pour des études ou une formation, reconnues dans le cadre de l\'obligation scolaire à temps partiel ; il ne s\'agit'));
            $pdf->SetXY(21, 138);
            $pdf->Cell('', '', utf8_decode('pas d\'un apprentissage industriel ou d\'un apprentissage prévu par la législation relative à la formation à une profession'));
            $pdf->SetXY(21, 141);
            $pdf->Cell('', '', utf8_decode('indépendante'));
            $pdf->Rect(21, 144, 1.5, 1.5);
            $pdf->SetXY(23, 145);
            $pdf->Cell('', '', utf8_decode('L\'élève a suivi tous les cours et activités ou il n\'y a pas eu de cours ou activités organisés'));
            $pdf->Rect(21, 148, 1.5, 1.5);
            $pdf->SetXY(23, 149);
            $pdf->Cell('', '', utf8_decode('L\'élève a été absent sans justification ou absent pour cause d\'inaptitude au travail les jours suivants'));
            $pdf->Rect(15, 156, 1.5, 1.5);
            $pdf->SetXY(18, 157);
            $pdf->Cell('', '', utf8_decode('Le jeune a déjà suivi tous les cours pour l\'année scolaire en cours.'));

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetXY(15, 162);
            $pdf->Cell('', '', utf8_decode('Case C'));
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(25, 161);
            $pdf->drawTextBox(utf8_decode('(Si une dispense a été accordée pour une formation ou des études d\'une durée d\'au moins une année scolaire complète, auncune attestation ne doit être introduite pour les mois de juillet et août.)'),'','');

            $pdf->Rect(15, 168, 1.5, 1.5);
            $pdf->SetXY(18, 169);
            $pdf->Cell('', '', utf8_decode(' Le chômeur suit régulièrement les cours'));

            $pdf->Rect(15, 172, 1.5, 1.5);
            $pdf->SetXY(18, 173);
            $pdf->Cell('', '', utf8_decode(' Le chômeur ne suit plus régulièrement les cours'));

            $pdf->Rect(15, 175, 1.5, 1.5);
            $pdf->SetXY(18, 176);
            $pdf->Cell('', '', utf8_decode(' Pendant ce mois aucun cours ou activités ne sont organisés.'));


            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetXY(15, 183);
            $pdf->Cell('', '', utf8_decode('Case D :'));
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(27, 183);
            $pdf->Cell('', '', utf8_decode('Nature de la mesure spécifique'));
            $pdf->SetXY(15, 190);
            $pdf->Cell('', '', utf8_decode('D1.Le chômeur'));
            $pdf->Rect(36, 189.3, 1.5, 1.5);
            $pdf->SetXY(38, 190);
            $pdf->Cell('', '', utf8_decode('suit/'));
            $pdf->Rect(45, 189.3, 1.5, 1.5);
            $pdf->SetXY(47, 190);
            $pdf->Cell('', '', utf8_decode('ne suit pas régulièrements les cours'));
            $pdf->SetXY(15, 193);
            $pdf->Cell('', '', utf8_decode('D2.Le chômeur a été présent les jours suivants : .............'));
            $pdf->SetXY(15, 196);
            $pdf->Cell('', '', utf8_decode('D3.Le chômeur a été absent sans justification ou absent pour cause d\'inaptitude au travail les jours suivant : ................'));

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetXY(15, 200);
            $pdf->Cell('', '', utf8_decode('Case E :'));
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(27, 200);
            $pdf->Cell('', '', utf8_decode('Engagement volontaire militaire (à ne délivrer que pendant la période allant début de l\'EVMI jusqu\'au dernier jour inclus du 5ième '));
            $pdf->SetXY(27, 203);
            $pdf->Cell('', '', utf8_decode('mois calendrier qui suit le mois calendrier au cours duquel le EVMI a tét entamé):'));

            $pdf->Rect(27, 206, 1.5, 1.5);
            $pdf->SetXY(33, 207);
            $pdf->Cell('', '', utf8_decode('Le chômeur effectue toujours un engagement volontaire militaire.'));

            $pdf->Rect(27, 209, 1.5, 1.5);
            $pdf->SetXY(33, 210);
            $pdf->Cell('', '', utf8_decode('(si l\'EVMI prend fin avant le dernier jour du 5ième mois calendrier au cours duquel le EVMI a été entamé)'));
            $pdf->SetXY(33, 213);
            $pdf->Cell('', '', utf8_decode('l\'EVMI a pris fin en date du :.......................;'));

            /**
             * Signature
             */
            $pdf->SetXY(15, 219);
            $pdf->Cell('', '', utf8_decode('Le sousigné déclare avoir complété la case ... d\'une manière qui correspond à la réalité.'));
            $pdf->SetXY(15, 226);
            $pdf->Cell('', '', utf8_decode('Nom et fonction'));
//			$pdf->Text(18, 225, utf8_decode('TAHIR Natacha'));
//			$pdf->Text(18, 230, utf8_decode('secrétaire'));
            // $pdf->Text(18, 241, utf8_decode(''));
            //$pdf->Text(18, 246, utf8_decode(''));
            $pdf->SetXY(65, 226);
            $pdf->Cell('', '', utf8_decode('date et signature'));
            //$pdf->RotatedText(8, 258, utf8_decode('28.04.2006*/830.10.176'), 90);

            $pdf->SetXY(93, 226);
            $pdf->Cell('', '', utf8_decode('nom et adresse du centre de formation'));
            $pdf->SetXY(35, 232);
            //$pdf->Cell('', '', utf8_decode($xml->denomination), '', '', 'C');
            $pdf->SetXY(35, 235);
            //$pdf->Cell('', '', utf8_decode($xml->adresse) . ' ' .utf8_decode('à').' '. $xml->code_postal . ' ' . $xml->localite, '', '', 'C');


            $pdf->SetXY(180, 226);
            $pdf->Cell('', '', utf8_decode('cachet'));

            $pdf->SetXY(159, 232);
            $pdf->Cell('', '', utf8_decode($xml->denomination), '', '', 'C');
            $pdf->SetXY(159, 235);
            $pdf->Cell('', '', utf8_decode($xml->objet_social), '', '', 'C');
            $pdf->SetXY(159, 238);
            $pdf->Cell('', '', utf8_decode($xml->agregation), '', '', 'C');
            $pdf->SetXY(159, 241);
            $pdf->Cell('', '', utf8_decode($xml->agence), '', '', 'C');
            $pdf->SetXY(159, 244);
            $pdf->Cell('', '', utf8_decode($xml->adresse) . ' ' . utf8_decode('à') . ' ' . $xml->code_postal . ' ' . $xml->localite, '', '', 'C');
            $pdf->SetXY(159, 247);
            $pdf->Cell('', '', utf8_decode('Tél:' . $xml->telephone) . ' - ' . utf8_decode($xml->email), '', '', 'C');
            $pdf->SetXY(159, 250);
            $pdf->Cell('', '', utf8_decode('TVA:' . $xml->tva . '- Enregitr.' . utf8_decode($xml->enregistrement)), '', '', 'C');
            $pdf->SetXY(15, 256);
            $pdf->Cell('', '', utf8_decode('Ce modèle d\'attestation ou une attestation similaire doit être introduit auprès de l\'organisme de paiement avec la carte de contrôle'));
            $pdf->SetXY(15, 265);
            $pdf->Cell('', '', utf8_decode('15.02.2012/830.10.176'));

            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(130, 265);
            $pdf->Cell(35, 5, utf8_decode('Formulaire C 98'), 1);


        }
        ob_end_clean();
        $pdf->Output();
    }
}

