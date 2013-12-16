<?php

//include 'MaitrePylosExcel.php';


namespace Maitrepylos\Excel;

class L3excel
{

    public static function excel($data)
    {

        $workbook = new \MaitrePylos\Excel();

        $sheet = array();

        //on crée la feuille par défaut
        $sheet = $workbook->getActiveSheet();
        $sheet->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);


        //on donne un nom à la feuille
        $sheet->setTitle('Annexe 1 stagiaire en formation');
        //on fusionne les cellules de A1 à D1
        $sheet->mergeCells('A1:D1');
        //on met les cellules à la taille définies.
        $sheet->getColumnDimension('A')->setWidth(28);
        $sheet->getColumnDimension('B')->setWidth(21);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(19);
        $sheet->getRowDimension('2')->setRowHeight(70);

        //Mise en forme de la cellule A1
        $styleA1 = $sheet->getStyle('A1');
        $styleA1->applyFromArray(
            array(
                'font' => array(
                    'name' => 'Arial',
                    'size' => 12,
                    'bold' => true),
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN))
            )
        );
        $sheet->duplicateStyle($styleA1, 'B1:D1');


        $sheet->setCellValue('A1', 'ANNEXE 1 : NOMBRE DE STAGIAIRES EN FORMATION EN ' . $data['annee']);

        //Mise en forme de la cellule A2
        $styleA2 = $sheet->getStyle('A2');
        $styleA2->applyFromArray(array(
            'font' => array(
                'size' => 10,
                'name' => 'Arial'
            ),
            'alignment' => array(
                'wrap' => true
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN))
        ));

        $sheet->duplicateStyle($styleA2, 'B2:D2'); //on applique le style de A2 aux cellules B2-C2-D2
        $sheet->setCellValue('A2', 'FILIERE CONCERNE + CODE CEDEFOP');
        $sheet->setCellValue('B2', 'Nombre de stagiaires répondant aux conditions du Décret (et  ayant signé un contrat de formation) et ayant suivi partiellement ou totalement la formation (1)');
        $sheet->setCellValue('C2', 'Nombre de stagiaires sous dérogation (2)');
        $sheet->setCellValue('D2', 'Nombre total de stagiaires ayant suivi partiellement ou totalement la formation (1) + (2)');

        $styleA3 = $sheet->getStyle('A3');
        $styleA3->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN))));
        $sheet->duplicateStyle($styleA3, 'A3:D26');

        //Comme les 23 prochaine lignes sont identiques on fais une boucle, et on met une formule dans
        // chaque ligne.
        for ($i = 0; $i < 24; $i++) {

            $cellule = (3 + $i);
            $sheet->setCellValueByColumnAndRow(0, $cellule, $data['annexe1'][1][$i]['t_nom']
                . '-' . $data['annexe1'][1][$i]['i_code_cedefop']);

            if ($data['annexe1'][1][$i]['compteur'] == 0) {

                $sheet->setCellValueByColumnAndRow(1, $cellule, $data['annexe1'][1][$i]['compteur']);
            } else {
                $sheet->setCellValueByColumnAndRow(1, $cellule, $data['annexe1'][1][$i]['resultat']);
            }
            $sheet->setCellValueByColumnAndRow(2, $cellule, $data['annexe1'][1][$i]['derogation']);
            $sheet->setCellValueByColumnAndRow(3, $cellule, '=SUM(B' . $cellule . ':C' . $cellule . ')');

        }

        $styleA27 = $sheet->getStyle('A27');
        $styleA27->applyFromArray(array(
            'font' => array(
                'bold' => true,
                'size' => 10,
                'name' => 'Arial'),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN))
        ));

        $sheet->setCellValue('A27', 'TOTAL ORGANISME');
        $sheet->duplicateStyle($styleA27, 'B27:D27');
        $sheet->setCellValue('B27', '=SUM(B3:B26)');
        $sheet->setCellValue('C27', '=SUM(C3:C26)');
        $sheet->setCellValue('D27', '=SUM(D3:D26)');

        foreach ($data['filiere'] AS $key=>$value) {
            /*********************************************************
             *
             * Création des annexes 2
             *******************************************************/
            //trouver  le cedefop
            //$cedefop = \Maitrepylos\Utils::cedefop($data['cedefop'], $value);
            //création de la nouvelle feuille
            $sheet_array1[$key] = $workbook->createSheet();
            //nom de la feuille
            $sheet_array1[$key]->setTitle('Annexe 2 '.$key);
            \Maitrepylos\Excel\Annexe::excel($sheet_array1[$key],$data['xml'],$value,$key,$data['annee'],$data['agrement']->t_agrement);

        }

        /**
         * mise en commentaire pour test
         */
        foreach ($data['filiere'] AS $key => $value) {
            /*********************************************************
             *
             * Création des annexes 3
             *******************************************************/
            //trouver  le cedefop
            //$cedefop = \Maitrepylos\Utils::cedefop($data['cedefop'], $value);
            $sheet_array2[$key] = $workbook->createSheet();
            $sheet_array2[$key]->setTitle('Annexe 3 '.$key);
            \Maitrepylos\Excel\Stagiaire::excel($sheet_array2[$key],$value,$key,$data['annee']);

        }


        //$workbook->enregistre('Excel2007');
        $workbook->affiche('Excel5', 'stat_annuelle_'.$data['agrement']->t_agrement.'_'.$data['annee'].'_'.date('Y-m-d-H:s'));
        //   \Maitrepylos\Debug::dump( \Maitrepylos\Excel\Stagiaire::excel($sheet_array2[$value],$cedefop,$data['participant-'.$value],
        //       $data['heure-'.$value] ,$data['xml'],$value,$data['annee']));
    }

}