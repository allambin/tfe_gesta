<?php
/**
 * Classe de generation du PDF L1bis
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


class L1bis
{
    //public function pdf ($formData)
    /**
     *Genere le pdf L1
     *@method pdf
     * @param array $formData[$z]
     * @return pdf
     */
    public static function pdf($formData)
    {
        $pdf = \Pdf::forge('fpdf', array('P', 'mm', 'A4'));

        for($z = 0;$z<$formData['compteur'];$z++){
            //on initialise un compteur, pour le cas, ou il aurais plus de 15 participants
            $a = 1;
            for ($b = 0; $b < $formData['nombre'][$z]; $b ++)
            {
                $pdf->AddPage();
                $pdf->SetFont('Arial', '', 8);
                $pdf->Text(15, 19, utf8_decode('Ministère de la Région Wallonne'));
                $pdf->Text(15, 22, utf8_decode('Direction de la formation professionnelle'));
                $pdf->Text(15, 25, utf8_decode('Place de la Wallonie,1 - Bât. II'));
                $pdf->Text(15, 28, utf8_decode('5100 JAMBES'));
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Text(160, 19, utf8_decode('Doc.L.1(2)'));
                $pdf->SetFont('Arial', 'U', 8);
                $pdf->Text(113, 22, utf8_decode('A laisser à disposition de l\'Administration dans votre organisme'));
                $pdf->SetFont('Arial', 'BU', 10);
                $pdf->SetY(35);
                $pdf->drawTextBox(utf8_decode('EFT : Liste des présences journalières des stagiaires en stage exterieur'), '', '', 'C', 'M');

                $pdf->SetFont('Arial', '', 8);
                $pdf->SetXY(14, 50);
                $pdf->Cell(93, 5, utf8_decode('Nom de l\'organisme agréé : '), 1);
                $pdf->SetXY(107, 50);
                $pdf->Cell(94, 5,$formData['xml']->denomination, 1);
                $pdf->SetXY(14, 55);
                $pdf->Cell(93, 5,utf8_decode('Nom de l\'organisme conventionné :'), 1);
                $pdf->SetXY(107, 55);
                $pdf->Cell(94, 5,"", 1);
                $pdf->SetXY(14, 60);
                $pdf->Cell(93, 5, utf8_decode('Date du jour :'),1);
                $pdf->SetXY(107, 60);
                $pdf->Cell(94, 5,$formData['new_date'][$z], 1);
                $pdf->SetXY(14, 65);
                $pdf->Cell(93, 5, utf8_decode('Filière (CEDEFOP et intitulé) :'), 1);
                $pdf->SetXY(107, 65);
                $pdf->Cell(94, 5, $formData['cedefop'].' '.$formData['groupe'], 1);
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetXY(15, 75);
                $pdf->Cell(122,5,'',1);
                $pdf->SetXY(137, 75);
                $pdf->Cell(65,5,utf8_decode('NOMBRE D\'HEURES'),1,'','C');
                $pdf->SetXY(15, 80);
                $pdf->Cell(10, 8, '', 1);
                $pdf->SetXY(25, 80);
                $pdf->drawTextBox('NOM', 42, 8, 'C', 'M');
                $pdf->SetXY(67, 80);
                $pdf->drawTextBox('PRENOM', 35, 8, 'C', 'M');
                $pdf->SetXY(102, 80);
                $pdf->drawTextBox('SIGNATURE', 35, 8, 'C', 'M');
                $pdf->SetXY(137, 80);
                $pdf->drawTextBox('PRESTEES', 32, 8, 'C', 'M');
                $pdf->SetXY(169, 80);
                $pdf->drawTextBox(utf8_decode('D\'ABSENCE(1)'), 33, 8, 'C', 'M');

                $x = 15;
                $y = 80;
                for ($i = 0; $i < 18; $i ++)
                {
                    $y = $y + 8;
                    $pdf->SetXY($x, $y);
                    $pdf->Cell(10, 8, $a . ".", 1);
                    $pdf->SetXY($x + 10, $y);
                    $pdf->Cell(42, 8, $formData['rows'][$z][($a-1)]['t_nom'], 1);
                    $pdf->SetXY($x + 52, $y);
                    $pdf->Cell(35, 8, $formData['rows'][$z][($a-1)]['t_prenom'], 1);
                    $pdf->SetXY($x + 87, $y);
                    $pdf->Cell(35, 8, '', 1);
                    $pdf->SetXY($x + 122, $y);
                    $pdf->Cell(32, 8, '', 1);
                    $pdf->SetXY($x + 154, $y);
                    $pdf->Cell(33, 8, '', 1);
                    $a++;
                }
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetXY(102, $y+8);
                $pdf->Cell(35, 6, 'TOTAL', 1, '', 'C');
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetXY(137, $y+8);
                $pdf->Cell(32, 6, '', 1);
                $pdf->SetXY(169,$y+8);
                $pdf->Cell(33, 6, '', 1);
                $pdf->Text(14, $y + 14, utf8_decode('Certifié sincère et exact  le .. /.. /20..'));
                $pdf->SetXY(102, $y+20);
                $pdf->Cell(100,10, utf8_decode('Nom du responsable des présences :'),1);

                $pdf->Text(14, $y + 20, utf8_decode('Signature'));

                $pdf->SetFont('Arial', '', 8);
                $pdf->SetXY(14, $y+45);
                $pdf->drawTextBox(utf8_decode('(1) compléter si le stagiaire n\'est pas présent toute la journée de formation et indiquer le motif de l\'absence'), '', '', '', '', 0);

            }
        }
        $pdf->Output();
    }
}

?>