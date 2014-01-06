<?php

//include 'MaitrePylosExcel.php';


namespace Maitrepylos\Excel;

class Stagiaire {

    public static function excel($sheet, $data, $filiere = null, $annee = null)
    {

        $cellule = 12;


        $sheet->getColumnDimension('A')->setWidth(5.9);
        $sheet->getColumnDimension('B')->setWidth(11.5);
        $sheet->getColumnDimension('C')->setWidth(13.1);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(13.7);
        $sheet->getColumnDimension('F')->setWidth(7.12);
        $sheet->getColumnDimension('G')->setWidth(9.6);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(8.3);
        $sheet->getColumnDimension('J')->setWidth(9.5);
        $sheet->getColumnDimension('K')->setWidth(11.25);
        $sheet->getColumnDimension('L')->setWidth(12);
        $sheet->getColumnDimension('M')->setWidth(9.5);
        $sheet->getColumnDimension('N')->setWidth(10);
        $sheet->getColumnDimension('O')->setWidth(10);
        $sheet->getColumnDimension('P')->setWidth(10);
        $sheet->getColumnDimension('Q')->setWidth(11);
        $sheet->getColumnDimension('R')->setWidth(11);
        $sheet->getColumnDimension('S')->setWidth(13.8);
        $sheet->getColumnDimension('T')->setWidth(10.1);
        $sheet->getColumnDimension('U')->setWidth(10.1);
        $sheet->getColumnDimension('V')->setWidth(10);

        $sheet->getRowDimension('1')->setRowHeight(19.9);
        $sheet->getRowDimension('2')->setRowHeight(12.35);
        $sheet->getRowDimension('3')->setRowHeight(15.10);
        $sheet->getRowDimension('4')->setRowHeight(12.35);
        $sheet->getRowDimension('5')->setRowHeight(9.6);
        $sheet->getRowDimension('6')->setRowHeight(13.7);
        $sheet->getRowDimension('7')->setRowHeight(15.1);
        $sheet->getRowDimension('8')->setRowHeight(36.4);
        $sheet->getRowDimension('9')->setRowHeight(30.2);
        $sheet->getRowDimension('10')->setRowHeight(68.7);
        $sheet->getRowDimension('11')->setRowHeight(11.65);
        $sheet->getRowDimension('12')->setRowHeight(19.2);

        $sheet->mergeCells('A1:A8');
        $sheet->mergeCells('B1:G1');
        //  $sheet->mergeCells('H1:P1');
        $sheet->mergeCells('B3:D3');
        $sheet->mergeCells('B4:D4');
        $sheet->mergeCells('E3:M3');
        $sheet->mergeCells('G4:N4');
        $sheet->mergeCells('C5:N5');
        $sheet->mergeCells('B6:D6');
        $sheet->mergeCells('B7:D7');
        $sheet->mergeCells('E6:M6');
        $sheet->mergeCells('C8:F8');
        $sheet->mergeCells('G7:N8');
        $sheet->mergeCells('H1:P1');
        $sheet->mergeCells('O2:P8');
        $sheet->mergeCells('Q2:Q7');
        //$sheet->mergeCells('R1:AE2');
        //$sheet->mergeCells('AF1:AG8');
        $sheet->mergeCells('R3:S3');
        //$sheet->mergeCells('R4:AE5');
        // $sheet->mergeCells('U3:W3');
        $sheet->mergeCells('R6:S6');
        $sheet->mergeCells('U6:W6');
        $sheet->mergeCells('Z3:AE3');
        $sheet->mergeCells('Z6:AE6');
        //$sheet->mergeCells('R7:AE7');
        //$sheet->mergeCells('Q8:T8');
        // $sheet->mergeCells('V8:AE8');
        $sheet->mergeCells('J9:K9');
        // $sheet->mergeCells('O9:P9');
        $sheet->mergeCells('N9:O9');
        $sheet->mergeCells('P9:T9');
        // $sheet->mergeCells('V9:Z9');
        // $sheet->mergeCells('AA9:AE9');

        $sheet->getDefaultStyle()
            ->applyfromArray(array(
                'font' => array(
                    'size' => 8,
                    'name' => 'Arial'),
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap' => true)));
        $sheet->duplicateStyleArray(array(
            'font' => array(
                'size' => 8,
                'bold' => true),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN))), 'H1:P1');

        $bordure = $sheet->getStyle('C3');
        $bordure->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN))));
        $sheet->duplicateStyle($bordure, 'B3:D3');
        $sheet->duplicateStyle($bordure, 'E3:M3');
        $sheet->duplicateStyle($bordure, 'R3:T3');
        $sheet->duplicateStyle($bordure, 'V3:W3');
        $sheet->duplicateStyle($bordure, 'B4:E4');
        $sheet->duplicateStyle($bordure, 'B6:M6');
        $sheet->duplicateStyle($bordure, 'R6:T6');
        // $sheet->duplicateStyle($bordure, 'X6:Y6');
        $sheet->duplicateStyle($bordure, 'B7:E7');
        $sheet->duplicateStyle($bordure, 'B11');
        $sheet->duplicateStyle($bordure, 'V9:W61');
        $sheet->duplicateStyle($bordure, 'B12:U61');
        //  $sheet->duplicateStyle($bordure, 'AG12:AG61');
        $sheet->duplicateStyle($bordure, 'O9:P9');
        $sheet->duplicateStyle($bordure, 'U10');


