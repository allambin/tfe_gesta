<?php

//include 'MaitrePylosExcel.php';


namespace Maitrepylos\Excel;

class Statexcel
{

    public static function excel($data,$groupe)
    {

        $workbook = new \MaitrePylos\Excel();

        $sheet = array();

        //on crée la feuille par défaut
        $sheet[0] = $workbook->getActiveSheet();
        $sheet[0]->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        //on donne un nom à la feuille
        $sheet[0]->setTitle($data['groupe'][0]['t_nom']);

        $count = count($data['groupe']);
        for($i=1;$i<$count;$i++) {
            $sheet[$i] = $workbook->createSheet();
            $sheet[$i]->setTitle($data['groupe'][$i]['t_nom']);
        }

        for($i=0;$i<$count;$i++) {


            $sheet[$i]->setCellValueByColumnAndRow(0,1,'NOM');
            $sheet[$i]->setCellValueByColumnAndRow(1,1,'PRENOM');
            $sheet[$i]->setCellValueByColumnAndRow(2,1,'DATE ENTREE');
            $sheet[$i]->setCellValueByColumnAndRow(3,1,'Heures Eft-Rw');
            $sheet[$i]->setCellValueByColumnAndRow(4,1,'Heures de présences');
            $sheet[$i]->setCellValueByColumnAndRow(5,1,'% de présences');
            $sheet[$i]->setCellValueByColumnAndRow(6,1,'Absence Justifiée');
            $sheet[$i]->setCellValueByColumnAndRow(7,1,'% Absence Justifiée');
            $sheet[$i]->setCellValueByColumnAndRow(8,1,'Absence non Justifiée');
            $sheet[$i]->setCellValueByColumnAndRow(9,1,' % Absence non Justifiée');
            $sheet[$i]->setCellValueByColumnAndRow(10,1,'Congé');
            $sheet[$i]->setCellValueByColumnAndRow(11,1,'Suivi Social');
            $sheet[$i]->setCellValueByColumnAndRow(12,1,'Mois de présence');

           // $sheet->getColumnDimension($i)->setAutoSize(true);

            $sheet[$i]->getColumnDimension('A')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('B')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('C')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('D')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('E')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('F')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('G')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('H')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('I')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('J')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('K')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('L')->setAutoSize(true);
            $sheet[$i]->getColumnDimension('M')->setAutoSize(true);
            $sheet[$i]->duplicateStyleArray(array(
                'font'=>array(
                    'bold'=>true)), 'A1:M1');

        }

        /**
         * gestion des heures , par rapport à son string
         */
        $filtre = \Maitrepylos\Helper::time();



        for($i=0;$i<$count;$i++) {
            $compteur = count($groupe[$data['groupe'][$i]['t_nom']]);

            for($a=0;$a<$compteur;$a++) {
                $sheet[$i]->setCellValueByColumnAndRow(0,($a+2),$groupe[$data['groupe'][$i]['t_nom']][$a]['t_nom']);
                $sheet[$i]->setCellValueByColumnAndRow(1,($a+2),utf8_encode($groupe[$data['groupe'][$i]['t_nom']][$a]['t_prenom']));
                $sheet[$i]->setCellValueByColumnAndRow(2,($a+2),$groupe[$data['groupe'][$i]['t_nom']][$a]['d_date_debut_contrat']);


//                $sheet[$i]->getStyleByColumnAndRow(3,($a+2))->getNumberFormat()->applyFromArray(
//                    array(
//                        'code' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3
//                    )
//                );
                $sheet[$i]->setCellValueByColumnAndRow(3,($a+2),$filtre->TimeToString($groupe[$data['groupe'][$i]['t_nom']][$a]['heures_eft_rw']));
                $sheet[$i]->setCellValueByColumnAndRow(4,($a+2),$filtre->TimeToString($groupe[$data['groupe'][$i]['t_nom']][$a]['heures_full']));
                $sheet[$i]->setCellValueByColumnAndRow(5,($a+2),round($groupe[$data['groupe'][$i]['t_nom']][$a]['pourcent_present'],2).'%');
                $sheet[$i]->setCellValueByColumnAndRow(6,($a+2),$filtre->TimeToString($groupe[$data['groupe'][$i]['t_nom']][$a]['heures_absenceJ']));
                $sheet[$i]->setCellValueByColumnAndRow(7,($a+2),round($groupe[$data['groupe'][$i]['t_nom']][$a]['pourcent_absentj'],2).'%');
                $sheet[$i]->setCellValueByColumnAndRow(8,($a+2),$filtre->TimeToString($groupe[$data['groupe'][$i]['t_nom']][$a]['heures_absenceNJ']));
                $sheet[$i]->setCellValueByColumnAndRow(9,($a+2),round($groupe[$data['groupe'][$i]['t_nom']][$a]['pourcent_absentnj'],2).'%');
                $sheet[$i]->setCellValueByColumnAndRow(10,($a+2),$filtre->TimeToString($groupe[$data['groupe'][$i]['t_nom']][$a]['heures_conge']));
                $sheet[$i]->setCellValueByColumnAndRow(11,($a+2),$filtre->TimeToString($groupe[$data['groupe'][$i]['t_nom']][$a]['heures_social']));
                $sheet[$i]->setCellValueByColumnAndRow(12,($a+2),$groupe[$data['groupe'][$i]['t_nom']][$a]['heures_mois']);

            }

            $sheet[$i]->setCellValueByColumnAndRow(0,($a+3),'TOTAL');
            $sheet[$i]->setCellValueByColumnAndRow(3,($a+3),
                $filtre->TimeToString($groupe['total_heureEftRw'][$data['groupe'][$i]['t_nom']]));
            $sheet[$i]->setCellValueByColumnAndRow(4,($a+3),
                $filtre->TimeToString($groupe['total_heure'][$data['groupe'][$i]['t_nom']]));
            $sheet[$i]->setCellValueByColumnAndRow(6,($a+3),
                $filtre->TimeToString($groupe['total_absenceJ'][$data['groupe'][$i]['t_nom']]));
            $sheet[$i]->setCellValueByColumnAndRow(8,($a+3),
                $filtre->TimeToString($groupe['total_absenceNJ'][$data['groupe'][$i]['t_nom']]));
            $sheet[$i]->setCellValueByColumnAndRow(9,($a+3),
                $filtre->TimeToString($groupe['total_conge'][$data['groupe'][$i]['t_nom']]));
            $sheet[$i]->setCellValueByColumnAndRow(10,($a+3),
                $filtre->TimeToString($groupe['total_social'][$data['groupe'][$i]['t_nom']]));
        }


        $workbook->affiche('Excel5','Stat'.date('Y-m-d-H:s'));
        // $workbook->enregistre();
    }

}