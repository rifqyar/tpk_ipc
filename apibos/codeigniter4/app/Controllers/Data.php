<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class Data extends BaseController
{
	public function index()
    {
        $rules = [
            'no_dok' => 'required|min_length[6]|max_length[50]',
			'tgl_dok' => 'required|max_length[255]',
            'type_dok' => 'required|max_length[255]'
        ];

        $errors = [
            'no_dok' => [
                //'validateData' => 'Invalid Data Input, Mohon dicek Kembali',
				'required' => 'The no_dok field is required',
			],
			'tgl_dok' => [
                //'validateData' => 'Invalid Data Input, Mohon dicek Kembali',
				'required' => 'The tgl_dok field is required',
			],
			'type_dok' => [
                //'validateData' => 'Invalid Data Input, Mohon dicek Kembali',
				'required' => 'The type_dok field is required',
			],
        ];		

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }
       return $this->getPost($input['no_dok'],$input['tgl_dok'],$input['type_dok']);       
    }

    private function getPost(
        string $NO_DOK,
		string $TGL_DOK,
		string $TYPE_DOK,
        int $responseCode = ResponseInterface::HTTP_OK
    )
    {
        try {
            $model = new ClientModel();
            $test = $model->findClientByNoDok($NO_DOK,$TGL_DOK,$TYPE_DOK);

        return $this->getResponse(
            [
                'message' => 'Data retrieved successfully',
                'Data' => $test
            ]
        );
        } catch (Exception $exception) {
            return $this
                ->getResponse(
                    [
                        'error' => $exception->getMessage(),
                    ],
                    $responseCode
                );
        }
    }
}
