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


class Checklist
{

    /**
     *Genere le Pdf
     *@method pdf
     * @return pdf
     */
    public static function pdf($stagiaire_id)
    {
        include PKGPATH.'pdf/vendor/fpdf/fpdf.php';
        $pdf=new \FPDF();
        $pdf->AddPage();
        
        $stagiaire = \Model_Listeattente::find($stagiaire_id, array('related' => array('checklist')));
        
        $checklist_model = \Model_Checklist_Section::find('all', array('related' => 'valeurs', 'order_by' => 't_nom'));
        $current_checklist = array();
        if(count($stagiaire->checklist) > 0)
        {
            foreach ($stagiaire->checklist as $value)
                $current_checklist[$value->id_checklist_valeur] = $value->id_checklist_valeur;
        }

        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(0,10, 'Checklist de '.$stagiaire->t_nom.' '.$stagiaire->t_prenom);
        $pdf->Ln(20);

        foreach ($checklist_model as $section)
        {
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(0,10, utf8_decode($section->t_nom));
            $pdf->Ln(10);
            
            $pdf->SetFont('Arial','',12);
            
            foreach ($section->valeurs as $valeur)
            {
                if (isset($current_checklist[$valeur->id_checklist_valeur]))
                {
                    $pdf->Cell(10,7, 'X');
                    $pdf->Cell(40,7, utf8_decode($valeur->t_nom));
                    $pdf->Ln();
                }
                else
                {
                    $pdf->Cell(10,7, 'O');
                    $pdf->Cell(40,7, utf8_decode($valeur->t_nom));
                    $pdf->Ln();
                }
            }
        }
        
        $pdf->Output();        
    }
}

