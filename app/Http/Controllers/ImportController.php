<?php

namespace App\Http\Controllers;

use App\Grave;
use Illuminate\Http\Request;

use App\Http\Requests;
use PHPExcel_IOFactory;

class ImportController extends Controller
{
    public function excel()
    {
        $file = public_path().'/excel.xlsx';
        $objPHPExcel = PHPExcel_IOFactory::createReaderForFile($file);
        $objXLS = $objPHPExcel->load($file);
        $sheet = $objXLS->getSheet(0);
        $startValue = 2;
        $currentRow = $startValue;


        $data = [];
        while (true)
        {
            $numGrave = $sheet->getCell("A".$currentRow)->getValue();
            $nameCemetery = $sheet->getCell("B".$currentRow)->getValue();
            $fioDead = $sheet->getCell("C".$currentRow)->getValue();
            $yearBorn = $sheet->getCell("D".$currentRow)->getValue();
            $yearDeath = $sheet->getCell("E".$currentRow)->getValue();
            $numDeads = $sheet->getCell("F".$currentRow)->getValue();
            $sizeGrave = $sheet->getCell("G".$currentRow)->getValue();
            $hasBorder = $sheet->getCell("H".$currentRow)->getValue();
            $border = $sheet->getCell("I".$currentRow)->getValue();
            $memorial = $sheet->getCell("J".$currentRow)->getValue();
            $memorialMaterial = $sheet->getCell("K".$currentRow)->getValue();
            $sizeMemorial = $sheet->getCell("L".$currentRow)->getValue();
            $state = $sheet->getCell("M".$currentRow)->getValue();
            $isWow = $sheet->getCell("N".$currentRow)->getValue();

            if ($numGrave != 0)
            {
//                $grave = new Grave();
//                $grave->saveFromData($data);

                $data = [];
            }
            $data[] = ["numGrave" => $numGrave, "nameCemetery" => $nameCemetery, "fioDead" => $fioDead, "yearBorn" => $yearBorn, "yearDeath" => $yearDeath, "numDeads" => $numDeads, "sizeGrave" => $sizeGrave, "hasBorder" => $hasBorder, "border" => $border, "memorial" => $memorial, "memorialMaterial" => $memorialMaterial, "sizeMemorial" => $sizeMemorial, "state" => $state, "isWow" => $isWow];
        }

        return "";

    }
}
