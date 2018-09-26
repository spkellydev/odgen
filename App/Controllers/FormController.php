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

    /**
     * create row in forms table
     * @return string
     */
    public function create(Request $request, Response $response)
    {

        $submission = new Form;
        $submission->fname = $this->checkStringAsName($request->getParam('fname')) ? $request->getParam('fname') : false;
        $submission->lname = $this->checkStringAsName($request->getParam('lname')) ? $request->getParam('lname') : false;
        $submission->email = $this->checkEmail($request->getParam('email')) ? $request->getParam('email') : false;
        $submission->age = $this->checkIntRange($request->getParam('age'), 18, 90) ? $request->getParam('age') : false;
        $submission->smoker = $this->checkBoolean($request->getParam('smoker')) ? $request->getParam('smoker') : null;
        $submission->zip = $this->checkValidZipCode($request->getParam('zip')) ? $request->getParam('zip') : false;
        $submission->company = $this->checkStringAsName($request->getParam('company')) ? $request->getParam('company') : '';

        if ($this->validateSubmission($submission)) {
            $submission->save();
            return $response->withJson(['status' => 'success', 'code' => 200], 200);
        } else {
            return $response->withJson(['status' => 'error', 'code' => 422, 'submission' => $submission], 422);
        }

    }

    /**
     * Ensure that all submission variables are validated
     * @return bool
     */
    private function validateSubmission($submission)
    {
        if ($submission->fname && $submission->lname && $submission->email && $submission->age && $submission->zip && !is_null($submission->smoker)) {
            return true;
        } else {
            return false;
        }
    }
}
