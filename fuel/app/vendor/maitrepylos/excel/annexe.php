<?php

//include 'MaitrePylosExcel.php';


namespace Maitrepylos\Excel;

class Annexe {

    public static function excel($sheet,$xml,$heures,$cedefop,$filiere,$annee){
        //définition des tailles de cellules
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(13);
        $sheet->getColumnDimension('C')->setWidth(13);
        $sheet->getColumnDimension('D')->setWidth(13);
        $sheet->getColumnDimension('E')->setWidth(13);
        $sheet->getColumnDimension('F')->setWidth(13);

        //merge des cellules A1 F1
        $sheet->mergeCells('A1:F1');
        //style par default de la page
        $styleFeuilles = $sheet->getDefaultStyle();
        $styleFeuilles->applyFromArray(array(
            'font'=>array(
                'size'=>10,
                'name'=>'Arial')));
        //style de la cellule A1
        $styleA1 = $sheet->getStyle('A1');
        $styleA1->applyFromArray(array(
                'font'=>array(
                    'bold'=>true,
                ),
                'alignment'=>array(
                    'horizontal'=>\PHPExcel_Style_Alignment::HORIZONTAL_CENTER))
        );
        //valeur de la cellule A1
        $sheet->setCellValue('A1','ANNEXE 2');
        //style des cellules A2 à B5
        $sheet->duplicateStyleArray(array(
            'font'=>array(
                'size'=>8,
                'name'=>'Times New Roman')), 'A2:F4');

        //valeur des cellules suivante
        $sheet->setCellValue('A2','Ministère de la Région wallonne');
        $sheet->setCellValue('A3','Direction de la Formation professionnelle');
        $sheet->setCellValue('A3', 'Place de la Wallonie, 1 – Bât. II');
        $sheet->setCellValue('A4', '5100            JAMBES');

        //modification du style de F2
        $styleF2 = $sheet->getStyle('F2');
        $styleF2->getFont()->setBold(true);
        //valeur
        $sheet->setCellValue('F2','Doc.L.3');

        //style des cellules E5:F6
        $sheet->duplicateStyleArray(array(
            'font'=>array(
                'size'=>10,
                'name'=>'Times New Roman'),
            'borders'=>array(
                'allborders'=>array(
                    'style'=>\PHPExcel_Style_Border::BORDER_THIN))), 'E5:F6');
        $sheet->setCellValue('E5','EFT');
        $sheet->setCellValue('F5','X');
        $sheet->setCellValue('E6', 'OISP');

        $sheet->mergeCells('A10:F10');
        $sheet->mergeCells('A11:F11');
        $sheet->duplicateStyle($styleA1,'A10:F11');
        $sheet->setCellValue('A10','OISP-EFT');
        /* $styleA11 = $sheet->getStyle('A11');*/
        $sheet->duplicateStyleArray(array(
            'borders'=>array(
                'top'=>array(
                    'style'=>\PHPExcel_Style_Border::BORDER_THIN),
                'bottom'=>array(
                    'style'=>\PHPExcel_Style_Border::BORDER_THIN))),'A11:F11');

        $sheet->setCellValue('A11', 'Etat récapitulatif annuel des prestations et des heures assimilées');

        $sheet->duplicateStyleArray(array(
            'borders'=>array(
                'allborders'=>array(
                    'style'=>\PHPExcel_Style_Border::BORDER_THIN))), 'A14:F16');
        $sheet->setCellValue('A14','Nom de l’organisme :'.$xml->denomination);
        $sheet->setCellValue('A15', 'Année : '.$annee);
        $sheet->setCellValue('A16', 'Filière de formation : '.$filiere);
        $sheet->setCellValue('E14', 'N° d\'agrément :  '.$xml->agrement);
        $sheet->setCellValue('E16', 'C. Cedefop : '.$cedefop);
        //mise en page des cellules A21:F37
        $sheet->duplicateStyleArray(array(
            'borders'=>array(
                'allborders'=>array(
                    'style'=>\PHPExcel_Style_Border::BORDER_THIN)),
            'alignment'=>array(
                'horizontal'=>\PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'=>\PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'=>true)), 'A21:F37');
        $sheet->mergeCells('A21:A23');
        $sheet->getRowDimension('23')->setRowHeight(36);
        $sheet->mergeCells('B21:F21');
        $sheet->mergeCells('B22:E22');
        $sheet->mergeCells('F22:F23');

        $sheet->setCellValue('A21', 'Mois');
        $sheet->setCellValue('B21', 'Heures de formation');
        $sheet->setCellValue('B22', 'Dispensees par : ');
        $sheet->setCellValue('B23', 'EFT/
OISP
(1)');
        $sheet->setCellValue('C23', 'Org.
Convent.');
        $sheet->setCellValue('E23', 'Ent. Dans le cadre du stage (4)');
        $sheet->setCellValue('F22', 'Assimilées
(6)');
        $sheet->setCellValue('C24', ' Gratuit (2)');
        $sheet->setCellValue('D24', 'Payant (3)');


        for($i = 0; $i < 12; $i++) {
            $cellule = (25 + $i);
            $mois = \Maitrepylos\Utils::mois($i + 1);
            $sheet->setCellValueByColumnAndRow(0, $cellule, strtoupper($mois));
            //$sheet->setCellValueByColumnAndRowExplicit(1,$cellule,$heures[$i]->eft,PHPExcel_Cell_DataType::TYPE_NUMERIC);
            // $sheet->setCellValueExplicitByColumnAndRow(1,$cellule,$heures[$i]->eft,'h');
            $sheet->setCellValueByColumnAndRow(1, $cellule, $heures[$i]['eft'] / (24 * 3600));
            $sheet->setCellValueByColumnAndRow(2, $cellule, $heures[$i]['gratuit'] / (24 * 3600));
            $sheet->setCellValueByColumnAndRow(3, $cellule, $heures[$i]['payant'] / (24 * 3600));
            $sheet->setCellValueByColumnAndRow(4, $cellule, $heures[$i]['stage'] / (24 * 3600));
            $sheet->setCellValueByColumnAndRow(5, $cellule, $heures[$i]['assimile'] / (24 * 3600));

        }
        $sheet->duplicateStyleArray(array(
            'numberformat'=>array(
                'code'=>'[H]:MM:SS')), 'B25:F47');

        $sheet->getStyle('A37')->getFont()->setBold(true);
        $sheet->setCellValue('A37', 'TOTAL');
        $sheet->setCellValue('B37', '=SUM(B25:B36)');
        $sheet->setCellValue('C37', '=SUM(C25:C36)');
        $sheet->setCellValue('D37', '=SUM(D25:D36)');
        $sheet->setCellValue('E37', '=SUM(E25:E36)');
        $sheet->setCellValue('F37', '=SUM(F25:F36)');
        $sheet->setCellValue('A41', 'Certifié sincère et exact');
        $sheet->setCellValue('E41', 'Nom du responsable de l\'organisme :');
        $sheet->setCellValue('A43', 'Le');
        $sheet->getStyle('B43')->getNumberFormat()->applyFromArray(
            array(
                'code' => 'dd/mm/yyyy'
            )
        );
        $sheet->setCellValue('B43', '=TODAY()');
    }
    //put your code here
}
