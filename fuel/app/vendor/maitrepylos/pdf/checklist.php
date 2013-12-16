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
        $stagiaire = \Model_Listeattente::find($stagiaire_id, array('related' => array('checklist')));
        
        $checklist_model = \Model_Checklist_Section::find('all', array('related' => 'valeurs', 'order_by' => 't_nom'));
        $current_checklist = array();
        if(count($stagiaire->checklist) > 0)
        {
            foreach ($stagiaire->checklist as $value)
                $current_checklist[$value->id_checklist_valeur] = $value->id_checklist_valeur;
        }
        
        $pdf = \Pdf::forge('mpdf');


        $html = '<h1>Checklist</h1>';

//        foreach ($checklist_model as $section)
//        {
//            $html .= '<h3>' . $section->t_nom . '</h3>';
//            foreach ($section->valeurs as $valeur)
//            {
//
//                $html .= '<p>';
//                $html .= $valeur->t_nom;
//
//                if ($current_checklist[$valeur->id_checklist_valeur])
//                {
//                    $html .= \Form::checkbox('list[]', $valeur->id_checklist_valeur, array('checked' => 'checked'));
//                }
//                else
//                {
//                    $html .= \Form::checkbox('list[]', $valeur->id_checklist_valeur);
//                }
//                $html .= '</p>';
//            }
//        }

        $pdf->WriteHTML($html);die("toto");
//        ob_end_clean();
        $pdf->Output();
//die("toto");
//        exit;
//        $response = new Response();
//        // We'll be outputting a PDF
//        $response->set_header('Content-Type', 'application/pdf');
//        $response->set_header('Content-Disposition', 'attachment; filename="downloaded.pdf"');
//
//        return $response;
    }
}

