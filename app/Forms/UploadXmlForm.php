<?php

namespace App\Forms;

use App\Models\Cemetery;
use Kris\LaravelFormBuilder\Form;

class UploadXmlForm extends Form
{
    public function buildForm()
    {
        $cemeteries = Cemetery::all();
        $items = [];
        foreach ($cemeteries as $item)
        {
            $items[$item->id] = $item->name;
        }

        $this
            ->add('cemetery', 'select',[
                "choices" => $items,
                "empty_value" => "Выберите кладбище",
            ] )
            ->add('xml', 'file',['attr' => ['multiple'=>true]])
            ->add('submit', 'submit', ['label' => 'Загрузить на сервер', "attr" => ["class" => "btn btn-primary"] ]);
    }
}
