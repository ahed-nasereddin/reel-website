<?php

namespace App\FormFields;

use TCG\Voyager\FormFields\AbstractHandler;

class EquipmentsFormField extends AbstractHandler
{
    // Codename will appear in the BREAD builder
    protected $codename = 'equipments';

    /**
     * Return the view for the form field
     */
    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.equipments', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
