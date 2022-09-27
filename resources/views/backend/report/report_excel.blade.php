<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
    ->setLastModifiedBy('Maarten Balliauw')
    ->setTitle('Office 2007 XLSX Test Document')
    ->setSubject('Office 2007 XLSX Test Document')
    ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
    ->setKeywords('office 2007 openxml php')
    ->setCategory('Test result file');

$styleArray_header  = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'allBorders' => [ // กำหนดเส้นขอบทั้งหม
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => 'FFA0A0A0',
        ],
        'endColor' => [
            'argb' => 'FFFFFFFF',
        ],
    ],
];


// จัดรูปแบบส่วนของข้อมูล
$styleArray_Data = [
    'borders' => [
        'vertical' => [ //เส้นขอบแนวตั้งด้านใน
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
        'outline' => [ // เส้นขอบด้านนอก
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];


// $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);          
$sheet = $spreadsheet->getActiveSheet()->setShowGridlines(false); // กรณีปิดเส้น
// $sheet = $spreadsheet->getActiveSheet(); 
$pageMargins = $sheet->getPageMargins();

// margin is set in inches (0.5cm)
$margin = 0.5 / 2.54;

$pageMargins->setTop($margin);
$pageMargins->setBottom($margin);
$pageMargins->setLeft($margin);
$pageMargins->setRight(0);


$styleHeader1 = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),


    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],

    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ),

);

$styleHeader = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allBorders' => array(
            // 'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            // 'color' => array('rgb' => 'FFA0A0A0'),
        )
    ),

    // 'borders' => [
    //     'top' => [
    //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //     ],
    // ],

    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ),
 
    // 'fill' => [
    //     'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
    //     'rotation' => 90,
    //     'startColor' => [
    //         'argb' => 'FF21C7E2',
    //     ],
    //     'endColor' => [
    //         'argb' => 'FFFFFFFF',
    //     ],
    // ],
);
$styleNumber = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    )
);
$styleText = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    )
);
$styleText_green = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
        'color' => array('rgb' => '21BA21'),
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    )
);
$styleText_red = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
        'color' => array('rgb' => 'FF0000'),
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    )
);
// 'color' => array('rgb' => '32CD32'),
$styleTextCenter = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    // 'borders' => array(
    //     'allborders' => array(
    //         'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //         'color' => array('rgb' => '#000000')
    //     )
    // ),
    'borders' => array(
        'allBorders' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    )
);

$styleTextCenter_1 = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    // 'borders' => array(
    //     'allborders' => array(
    //         'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //         'color' => array('rgb' => '#000000')
    //     )
    // ),
    'borders' => array(
        'allBorders' => array(
            
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    )
);

$styleTextLeft = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    // 'borders' => array(
    //     'allborders' => array(
    //         'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //         'color' => array('rgb' => '#000000')
    //     )
    // ),
    'borders' => array(
        'allBorders' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'wrap' => true
    )
);

$styleTextRight = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    // 'borders' => array(
    //     'allborders' => array(
    //         'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //         'color' => array('rgb' => '#000000')
    //     )
    // ),
    'borders' => array(
        'allBorders' => array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        )
    ),
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    )
);

$columnCharacter = array(
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
    'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP',
    'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK',
    'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ'
);

// หัวตาราง
$rowCell = 2;
$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'No.');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(10);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'Employee Code');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(20);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'Employee SAP');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(20);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'Prefix');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'Name');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'Surname');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'คำนำหน้า');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'ชื่อ');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'นามสกุล');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, 'Position');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[9])->setWidth(20);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, 'Section');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[10])->setWidth(20);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, 'Department');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[11])->setWidth(20);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, 'Hired Date');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[12])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, 'Departed Date');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[13])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, 'Status');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[14])->setWidth(10);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, 'Shift');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[15])->setWidth(10);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, 'Gender');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[16])->setWidth(10);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, 'Cost Center');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[17])->setWidth(13);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, 'Training Subject');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[18])->setWidth(20);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, 'VDO Duration');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[19])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[20] . $rowCell, 'Assigned Training');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[20] . $rowCell . ':' . $columnCharacter[20] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[20])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[21] . $rowCell, 'Training Due Date');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[21] . $rowCell . ':' . $columnCharacter[21] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[21])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[22] . $rowCell, 'Training Start Date');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[22] . $rowCell . ':' . $columnCharacter[22] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[22])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[23] . $rowCell, 'Training Start Time');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[23] . $rowCell . ':' . $columnCharacter[23] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[23])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[24] . $rowCell, 'Training End Time');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[24] . $rowCell . ':' . $columnCharacter[24] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[24])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[25] . $rowCell, 'Training Duration Time');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[25] . $rowCell . ':' . $columnCharacter[25] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[25])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[26] . $rowCell, 'Completed Test Date');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[26] . $rowCell . ':' . $columnCharacter[26] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[26])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[27] . $rowCell, 'Test Score');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[27] . $rowCell . ':' . $columnCharacter[27] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[27])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[28] . $rowCell, 'Test Passed');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[28] . $rowCell . ':' . $columnCharacter[28] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[28])->setWidth(15);

$spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[29] . $rowCell, 'Training Status');
$spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[29] . $rowCell . ':' . $columnCharacter[29] . ($rowCell));
$spreadsheet->getActiveSheet()->getColumnDimension($columnCharacter[29])->setWidth(15);
$spreadsheet->getActiveSheet()->getStyle($columnCharacter[0] . ($rowCell).':' . $columnCharacter[29] . ($rowCell))->applyFromArray($styleHeader);  

$train_list = DB::table('sg_train_list')->get();
if($train_list)
{
    $i=0;
    foreach($train_list as $tl)
    {
        $sg_train = DB::table('sg_train')->where('id',$tl->sg_train_id)->first();
        $sg_train_emp = DB::table('sg_train_emp')->where('id_train',$tl->sg_train_id)->get();
        if($sg_train_emp)
        {
            foreach($sg_train_emp as $emp)
            {
                $staff = DB::table('sg_employee')->where('code',$emp->id_emp)->first();
            
                $i++;
                $rowCell++;
                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, "$i");
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell)); // No

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, "$emp->id_emp");
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell)); // Employee Code

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, "$staff->id_sap");
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell)); // Employee SAP

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, "$staff->prefixnameeng");
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell)); // Prefix

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, "$staff->nameeng");
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell)); // Name

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, "$staff->lastnameeng");
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell)); // Surname

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, "$staff->prefixnamethai");
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell)); // คำนำหน้า

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, "$staff->namethai");
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell)); // ชื่อ

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, "$staff->lastnamethai");
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell)); // นามสกุล

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, "$staff->position_name"); // position
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, "$staff->section"); // section
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, "$staff->department_name"); // department_name
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, "$staff->hire_date"); // hire_date
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, ""); // Departed  Date 
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, "Active"); // Status
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, "$staff->working_shift"); // Shift
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));

                if($staff->gender == "M")
                {
                    $gender = "Male";
                }
                else
                {
                    $gender = "Female";
                }

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, "$gender"); // Gender
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, "$staff->cost_center"); // Cost Center
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));

                $video = DB::table('sg_video')->where('id',$tl->id_vi)->first();

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, "$tl->vi_detail"); // Training Subject
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, "$video->unit น."); // VDO Duration
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[20] . $rowCell, ""); // Assigned Training
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[20] . $rowCell . ':' . $columnCharacter[20] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[21] . $rowCell, ""); // Training Due Date
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[21] . $rowCell . ':' . $columnCharacter[21] . ($rowCell));

                $start_date = date('d/m/Y',strtotime($tl->created_at));
                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[22] . $rowCell, "$start_date"); // Training Start Date
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[22] . $rowCell . ':' . $columnCharacter[22] . ($rowCell));

              

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[23] . $rowCell, "$tl->vi_time_start"); // Training Start Time
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[23] . $rowCell . ':' . $columnCharacter[23] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[24] . $rowCell, "$tl->vi_time_stop"); // Training End Time
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[24] . $rowCell . ':' . $columnCharacter[24] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[25] . $rowCell, "$tl->vi_time_unit"); // Training Duration Time
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[25] . $rowCell . ':' . $columnCharacter[25] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[26] . $rowCell, ""); // Completed Test Date
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[26] . $rowCell . ':' . $columnCharacter[26] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[27] . $rowCell, ""); // Test Score
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[27] . $rowCell . ':' . $columnCharacter[27] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[28] . $rowCell, ""); // Test Passed
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[28] . $rowCell . ':' . $columnCharacter[28] . ($rowCell));

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($columnCharacter[29] . $rowCell, ""); // Training Status
                $spreadsheet->setActiveSheetIndex(0)->mergeCells($columnCharacter[29] . $rowCell . ':' . $columnCharacter[29] . ($rowCell));
            }
        }
        
        
    }
}

// End

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $namefile . '.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0



$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
