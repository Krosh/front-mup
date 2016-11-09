<?php

namespace App\Forms;

use App\Models\City;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\Form;

class CemeteryForm extends Form
{
    public function buildForm()
    {
        $arr = DB::table('cemeteries')->pluck("name","id");
        $cemeteryChoices = [];

        foreach ($arr as $id => $name)
        {
            $cemeteryChoices[$id] = $name;
        }
        $this
            ->add('idCity', 'select',[
                'label' => "Город",
                "choices" => City::allInList("id","name"),
                "empty_value" => "Выберите город",
                'rules' => 'required',
            ])
            ->add("name","text", [
                'rules' => 'required',
                "label" => "Название"
            ])
            ->add('idParentCemetery', 'select',[
                'label' => "Родительское кладбище",
                "choices" => $cemeteryChoices,
                "empty_value" => "Выберите родительское кладбище",
//                'rules' => 'required',
            ])
            ->add("watcher_name","text", [
                "label" => "ФИО смотрителя"
            ])
            ->add("watcher_phone","text", [
                "label" => "Телефон смотрителя"
            ])
            ->add("organisation_name","text", [
                "label" => "Наименование обслуживающей организации"
            ])
            ->add("cadastr_size","static", ["tag" => "div", "label" => "Кадастровая площадь"])
            ->add("hasTestData","checkbox",[
                "label" => "Заполнять тестовыми данными",
                "attr" => [
                    "class" => "js-test-toggle",
                ]
            ])
            ->add("test_square","number",[
                "label" => "Тестовая занятая площадь",
                'wrapper' => ['class' => 'form-group js-test'],
           ])
            ->add("test_graveCount","number",[
                "label" => "Тестовое кол-во захоронений",
                'wrapper' => ['class' => 'form-group js-test'],
            ])
            ->add("cadastr_num","text", [
                'rules' => 'required',
                "label" => "Кадастровый номер"
            ])
            ->add('submit', 'submit', ['label' => 'Сохранить', "attr" => ["class" => "btn btn-primary"] ]);
    }
}
