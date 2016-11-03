<?php

namespace App\Forms;

use App\Models\City;
use Kris\LaravelFormBuilder\Form;

class CemeteryForm extends Form
{
    public function buildForm()
    {
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
            ->add("square_filled","text", [
                'rules' => 'required',
                "label" => "Занятая площадь"
            ])
            ->add("cadastr_num","text", [
                'rules' => 'required',
                "label" => "Кадастровый номер"
            ])
            ->add('submit', 'submit', ['label' => 'Сохранить', "attr" => ["class" => "btn btn-primary"] ]);
    }
}
