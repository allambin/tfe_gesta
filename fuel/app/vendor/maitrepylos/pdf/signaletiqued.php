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


class Signaletiqued
{
    //public function pdf ($formData)
    /**
     *Genere le pdf Signaletique deplacemement
     *@method pdf
     * @param array $formData[$z]
     * @return pdf
     */
    public static function pdf($formData)
    {

        $pdf = \Pdf::forge('fpdf', array('P', 'mm', 'A4'));
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 10);
        /**
         *Logo du forem
         */
        $pdf->Image('assets/img/administratif/Forem.jpg', 25, 12, 24, 24);
        /**
         * Entête de la fiche signalitique
         */
        $pdf->SetXY(110, 8);
        $pdf->Cell('', '', utf8_decode('N° de convention'));
        $pdf->SetXY('', 45);
        $pdf->Cell('', '', utf8_decode('Direction Régional de Namur '), '', '', 'C');
        $pdf->SetXY('', 48);
        $pdf->Cell('', '', utf8_decode('Service des Relations Partenariales'), '', '', 'C');
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY('', 54);
        $pdf->Cell('', '', utf8_decode('FICHE SIGNALETIQUE-D.E.'), '', '', 'C');
        $pdf->SetFont('Times', '', 8);
        $pdf->SetXY('', 59);
        $pdf->Cell('', '', utf8_decode('Ce document dûment complété et signé, doit impérativement être renvoyé par retour du courrier au'), '', '', 'C');
        $pdf->SetFont('Times', 'B', 8);
        $pdf->SetXY('', 62);
        $pdf->Cell('', '', utf8_decode('FOREM Relations Partenariales - Avenue Prince de Liège, 137 - 5100 Jambes'), '', '', 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(21, 67);
        $pdf->Cell('', 13, '', '1');
        /**
         * Cadre
         */
        $pdf->SetXY(23, 70);
        $pdf->Cell('', '', utf8_decode('Formation de : ').$formData['t_nom']);
        $pdf->SetXY(130, 70);
        $pdf->Cell('', '', utf8_decode('Date d\'entrée : ') );//. $formData['date_entree']);
        $pdf->SetXY(23, 75);
        $pdf->Cell('', '', utf8_decode('N° d\'inscription comme demandeur d\'emploi : ') .$formData['t_numero_inscription_forem']);
        $pdf->Line(21, 84, 199, 84);
        /**
         * Renseignement généraux
         */
        $pdf->SetXY(23, 87);
        $pdf->Cell('', '', utf8_decode('-   A remplir d\'après la carte d\'identité (en lettres d\'imprimerie)'));
        $pdf->SetXY(23, 93);
        $pdf->Cell('', '', utf8_decode('NOM : ') . $formData['nom']);
        $pdf->SetXY(123, 93);
        $pdf->Cell('', '', utf8_decode('PRENOM : ') . $formData['t_prenom']);
        $pdf->SetXY(23, 99);
        $pdf->Cell('', '', utf8_decode('ADRESSE :'));
        $pdf->SetXY(47, 99);
        $pdf->Cell('', '', utf8_decode('Rue ou avenue : ') . $formData['t_nom_rue'] . '  Bte:' . $formData['t_bte']);
        $pdf->SetXy(47, 105);
        $pdf->Cell('', '', utf8_decode('Code postal : ') . $formData['t_code_postal']);
        $pdf->SetX(95, 105);
        $pdf->Cell('', '', utf8_decode('LOCALITE : ') . $formData['t_commune']);
        /**
         * Choix entre téléphone et gsm
         */
        if ($formData['t_telephone'] !='')
        {
            $pdf->SetXY(47, 111);
            $pdf->Cell('', '', utf8_decode('Téléphone : ') . $formData['t_telephone']);
        } else
        {
            $pdf->SetXY(47, 111);
            $pdf->Cell('', '', utf8_decode('Téléphone : ') . $formData['t_gsm']);
        }
        $pdf->SetXY(23, 116);
        $pdf->Cell('', '', utf8_decode('ETAT CIVIL *(1) : Célibataire - Marié(e) - Veuf(ve) - Divorcé(e) - Séparé(e)'));
        $pdf->SetXY(23, 122);
        $pdf->Cell('', '', utf8_decode('Né(e) le : ') . $formData['d_date_naissance']);
        $pdf->SetXy(79, 122);
        $pdf->Cell('', '', utf8_decode('à ') . $formData['t_lieu_naissance']);
        $pdf->SetXY(135, 122);
        $pdf->Cell('', '', utf8_decode('Nationalité : '). $formData['t_nationalite']);
        $pdf->SetXY(23, 128);
        $pdf->Cell('', '', utf8_decode('N° DE REGISTRE NATIONAL : ') . $formData['t_registre_national']);
        $pdf->Line(21, 134, 199, 134);
        /**
         * Deuxième cadre
         */
        $pdf->SetXY(34, 140);
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Write(5, utf8_decode('Le '));
        $pdf->SetFont('Times', 'IB', 10);
        $pdf->Write(5, utf8_decode('FOREM '));
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Write(5, utf8_decode('intervient dans les '));
        $pdf->SetFont('Times', 'IB', 10);
        $pdf->Write(5, utf8_decode('frais de garderie '));
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Write(5, utf8_decode('d\'enfants à raison de 2 euro par jours et par enfant pour la '));
        $pdf->SetXY(23, 146);
        $pdf->Cell('', '', utf8_decode('garderie scolaire et 4 euro par jour et par enfant pour la crèche'));
        /*$pdf->SetXY(63, 146);
          $pdf->SetFont('Times', 'IB', 10);
          $pdf->Cell('', '', utf8_decode('une prime de formation.'));*/
        $pdf->SetXY(110, 146);
        $pdf->SetFont('Times', 'I', 10);
        $pdf->Cell('', '', utf8_decode('       Veuillez indiquer le mode de paiement souhaité.'));
        $pdf->SetFont('Times', '', 10);
        $pdf->SetXY(24, 152);
        /**
         * Vérifie si la bdd contient quelque chose
         */
        if ($formData['t_compte_bancaire'] == null)
        {
            $pdf->Cell('', '', utf8_decode('*(1)    Soit par Assignation postale (chèque)- soit par Compte financier n° : - - -/- - - - - - -/- -'));
        } else
        {
            $pdf->Cell('', '', utf8_decode('*(1)    Soit par Assignation postale (chèque)- soit par Compte financier n° ' . $formData['t_compte_bancaire']));
        }
        $pdf->Line(21, 158, 199, 158);
        /**
         * Troisième et dernière partie
         */
        $pdf->SetXY(23, 164);
        $pdf->Cell('', '', utf8_decode('Etes-vous *(1):'));
        $pdf->SetXY(48, 164);
        $pdf->Cell('', '', utf8_decode('- Chômeur(se) indemnisée(e) - Chômeur(se) non indemnisée(e) - Chômeur en période d\'attente'));
        $pdf->SetXY(48, 170);
        $pdf->Cell('', '', utf8_decode('- Bénéficiaire de l\'allocation d\'handicapé - Bénéficiaire de l\'allocation du CPAS'));
        $pdf->SetXY(48, 176);
        $pdf->Cell('', '', utf8_decode('- Bénéficiaire de l\'allocation INAMI(Mutuelle)'));
        $pdf->SetFont('Times', 'I', 8);
        $pdf->SetXY(115, 176);
        $pdf->Cell('', '', utf8_decode('une autorisation de l\'INAMI est obligatoire'));
        $pdf->SetFont('Times', '', 10);
        $pdf->SetXY(48, 182);
        $pdf->Cell('', '', utf8_decode('- Travailleur (à temps plein / à temps partiel)'));
        $pdf->SetXY(23, 188);
        $pdf->Cell('', '', utf8_decode('Si vous êtes chômeur indemnisé ;'));
        $pdf->SetXY(26, 194);
        $pdf->Cell('', '', utf8_decode('Indiquer le nom de l\'organisme de paiement des allocations de chômage : '));
        $pdf->SetXY(30, 200);
        $pdf->Cell('', '', utf8_decode('- CAPAC / C.G.S.L.B. / C.S.C / F.G.T.B. *(1) Localité : ') );
        $pdf->SetXY(26, 206);
        $pdf->Cell('', '', utf8_decode('Depuis combien de temps êtes-vous chômeur indemnisé ?'));
        $pdf->SetXY(26, 212);
        $pdf->Cell('', '', utf8_decode('Le paiement des allocations de chômage a -t-il été suspendu au cours des 12 derniers mois ? OUI / NON'));
        /*		$pdf->SetXY(23, 222);
          $pdf->Cell('', '', utf8_decode('Indiquer le nom de votre Mutuelle : ' . $formData['ren_mutuelle']));
          $pdf->SetXY(132, 222);
          $pdf->Cell('', '', utf8_decode('Localité : ' ));*/
        $pdf->SetXY(23, 233);
        $pdf->Cell('', '', utf8_decode('Avez-vous un diplôme : OUI/NON ?'));
        $pdf->SetXY(26, 239);
        $pdf->Cell('', '', utf8_decode('si oui : primaire - secondaire inférieur - secondaire supérieur - supérieur ou universitaire - autres'));
        $pdf->SetXY(51, 248);
        $pdf->Cell('', '', utf8_decode('Date : ') . date('d-m-Y'));
        $pdf->SetX(110, 248);
        $pdf->Cell('', '', utf8_decode('Signature : '));
        $pdf->SetFontSize(8);
        $pdf->SetXY(23, 254);
        $pdf->Cell('', '', utf8_decode('*(1) biffer les mentions inutiles'));
        $pdf->SetXY(162, 254);
        $pdf->Cell('', '', utf8_decode('F200 02/00'));
        ob_end_clean();
        $pdf->Output(); $pdf->Output();
    }
}

?>