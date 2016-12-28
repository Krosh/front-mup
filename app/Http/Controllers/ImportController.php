<?php

namespace App\Http\Controllers;

use App\Forms\UploadXmlForm;
use App\Models\Grave;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;
use PHPExcel_IOFactory;

class ImportController extends Controller
{

    public function regsystem()
    {
        $dateTime = new DateTime();
        $dateTime->modify('-10 days');
        $date = $dateTime->format("Y-m-d");
        $url = "http://regsystem.brn22memory.ru/api/deadWithCoords?date=".$date;
        $file = file_get_contents($url);
        $data = json_decode($file);
        foreach ($data as $item)
        {
            $grave = Grave::loadFromRegsystem($item);
            if (!$grave->exists)
            {
                DB::beginTransaction();
                $deads = $grave->getDeads();
                $graveSaveResult = $grave->save();
                $deads[0]->idGrave = $grave->id;
                $deadSaveResult = $deads[0]->save();
                if (!$graveSaveResult || !$deadSaveResult)
                {
                    DB::rollback();
                    // TODO:: Как-то обработать ошибки
                }
                else
                    DB::commit();
            }
        }
    }

    public function load_xml(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(UploadXmlForm::class, [
            'method' => 'POST',
            'url' => url("/import/save"),
        ]);

        return view('load_xml', ["form" => $form]);
    }

    public function save_xml(Request $request)
    {
        $idCemetery = $request->get("cemetery");
        foreach ($request->file("xml") as $file)
        {
            $filePath = $file->getRealPath();
            $this->xml($idCemetery, $filePath);
        }
        return back()->with("result",["class" => "alert-success", "text" => "Данные успешно загружены"]);
    }

    public function xml($idCemetery, $filePath)
    {
        $file = file_get_contents($filePath);

        $xml = new \SimpleXMLElement($file);
        foreach ($xml->wpt as $item)
        {
            $attributes = $item->attributes();
            $lat = $attributes["lat"];
            $lon = $attributes["lon"];
            $numGrave = ltrim($item->name,"0");
            $grave = Grave::where("numGrave",$numGrave)
                ->where("idCemetery",$idCemetery)
                ->first();
            if ($grave != null)
            {
                $grave->latitude = $lat;
                $grave->longitude = $lon;
                $grave->save();
            }

        }

    }

    public function excel()
    {
        $file =  "/home/ritualuh/public_html/excel.xlsx";
        $objPHPExcel = PHPExcel_IOFactory::createReaderForFile($file);
        $objXLS = $objPHPExcel->load($file);
        $sheet = $objXLS->getSheet(0);
        $startValue = 2;
        $currentRow = $startValue;
        $maxRow = $sheet->getHighestRow();

        $data = [];
        while ($currentRow < $maxRow)
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
            $ww2 = $sheet->getCell("N".$currentRow)->getValue();

            if ($numGrave != 0)
            {
                if ($data != [])
                {
                    $grave = Grave::loadFromData($data);
                    $grave->save();
                    $grave->saveDeads();

                    $data = [];
                }
            }
            $newRow = ["numGrave" => $numGrave, "nameCemetery" => $nameCemetery, "fioDead" => $fioDead, "yearBorn" => $yearBorn, "yearDeath" => $yearDeath, "numDeads" => $numDeads, "sizeGrave" => $sizeGrave, "hasBorder" => $hasBorder, "border" => $border, "memorial" => $memorial, "memorialMaterial" => $memorialMaterial, "sizeMemorial" => $sizeMemorial, "state" => $state, "ww2" => $ww2];
            $data[] = $newRow;
            $currentRow++;
        }
        var_dump($currentRow);
        return "";
    }
}
