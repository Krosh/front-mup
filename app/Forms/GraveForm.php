<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class GraveForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('sizeGrave', 'text', ["label" => "Размер участка"])
            ->add('hasBorder','checkbox',["label" => "Имеется оградка", "attr" => ["class" => "js-change-border-visible"]])
            ->add('border','text',["label" => "Описание оградки", "attr" => ["class" => "form-control js-border"]])
            ->add('submit','submit', ['label' => 'Сохранить', "attr" => ["class" => "btn btn-primary"] ]);
    }
}
