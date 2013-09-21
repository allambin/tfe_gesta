<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gg
 * Date: 13/08/12
 * Time: 11:17
 * To change this template use File | Settings | File Templates.
 */

namespace Document;

class Controller_Pdf extends \Controller_Main
{

    public function before(){


    }


    public function action_l1()
    {

//        $pdf = \Pdf::forge('fpdf',array('P', 'mm', 'A4'));
//        $pdf->AddPage();
//        $pdf->SetFont('Arial', 'B', 16);
//        $pdf->Cell(40, 10, 'Hello World!');
//        $pdf->drawTextBox(utf8_decode('Total à payer : 125 euro'), 100, 8);
//
        $this->template->title = 'Gestion des documents';
        $this->template->content = \View::forge('test');


    }


}
