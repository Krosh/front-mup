<?php

namespace App\Forms;

use App\Models\Grave;
use Kris\LaravelFormBuilder\Form;

class GraveForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('sizeGrave', 'text', ["label" => "Размер участка", "rules" => "required"])
            ->add('hasBorder','checkbox',["label" => "Имеется оградка", "attr" => ["class" => "js-change-border-visible"]])
            ->add('border','text',["label" => "Описание оградки", "attr" => ["class" => "form-control js-border"]])
            ->add('state','select',["choices" => Grave::getStates(), "label" => "Общее состояние", "rules" => "required"])
            ->add("idCemetery","hidden")
            ->add('submit','submit', ['label' => 'Сохранить', "attr" => ["class" => "btn btn-primary"] ]);
    }
}
