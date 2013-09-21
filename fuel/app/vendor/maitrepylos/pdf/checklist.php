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
    public static function pdf($checklist_valeurs, $checklist_sections, $checklist)
    {

        $pdf = \Pdf::forge('mpdf');


        $html = '<h1>Checklist</h1>';

        /*<?php echo Form::open(array('class' => 'form-horizontal')); ?>*/

        foreach ($checklist_sections as $section_id => $section) {
            $html .= '<h3>' . $section . '</h3>';
            foreach ($checklist_valeurs as $valeur) {

                if ($valeur->section == $section_id) {
                    $html .= '<p>';
                    $html .= $valeur->tnom;

                    if (isset($checklist) && in_array($valeur->id, $checklist)) {
                        $html .= \Form::checkbox('list[]', $valeur->id, array('checked' => 'checked'));
                    } else {
                        $html .= \Form::checkbox('list[]', $valeur->id);
                    }
                    $html .= '</p>';

                }

            }
        }


        $pdf->WriteHTML($html);


        ob_end_clean();
        $pdf->Output();
    }
}

