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


class Formation
{
    //public function pdf ($formData)
    /**
     *Genere le pdf Formation
     *@method pdf
     * @param array $formData[$z]
     * @return pdf
     */
    public static function pdf($row,$xml)
    {

        $pdf = \Pdf::forge('fpdf', array('P', 'mm', 'A4'));
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', '20');
        /**
         *Logo du forem
         */
        $pdf->Image('assets/img/administratif/Forem.jpg', 11, 17, 24, 24);
        /**
         * Titre de la page
         */
        $pdf->SetXY(60, 21);
        $pdf->Cell('', '', utf8_decode('Contrat de formation professionnelle'));
        $pdf->SetLineWidth(0.7);
        $pdf->Line(60, 25, 175, 25);
        $pdf->SetXY(124, 28);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell('', '', utf8_decode('(Annexe : condition générales)'));
        /**
         * premier cadre
         */
        $pdf->SetFont('Times', 'I', 9.5);
        $pdf->SetXY(11, 48);
        //$pdf->SetLineWidth();
        $pdf->Cell('', 8, utf8_decode('Données utiles pour la constatation du droit aux allocations de chômage pendant la formation'), 1);
        /**
         * Deuxième cadre
         */
        $pdf->SetFont('Times', '', 9.5);
        $pdf->SetXY(11, 56);
        $pdf->Cell('', 57, '', 1);
        $pdf->SetXY(11, 58);
        $pdf->Cell('', '', utf8_decode('La formation est principalement suivie pendant la semaine avant 17 heures'));
        $pdf->SetXY(142, 58);
        $pdf->Cell('', '', utf8_decode('N° demandeur emploi :') . $row['t_numero_inscription_forem']);
        $pdf->SetXY(11, 61);
        $pdf->Cell('', '', utf8_decode('Horaire hebdomadaire moyen et période de formation :'));
        $pdf->Rect(12, 68, 3, 3);
        $pdf->SetXY(15, 70);
        $pdf->Cell('', '', utf8_decode('<= 35h'));
        /**
         * Croix dans le carré
         */
        $pdf->Line(12, 68, 15, 71);
        $pdf->Line(12, 71, 15, 68);
        $pdf->SetXY(46, 70);
        $pdf->Cell('', '', utf8_decode('du                                         au'));
        $pdf->Rect(12, 72, 3, 3);
        $pdf->SetXY(15, 74);
        $pdf->Cell('', '', utf8_decode('=> 17,5h <35h'));
        $pdf->SetXY(46, 74);
        $pdf->Cell('', '', utf8_decode('du                                         au'));
        $pdf->Rect(12, 76, 3, 3);
        $pdf->SetXY(15, 78);
        $pdf->Cell('', '', utf8_decode('< 17,5h'));
        $pdf->SetXY(46, 78);
        $pdf->Cell('', '', utf8_decode('du                                         au'));


        $pdf->Rect(12, 80, 3, 3);
        $pdf->SetXY(15, 82);
        $pdf->Cell('', '', utf8_decode('pas encore connu'));
        $pdf->SetXY(46, 82);
        $pdf->Cell('', '', utf8_decode('du                                         au'));
        $pdf->SetXY(11, 88);
        $pdf->Cell('', '', utf8_decode('Le stagiaire-chômeur indemnisé doit introduire au plus vite un exemplaire du présent document auprès de son organisme de paiement. Il'));
        $pdf->SetXY(11, 91);
        $pdf->Cell('', '', utf8_decode('bénéficie d\'une dispense de présentation au contrôle communal et joint chaque mois une attestation de présence C98 à sa carte de'));
        $pdf->SetXY(11, 94);
        $pdf->Cell('', '', utf8_decode('contrôle.'));
        $pdf->SetXY(11, 100);
        $pdf->Cell('', '', utf8_decode('N° de registre national du stagiaire (à compléter par le stagiaire ou son organisme de paiement)'));
        $pdf->SetXY(11, 106);
        $pdf->Cell('', '', $row['t_registre_national']);
        /**
         * Corps de la page
         */
        $pdf->SetXY(11, 116);
        $pdf->Cell('', '', utf8_decode('Entre :'));
        $pdf->SetXY(11, 119);
        $pdf->Cell('', '', utf8_decode('1. L\'Office Wallon de la formation Professionnelle et de l\'emploi (FOREM); établissement public, ayant son siège à 6000 CHARLEROI,'));
        $pdf->SetXY(11, 122);
        $pdf->Cell('', '', utf8_decode('boulevard Tirou 104, représenté par Daniel VINCENT en qualité de Directeur de la Direction Régional de Namur, dûment délégué à cet'));
        $pdf->SetXY(11, 125);
        $pdf->Cell('', '', utf8_decode('effet par Monsieur J.P. MEAN, Administrateur Général,'));
        $pdf->SetXY(11, 131);
        $pdf->Cell('', '', utf8_decode('et'));
        $pdf->SetXY(11, 136);
        $pdf->Cell('', '', utf8_decode('2. Monsieur/madame ') . $row['nom'] . ' ' . $row['t_prenom'] . utf8_decode(' né(e) le : ') . $row['d_date_naissance'] . utf8_decode(' domicilié ') . ' ' . $row['t_nom_rue'] . ' ' . $row['t_code_postal'] . ' ' . $row['t_commune']);
        $pdf->SetXY(11, 142);
        $pdf->Cell('', '', utf8_decode('et'));
        $pdf->SetXY(11, 148);
        $pdf->Cell('', '', utf8_decode('3.'));
        $pdf->SetFont('Times', 'B', 8);
        $pdf->SetXY(15, 148);
        /**
         * La variable $config reprend les données qui sont insérer dans la partie config du logiciel
         */
        $pdf->Cell('', '', utf8_decode($xml->denomination . ' ' . $xml->adresse . '-' . $xml->code_postal . ' ' . $xml->localite));
        $pdf->SetFont('Times', '', 9.5);
        $pdf->SetXY(100, 148);
        $pdf->Cell('', '', utf8_decode(', représenté(e) par ' . $xml->responsable . ' et dénommé(e) l\'opérateur'));
        $pdf->SetXY(11, 151);
        $pdf->Cell('', '', utf8_decode('Il a été convenu ce qui suit : '));
        $pdf->SetXY(11, 157);
        $pdf->Cell('', '', utf8_decode('Article 1 : le présent contrat de formation professionnelle est un contrat spécifique ne pouvant être assimilé au contrat de travail.'));
        $pdf->SetXY(11, 160);
        $pdf->Cell('', '', utf8_decode('Article 2 : Il est convenu pour une durée déterminée prenant cours le           et ayant une durée maximale de '));
        $pdf->SetXY(11, 163);
        $pdf->Cell('', '', utf8_decode('             (jours - semaines - mois).'));
        $pdf->SetXY(11, 168);
        $pdf->Cell('', '', utf8_decode('Il est prolongé '));
        $pdf->SetXY(33, 168);
        $pdf->Cell('', '', utf8_decode('Du                                                           au'));
        $pdf->SetXY(33, 174);
        $pdf->Cell('', '', utf8_decode('Du                                                           au'));
        $pdf->SetXY(33, 180);
        $pdf->Cell('', '', utf8_decode('Du                                                           au'));
        $pdf->SetXY(11, 186);
        $pdf->Cell('', '', utf8_decode('Article 3 : Les prestations s\'effectuent à raison de 18 heures/semaine, étant entendu que des actions spécifiques liées à la formation'));
        $pdf->SetXY(11, 189);
        $pdf->Cell('', '', utf8_decode('professionnelle telles que prévues à l\'article 5 ci-après peuvent être prevues à titre occasionnel le week-end et/ou en semaine après 17'));
        $pdf->SetXY(11, 192);
        $pdf->Cell('', '', utf8_decode('heures.'));
        $pdf->SetXY(11, 195);
        $pdf->Cell('', '', utf8_decode('Article 4 : le présent contrat commence par une période d\'essai de 7 jours.'));
        $pdf->SetXY(11, 198);
        $pdf->Cell('', '', utf8_decode('Article 5 : Le présent contrat a pour objet de procurer une formation professionnelle à:'));
        $pdf->SetXY(11, 201);
        $pdf->Cell('', '', utf8_decode('Monsieur/madame : ') . $row['nom']);
        $pdf->SetXY(157, 201);
        $pdf->Cell('', '', utf8_decode('(stagiaire)'));
        $pdf->SetXY(11, 206);
        $pdf->Cell('', '', utf8_decode('en ') . $row['t_nom']);
        $pdf->SetXY(157, 206);
        $pdf->Cell('', '', utf8_decode('(objet de la formation)'));
        $pdf->SetXY(11, 209);
        $pdf->Cell('', '', utf8_decode('au centre de Formation situé '));
        /*
           * A voir où se situe la formation
           */
        //$lieuxformation = $config['confadresse_lieu_le'] . ' à ' . $config['confcodepostal_lieu_le'] . ' ' . $config['conflocalite_lieu_le'] . '(' . $config['confnom_lieu_le'] . ')';

        $pdf->SetXY(57, 209);
        $pdf->SetFont('Times', 'B', 8);
        //$pdf->Cell('', '', utf8_decode($lieuxformation));
        $pdf->Cell('', '', '');
        $pdf->SetXY(157, 209);
        $pdf->SetFont('Times', '', 9.5);
        $pdf->Cell('', '', utf8_decode('(lieu principal de la formation)'));
        $pdf->SetXY(11, 214);
        $pdf->Cell('', '', utf8_decode('Article 6 : Pendant la formation et pour la durée fixée par l\'article 2, le(la) stagiaire a droit à charge du FOREM :'));
        $pdf->SetXY(11, 219);
        $pdf->Cell('', '', utf8_decode('- à une prime de formation professionnelle d\'un montant de 1 euro par heure de formation effectivement suivie.'));
        $pdf->SetXY(160, 217);
        $pdf->SetFontSize(5);
        $pdf->Cell('', '', utf8_decode('(1)'));
        $pdf->SetXY(11, 223);
        $pdf->SetFontSize(9.5);
        $pdf->Cell('', '', utf8_decode('- au remboursement de ses frais de déplacement'));
        $pdf->SetXY(77, 222);
        $pdf->SetFontSize(5);
        $pdf->Cell('', '', utf8_decode('(1)'));
        $pdf->SetXY(11, 227);
        $pdf->SetFontSize(9.5);
        $pdf->Cell('', '', utf8_decode('- à une intervention dans ses frais de séjour exposés pour assister aux cours;'));
        $pdf->SetXY(115, 226);
        $pdf->SetFontSize(5);
        $pdf->Cell('', '', utf8_decode('(1)'));
        $pdf->SetXY(11, 231);
        $pdf->SetFontSize(9.5);
        $pdf->Cell('', '', utf8_decode('- à une intervention dans les frais de garde limitée à 4 euros/jour et par enfant en ce qui concerne les frais de crèche; à 2 euros/jour et'));
        $pdf->SetXY(11, 235);
        $pdf->Cell('', '', utf8_decode('par enfant en ce qui concerne les frais de garderie scolaire;'));
        $pdf->SetXY(11, 239);
        $pdf->Cell('', '', utf8_decode('- aux avantages prévus par l\'article 7 des conditions générales jointe au présent contrat.'));
        $pdf->SetXY(11, 243);
        $pdf->Cell('', '', utf8_decode('Article 7 : les parties désignées déclarent par la présente avoir reçu un exemplaire des conditions générales du contrat'));
        $pdf->SetXY(11, 247);
        $pdf->Cell('', '', utf8_decode('de formation professionnelle et s\'engagent à respecter et à éxécuter les clauses qui y figurent, sauf en ce qui concerne les articles'));
        $pdf->SetXY(11, 251);
        $pdf->Cell('', '', utf8_decode('..................................................................................................'));
        $pdf->SetXY(11, 255);
        $pdf->Cell('', '', utf8_decode('Ainsi établi à Namur, le                  en autant d\'exemplaire que de parties signataires au présent contrat.'));
        /**
         * Signature de l'opérateur
         */
        $pdf->SetXY(11, 260);
        $pdf->Cell(61, 6, utf8_decode('Pour l\'opérateur'), 1, '', 'C');
        $pdf->SetXY(11, 266);
        $pdf->Cell(61, 10, utf8_decode($xml->responsable), 1, '', 'R');
        /**
         * Signature du stagiaire
         */
        $pdf->SetXY(72, 260);
        $pdf->Cell(61, 6, utf8_decode('Le(la) stagiaire'), 1, '', 'C');
        $pdf->SetXY(72, 266);
        $pdf->Cell(61, 10, utf8_decode('....................'), 1, '', 'C');
        /**
         * Signature du FOREM
         */
        $pdf->SetXY(133, 260);
        $pdf->Cell(61, 6, utf8_decode('Pour le FOREM'), 1, '', 'C');
        $pdf->SetXY(133, 266);
        $pdf->Cell(61, 10, utf8_decode('Le Directeur de la DR'), 1, '', 'R');
        $pdf->SetXY(133, 268);
        $pdf->Text(174, 274.5, utf8_decode('ou son délégué'));
        /**
         * Text retourner
         */
        $pdf->SetFontSize(4);
        $pdf->RotatedText(8, 276, utf8_decode('F70 Bis 01/2002'), 90);

        ob_end_clean();
        $pdf->Output();

    }
}

?>