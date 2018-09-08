<?php

namespace App\Controllers;

use App\Models\Form;

class FormController
{
    public function index($request, $response)
    {
        $create = Form::create([

            'fname' => 'jane',

            'lname' => 'doe',

            'email' => 'janedoe@cloudways.com',

            'age' => 33,

            'smoker' => false,

            'zip' => '00000',

        ]);
        var_dump($create);
    }
}
