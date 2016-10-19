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
            ->add("cadastr_num","text", [
                'rules' => 'required',
                "label" => "Кадастровый номер"
            ])
            ->add('submit', 'submit', ['label' => 'Сохранить', "attr" => ["class" => "btn btn-primary"] ]);
    }
}