//        $styleB8 = $sheet->getStyle('B8');
//        $styleB8->applyFromArray(array(
//            'font'=>array(
//            'size'=>8,
//            'bold'=>true),
//            'borders'=>array(
//            'allborders'=>array(
//            'style'=>PHPExcel_Style_Border::BORDER_THIN))));
//        //$sheet->duplicateStyle($styleB8, 'Q8:T8');
//        $sheet->duplicateStyle($styleB8, 'V8:AE8');
        $sheet->getStyle('A9')->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN),
                'left' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN),
                'right' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_NONE)),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFCC99'))));

        $sheet->duplicateStyleArray(array(
            'borders' => array(
                'left' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN),
                'right' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN)),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFCC99'))), 'A10:A11');

        $sheet->duplicateStyleArray(array(
            'borders' => array(
                'left' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN),
                'top' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN),
                'bottom' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN))), 'A12:A60');
        $styleC9 = $sheet->getStyle('C9');
        $styleC9->applyFromArray(array(
            'borders' => array(
                'top' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN),
                'left' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN),
                'right' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN)),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFCC99'))));
        $sheet->duplicateStyle($styleC9, 'D9:T9');
        $sheet->duplicateStyle($styleC9, 'U9:W9');
        $sheet->duplicateStyle($styleC9, 'B9:B11');

        $styleC10 = $sheet->getStyle('C10');
        $styleC10->applyFromArray(array(
            'borders' => array(
                'left' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN),
                'right' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN)),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFCC99'))));
        $sheet->duplicateStyle($styleC10, 'C10:J10');
        $sheet->duplicateStyle($styleC10, 'M10');
        $sheet->duplicateStyle($styleC10, 'T9:T10');
        $sheet->duplicateStyle($styleC10, 'U10:W10');
        $sheet->duplicateStyle($styleC10, 'L10');

        $styleK10 = $sheet->getStyle('K10');
        $styleK10->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN)),
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFCC99'))));
        $sheet->duplicateStyle($styleK10, 'J10');
        $sheet->duplicateStyle($styleK10, 'C11:T11');
        $sheet->duplicateStyle($styleK10, 'N10:T10');
        $sheet->duplicateStyle($styleK10, 'U11:W11');

