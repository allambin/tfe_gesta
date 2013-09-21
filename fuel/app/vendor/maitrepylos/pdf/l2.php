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


class L2
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
        $pdf = \Pdf::forge('fpdf', array('P', 'mm', 'A4'));

        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 8);

        $pdf->Text(15,19,utf8_decode('Ministère de la Région Wallonne'));
        $pdf->Text(15,22,utf8_decode('Direction de la formation professionnelle'));
        $pdf->Text(15,25,utf8_decode('Place de la Wallonie,1 - Bât. II'));
        $pdf->Text(15,29,utf8_decode('5100           JAMBES'));

        $pdf->SetFont('Arial', 'BU', 8);
        $pdf->Text(179,19,utf8_decode('Doc.L.2'));

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(128,28);
        $pdf->Cell(30,4,'EFT',1);
        $pdf->SetXY(128,32);
        $pdf->Cell(30,4,'OISP',1);
        $pdf->SetXY(158,28);
        $pdf->Cell(30,4,'X',1);
        $pdf->SetXY(158,32);
        $pdf->Cell(30,4,'',1);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Text(100,42,'EFT - OISP');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(14,47);
        $pdf->Cell(167,6,utf8_decode('Etat récapitulatif mensuel des prestations et des heures assimilées'),1,'','C');

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(14, 58);
        $pdf->Cell(110, 5, utf8_decode('Nom de l\'organisme agréé : '.$formData['centre'][0]['t_denomination']), 1);
        $pdf->SetXY(124, 58);
        $pdf->Cell(57, 5,utf8_decode('N° d\'agrément : ').$formData['filieres']->agrements->t_agrement, 1);

        $pdf->SetXY(14, 63);
        $pdf->Cell(110, 5, utf8_decode('Mois : '.\Maitrepylos\Utils::mois($formData['mois'])), 1);
        $pdf->SetXY(124, 63);
        $pdf->Cell(57, 5,utf8_decode('Année : ').$formData['annee'], 1);
        $pdf->SetXY(14, 68);
        $pdf->Cell(110, 5, utf8_decode('Filère de formation : '.$formData['filieres']->t_nom), 1);
        $pdf->SetXY(124, 68);
        $pdf->Cell(57, 5,utf8_decode('C. Cedefop : ').$formData['filieres']->i_code_cedefop, 1);


        $pdf->SetXY(14,78);
        $pdf->drawTextBox('Date',22,23, 'C','M');
        $pdf->SetXY(36,78);
        $pdf->Cell(145,5,"Heures de formations",1,'','C');
        $pdf->SetXY(36,83);//
        $pdf->Cell(120,5,utf8_decode("Effectivement suivi auprès de "),1,'','C');
        $pdf->SetXY(36,88);
        $pdf->drawTextBox('EFT/OISP (1)',30,13, 'C','M');
        $pdf->SetXY(66,88);
        $pdf->drawTextBox('Org. Convent.',60,13, 'C','M');
        // $pdf->SetXY(72,88);
        // $pdf->drawTextBox('Stage (3)',20,13, 'C','M');
        $pdf->SetXY(126,88);
        $pdf->drawTextBox('Ent. Dans le cadre du stage (4)',30,13, 'C','M');

        $pdf->SetXY(156,83);
        $pdf->drawTextBox(utf8_decode('Assimilées (5)'),25,18, 'C','M');

        $pdf->SetXY(14,101);
        $pdf->Cell(22,5,'',1);
        $pdf->SetXY(36,101);
        $pdf->Cell(30,5,'',1);
        $pdf->SetXY(66,101);
        $pdf->Cell(30,5,'Gratuit (2)',1,'','C');//gratuit
        $pdf->SetXY(96,101);
        $pdf->Cell(30,5,'Payant (3)',1,'','C');
        $pdf->SetXY(126,101);
        $pdf->Cell(30,5,'',1);
        $pdf->SetXY(156,101);
        $pdf->Cell(25,5,'',1);


        $x = 14;
        $y = 101;

        for ($i=0;$i<32;$i++)
        {
            $y = $y+5;
            $pdf->SetXY($x,$y);
            $pdf->Cell(22,5,$formData['jours'][$i]['heures_date'],1);
            //$pdf->SetXY($x+17,$y);
            //$pdf->Cell(20,5,$formData['jours'][$i]->participant,1);
            $pdf->SetXY($x+22,$y);
            $pdf->Cell(30,5,$time->TimeToString($formData['jours'][$i]['eft']),1);
            $pdf->SetXY($x+52,$y);
            $pdf->Cell(30,5,$time->TimeToString($formData['jours'][$i]['gratuit']),1);//gratuit
            $pdf->SetXY($x+82,$y);
            $pdf->Cell(30,5,$time->TimeToString($formData['jours'][$i]['payant']),1);
            $pdf->SetXY($x+112,$y);
            $pdf->Cell(30,5,$time->TimeToString($formData['jours'][$i]['stage']),1);
            $pdf->SetXY($x+142,$y);
            $pdf->Cell(25,5,$time->TimeToString($formData['jours'][$i]['assimile']),1);


        }
        $pdf->SetXY(14,261);
        $pdf->Cell(22,5,'TOTAL',1);
        $pdf->SetXY(36,261);
        $pdf->Cell(30,5,$time->TimeToString($formData['eft']),1);
        $pdf->SetXY(66,261);
        $pdf->Cell(30,5,$time->TimeToString($formData['gratuit']),1);
        $pdf->SetXY(96,261);
        $pdf->Cell(30,5,$time->TimeToString($formData['payant']),1);
        $pdf->SetXY(126,261);
        $pdf->Cell(30,5,$time->TimeToString($formData['stage']),1);
        $pdf->SetXY(156,261);
        $pdf->Cell(25,5,$time->TimeToString($formData['assimile']),1);


        $pdf->Text(14,270,utf8_decode('Certifié sincère et exact'));
        $pdf->Text(96,270,utf8_decode('Nom du responsable de l\'organisme :'));
        $pdf->Text(14,275,utf8_decode('Le '.date('d/m/Y')));


        $pdf->SetXY(14,270);
        $pdf->SetFont('Arial', '', 6);
        //$pdf->drawTextBox(utf8_decode('(1) Pour les définitions, on se reportera au point 6 de l\annexe 1 de la circulaire ministérielle du 02 mai 2007'),'','','','',0);


        $pdf->Output();
    }
}

?>