<?php

//include 'MaitrePylosExcel.php';


namespace Maitrepylos\Excel;

class Listestagiaire
{

    public static function excel($data,$groupe)
    {

        $workbook = new \MaitrePylos\Excel();

        //on crée la feuille par défaut
        $sheet = $workbook->getActiveSheet();
        $sheet->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        //on donne un nom à la feuille
        $sheet->setTitle($groupe);

        $sheet->setCellValueByColumnAndRow(0,1,'NOM');
        $sheet->setCellValueByColumnAndRow(1,1,'PRENOM');
        $sheet->setCellValueByColumnAndRow(2,1,'ADRESSE');
        $sheet->setCellValueByColumnAndRow(3,1,'TELEPHONE');
        $sheet->setCellValueByColumnAndRow(4,1,'GSM');
        $sheet->setCellValueByColumnAndRow(5,1,'AGE');
        $sheet->setCellValueByColumnAndRow(6,1,'N° NATIONAL');
        $sheet->setCellValueByColumnAndRow(7,1,'CHOMAGE');
        $sheet->setCellValueByColumnAndRow(8,1,'DATE ENTREE');
        $sheet->setCellValueByColumnAndRow(9,1,'DATE SORTIE PREVUE');
        $sheet->setCellValueByColumnAndRow(10,1,'CONTRAT');

        $compteur = count($data);
        for($a=0;$a<$compteur;$a++) {

            $chomage = null;
            if($data[$a]['t_situation_sociale'] == 'B10') {
                $chomage = 'X';
            }



            $sheet->setCellValueByColumnAndRow(0,($a+2),utf8_encode($data[$a]['t_nom']));
            $sheet->setCellValueByColumnAndRow(1,($a+2),utf8_encode($data[$a]['t_prenom']));
            $sheet->setCellValueByColumnAndRow(2,($a+2),$data[$a]['adresse']);
            $sheet->setCellValueExplicitByColumnAndRow(3,($a+2),$data[$a]['t_telephone'],\PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicitByColumnAndRow(4,($a+2),$data[$a]['t_gsm'],\PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueByColumnAndRow(5,($a+2),utf8_encode($data[$a]['age']));
            $sheet->setCellValueByColumnAndRow(6,($a+2),utf8_encode($data[$a]['t_registre_national']));
            $sheet->setCellValueByColumnAndRow(7,($a+2),$chomage);
            $sheet->setCellValueByColumnAndRow(8,($a+2),\Maitrepylos\Date::db_to_date($data[$a]['d_date_debut_contrat']));
            $sheet->setCellValueByColumnAndRow(9,($a+2),\Maitrepylos\Date::db_to_date($data[$a]['d_date_fin_contrat_prevu']));
            $sheet->setCellValueByColumnAndRow(10,($a+2),utf8_encode($data[$a]['t_type_contrat']));


        }

        $workbook->affiche('Excel5');
    }

}