//        $sheet->duplicateStyleArray(array(
//            'borders'=>array(
//            'left'=>array(
//            'style'=>PHPExcel_Style_Border::BORDER_THIN),
//            'right'=>array(
//            'style'=>PHPExcel_Style_Border::BORDEgR_THIN),
//            'top'=>array(
//            'style'=>PHPExcel_Style_Border::BORDER_THIN),
//            'bottom'=>array(
//            'style'=>PHPExcel_Style_Border::BORDER_THIN))), 'AH12:AH61');

        //code spécifique de date et calcul d'heures
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => '@')), 'B12:D61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => '@')), 'G12:G61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => '00')), 'H12:H61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => '@')), 'I12:I61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => 'd/mm/yyyy')), 'J12:J61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => '00')), 'K12:L61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => '@')), 'M12:M61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => 'd/mm/yyyy')), 'N12:O61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => 'd/mm/yyyy')), 'F12:F61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => '[H]:MM')), 'P12:U61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => '@')), 'V12:V61');
        $sheet->duplicateStyleArray(array(
            'numberformat' => array(
                'code' => '[H]:MM')), 'W12:W61');


        $sheet->setCellValue('H1', 'Recensement annuel des stagiaires en formation');
        $sheet->setCellValue('B3', 'Nom de l\'organisme :');
        $sheet->setCellValue('E3', 'Ateliers de Pontaury');
        $sheet->setCellValue('R3', 'EFT (à marquer d\'une croix)');
        $sheet->setCellValue('T3', 'X');
        $sheet->setCellValue('V3', 'Année (4 chiffres) :');
        $sheet->setCellValue('W3', $annee);
        $sheet->setCellValue('B4', 'Code de l\'organisme (réservé à l\'Administration) :');
        $sheet->setCellValue('B6', 'Domaine de formation (nom de la formation) :');
        $sheet->setCellValue('E6', $filiere);
        $sheet->setCellValue('R6', 'OISP (à marquer d\'une croix)');
        //  $sheet->setCellValue('X6', 'Trimestre (1 chiffre) :');
        $sheet->setCellValue('B7', 'Code formation CEDEFOP (3 chiffres) :');
        //$sheet->setCellValue('B8', 'SEULEMENT POUR LE FSE');
        //$sheet->setCellValue('Q8', 'SEULEMENT POUR LA REGION WALLONNE');
        //$sheet->setCellValue('V8', 'SEULEMENT POUR LE FSE');
        //$sheet->setCellValue('B10', 'Projet FSE ');
        //$sheet->setCellValue('B11', '(1)');
        $sheet->setCellValue('B10', 'Nom');
        $sheet->setCellValue('B11', '(2)');
        $sheet->setCellValue('C10', 'Prénom');
        $sheet->setCellValue('C11', '(3)');
        $sheet->setCellValue('D10', 'Adresse  (facultatif)');
        $sheet->setCellValue('D11', '-');
        $sheet->setCellValue('E10', 'Code Postal');
        $sheet->setCellValue('E11', '(4)');
        $sheet->setCellValue('F10', 'Date de naissance');
        $sheet->setCellValue('F11', '(5)');
        $sheet->setCellValue('G10', 'Sexe');
        $sheet->setCellValue('G11', '(6)');
        $sheet->setCellValue('H10', 'Catégorie de nationalité actuelle');
        $sheet->setCellValue('H11', '(7)');
        $sheet->setCellValue('I10', 'Statut à l\'entrée en formation');
        $sheet->setCellValue('I11', '(8)');
        $sheet->setCellValue('J10', 'Date d\'inscription connue au FOREM ou        à l\'ORBEM');
        $sheet->setCellValue('J11', '(9.1)');
        $sheet->setCellValue('J9', 'Dem. d\'emploi (9)');
        $sheet->setCellValue('K10', 'Durée d\'inoccupation avant l\'entrée en formation');
        $sheet->setCellValue('K11', '(9.2)');
        $sheet->setCellValue('L10', 'Niveau de diplôme');
        $sheet->setCellValue('L11', '(10)');
        $sheet->setCellValue('M10', 'Type d\'ensei-gnement ');
        $sheet->setCellValue('M11', '(11)');
        $sheet->setCellValue('N9', 'Dates (12)');
        $sheet->setCellValue('N10', 'Entrée en formation (jj/mm/aaaa)');
        $sheet->setCellValue('N11', '(12.1)');
        $sheet->setCellValue('O10', 'Sortie de la formation (jj/mm/aaaa)');
        $sheet->setCellValue('O11', '(12.2)');
        $sheet->setCellValue('P9', 'Nombre d\'heures prestées  (13)');
        $sheet->setCellValue('P10', 'DISPENSEES PAR FORMATEUR DE EFT/OISP');
        $sheet->setCellValue('P11', '(13.1)');
        $sheet->setCellValue('Q10', 'DISPENSEES PAR ORG CONVENT GRATUIT');
        $sheet->setCellValue('Q11', '(13.2)');
        $sheet->setCellValue('R10', 'DISPENSEES PAR ORG CONV/VACAT PAYANTES');
        $sheet->setCellValue('R11', '(13.3)');
        $sheet->setCellValue('S10', 'STAGE EN ENTREPRISE (EXTERIEURE)');
        $sheet->setCellValue('S11', '(13.4)');
        $sheet->setCellValue('T10', 'SUIVI PSYCHOSOCIAL/EVALUATION GROUPE /INDIVIDUEL');
        $sheet->setCellValue('T11', '(13.5)');
