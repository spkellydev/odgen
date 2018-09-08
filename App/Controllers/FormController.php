<?php

namespace App\Controllers;

use App\Models\Form;
use App\Validatable;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FormController extends Validatable
{
    public function index(Request $request, Response $response)
    {
        // $create = Form::create([

        //     'fname' => 'jane',

        //     'lname' => 'doe',

        //     'email' => 'janedoe@cloudways.com',

        //     'age' => 33,

        //     'smoker' => false,

        //     'zip' => '00000',

        // ]);
    }

    public function create(Request $request, Response $response)
    {
        $this->checkStringAsName($request->getParam('fname'));
        $submission = new Form;
        $submission->fname = $this->checkStringAsName($request->getParam('fname')) ? $request->getParam('fname') : false;
        $submission->lname = $this->checkStringAsName($request->getParam('fname')) ? $request->getParam('lname') : false;
        $submission->email = $this->checkEmail($request->getParam('email')) ? $request->getParam('email') : false;
        $submission->age = $this->checkIntRange($request->getParam('age'), 18, 90) ? $request->getParam('age') : false;
        $submission->smoker = $this->checkBoolean($request->getParam('smoker')) ? $request->getParam('smoker') : null;
        $submission->zip = $this->checkValidZipCode($request->getParam('zip')) ? $request->getParam('zip') : false;

        if ($submission->fname && $submission->lname && $submission->email && $submission->age && $submission->zip && !is_null($submission->smoker)) {
            $submission->save();
            echo '{"success": {"text": "Submission received"}';
        } else {
            echo '{"error": {"text": ' . $submission . '}';
        }

    }
}