//        $sheet->setCellValue('V9', 'Nombre d\'heures suivies en fin d\'année civile (13)');
//        $sheet->setCellValue('AA9', 'Nombre d\'heures en fin de projet (14)');
//        $sheet->setCellValue('V10', 'Guidance avant formation');
//        $sheet->setCellValue('V11', '(13.1)');
//        $sheet->setCellValue('W10', 'Formation');
//        $sheet->setCellValue('W11', '(13.2)');
//        $sheet->setCellValue('X10', 'Stage contractualisé en entreprise');
//        $sheet->setCellValue('Y10', 'Guidance après formation');
//        $sheet->setCellValue('Y11', '(13.4)');
//        $sheet->setCellValue('Z10', 'Total');
//        $sheet->setCellValue('Z11', '(13.4)');
//        $sheet->setCellValue('AA10', 'Guidance avant formation');
//        $sheet->setCellValue('AA11', '(14.1)');
//        $sheet->setCellValue('AB10', 'Formation');
//        $sheet->setCellValue('AB11', '(14.2)');
//        $sheet->setCellValue('AC10', 'Stage contractualisé en entreprise');
//        $sheet->setCellValue('AC11', '(14.3)');
//        $sheet->setCellValue('AD10', 'Guidance après formation');
//        $sheet->setCellValue('AD11', '(14.4)');
//        $sheet->setCellValue('AE10', 'Total ');
//        $sheet->setCellValue('AE11', '(14.5)');
        $sheet->setCellValue('U9', 'HEURES ASSIMILEES');
        $sheet->setCellValue('U10', 'Heures');
        $sheet->setCellValue('U11', '(14)');
        $sheet->setCellValue('V10', 'Type et motif de sortie');
        $sheet->setCellValue('V11', '(15)');
        $sheet->setCellValue('W10', 'Total des heures de formation des années précédentes');
        $sheet->setCellValue('W11', '(16)');
        $sheet->setCellValue('E7', $data[0]['i_code_cedefop']);
        //Supprimer le array mois
        unset($data['mois']);
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {

            $cellule = (12 + $i);
            $sheet->setCellValueByColumnAndRow(0, $cellule, ($i + 1));
            $sheet->setCellValueByColumnAndRow(1, $cellule, $data[$i]['signaletique']['t_nom']);
            $sheet->setCellValueByColumnAndRow(2, $cellule, $data[$i]['signaletique']['t_prenom']);
            $sheet->setCellValueByColumnAndRow(3, $cellule, $data[$i]['signaletique']['t_nom_rue']);
            $sheet->setCellValueByColumnAndRow(4, $cellule, $data[$i]['signaletique']['t_code_postal']);
            $sheet->setCellValueByColumnAndRow(5, $cellule, $data[$i]['signaletique']['d_date_naissance']);
            $sheet->setCellValueByColumnAndRow(6, $cellule, $data[$i]['signaletique']['t_sexe']);
            $sheet->setCellValueByColumnAndRow(7, $cellule, (int)$data[$i]['signaletique']['t_nationalite']);
            $sheet->setCellValueByColumnAndRow(8, $cellule, $data[$i]['signaletique']['t_situation_sociale']);
            $sheet->setCellValueByColumnAndRow(9, $cellule, $data[$i]['signaletique']['d_date_inscription_forem']);
            $sheet->setCellValueByColumnAndRow(10, $cellule, $data[$i]['signaletique']['t_duree_innoccupation']);
            $sheet->setCellValueByColumnAndRow(11, $cellule, $data[$i]['signaletique']['t_diplome']);
            $sheet->setCellValueByColumnAndRow(12, $cellule, $data[$i]['signaletique']['t_type_etude']);
            $sheet->setCellValueByColumnAndRow(13, $cellule, $data[$i]['signaletique']['d_date_debut_contrat']);

            if ($data[$i]['signaletique']['d_date_fin_contrat'] != null) {

                /**
                 * Si on regénère un trimestrielle à une année antérieur on affiche pas les données due à une annèe postérieur
                 *
                 * Exemple si on génère 2012, on affiche pas les données de 2013
                 */
                $date_fin = \DateTime::createFromFormat('d-m-Y', $data[$i]['signaletique']['d_date_fin_contrat']);

                $date_affiche = null;
                if ($date_fin->format('Y') == $annee) {
                    $date_affiche = $data[$i]['signaletique']['d_date_fin_contrat'];

                } else {
                    //on met la fin de contrat dans la même situation.
                    $data[$i]['type_fin_contrat']['t_fin_formation_suite'] = null;

                }
            }


//            $sheet->setCellValueByColumnAndRow(14, $cellule, $date_affiche);
//            $sheet->setCellValueByColumnAndRow(15, $cellule, $data[$i]['eft'] / (24 * 3600) * 0.9);
//            $sheet->setCellValueByColumnAndRow(16, $cellule, $data[$i]['gratuit'] / (24 * 3600) * 0.9);
//            $sheet->setCellValueByColumnAndRow(17, $cellule, $data[$i]['payant'] / (24 * 3600) * 0.9);
//            $sheet->setCellValueByColumnAndRow(18, $cellule, $data[$i]['stage'] / (24 * 3600) * 0.9);
            $sheet->setCellValueByColumnAndRow(15, $cellule, $data[$i]['eft'] / (24 * 3600));
            $sheet->setCellValueByColumnAndRow(16, $cellule, $data[$i]['gratuit'] / (24 * 3600));
            $sheet->setCellValueByColumnAndRow(17, $cellule, $data[$i]['payant'] / (24 * 3600));
            $sheet->setCellValueByColumnAndRow(18, $cellule, $data[$i]['stage'] / (24 * 3600));

            $suiviSocial =
                ($data[$i]['eft'] + $data[$i]['gratuit'] + $data[$i]['payant'] + $data[$i]['stage']) / (24 * 3600);
            $suiviSocial = $suiviSocial * 0.1;

            $sheet->setCellValueByColumnAndRow(19, $cellule, $suiviSocial);
            $sheet->setCellValueByColumnAndRow(20, $cellule, $data[$i]['assimile'] / (24 * 3600));
            $sheet->setCellValueByColumnAndRow(21, $cellule, $data[$i]['type_fin_contrat']['t_fin_formation_suite']);

            $sheet->setCellValueByColumnAndRow(22, $cellule, $data[$i]['precedente'] / (24 * 3600));

            //$sheet->setCellValueByColumnAndRow(15,$cellule,$data[$i][14]);
        }
        $Newcellule = $cellule + 1;
        $sheet->setCellValueByColumnAndRow(14, $Newcellule, 'TOTAUX');
        $sheet->setCellValueByColumnAndRow(15, $Newcellule, '=SUM(P12:P' . $cellule . ')');
        $sheet->setCellValueByColumnAndRow(16, $Newcellule, '=SUM(Q12:Q' . $cellule . ')');
        $sheet->setCellValueByColumnAndRow(17, $Newcellule, '=SUM(R12:R' . $cellule . ')');
        $sheet->setCellValueByColumnAndRow(18, $Newcellule, '=SUM(S12:S' . $cellule . ')');
        $sheet->setCellValueByColumnAndRow(19, $Newcellule, '=SUM(T12:T' . $cellule . ')');
        $sheet->setCellValueByColumnAndRow(20, $Newcellule, '=SUM(U12:U' . $cellule . ')');
        $sheet->setCellValueByColumnAndRow(22, $Newcellule, '=SUM(W12:W' . $cellule . ')');

        $sheet->setCellValueByColumnAndRow(1, ($cellule + 6), 'MAL');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 6), 'Maladie ou accident du travail (max 1 mois d\'un seu tenant) couvert par certificat médical. Durée obligatoirement précédée d\'un minimum de 2 semaines de formation.');
        $sheet->setCellValueByColumnAndRow(1, ($cellule + 7), 'ONEM');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 7), 'Convocation à l\'ONEM');
        $sheet->setCellValueByColumnAndRow(1, ($cellule + 8), 'TRIB');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 8), 'Convocation par un Juge');
        $sheet->setCellValueByColumnAndRow(1, ($cellule + 9), 'EMP');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 9), 'Rendez-vous dans le cadre de la recherche d\'emploi');
        $sheet->setCellValueByColumnAndRow(1, ($cellule + 10), 'DEC');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 10), 'Déces d\'un parent (4 jours ouvrables pour un parent ou allié au premier degré habitant sous le même toit, 2 jours pour un parent ou allié au deuxième ou troisième degré n\'habitant  pas sous le même toit)');
        $sheet->setCellValueByColumnAndRow(1, ($cellule + 11), 'GRE');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 11), 'Grève des transports en commun');
        $sheet->setCellValueByColumnAndRow(1, ($cellule + 12), 'ENF');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 12), 'Absence pour maladie d\'un enfant');
        $sheet->setCellValueByColumnAndRow(1, ($cellule + 13), 'CPAS');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 13), 'Convocation au CPAS');
        $sheet->setCellValueByColumnAndRow(1, ($cellule + 14), 'INJ');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 14), 'Les absences injustifiées (maximum 10 % des heures de formation du programme, plafonnées à 5 jours/an)');
        $sheet->setCellValueByColumnAndRow(1, ($cellule + 15), 'SORT');
        $sheet->setCellValueByColumnAndRow(2, ($cellule + 15), 'Il s\'agit ici des heures non-dispensées aux stagiaires sortis pour entrer en formation qualifiante ou en emploi et pour autant qu\'ils aient participé à 50 % à au moins du programme de formation et que le remplacement soit impossible.');


    }

}