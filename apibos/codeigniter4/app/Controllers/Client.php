<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;
use Helper\jwt_helper;

class Client extends BaseController
{
    public function index( int $responseCode = ResponseInterface::HTTP_OK )
    {
		try{
        $model = new ClientModel();
        return $this->getResponse(
            [
                'message' => 'Data retrieved successfully',
                'Data' => $model->test()
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

    public function store(int $responseCode = ResponseInterface::HTTP_OK )
    {
        try{
        $rules = [
            'NO_DOK' => 'required|min_length[6]|max_length[50]',
			'TGL_DOK' => 'required|max_length[255]'
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $clientDok = $input['NO_DOK'];
        $clientTgDok = $input['TGL_DOK'];

        $model = new ClientModel();
        $model->save($input);
        

        $client = $model->where('NO_DOK', $clientDok)->where('TGL_DOK', $clientTgDok)->first();

        return $this->getResponse(
            [
                'message' => 'Client added successfully',
                'client' => $client
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

    public function show($id)
    {
        try {

            $model = new ClientModel();
            $client = $model->findClientById($id);

            return $this->getResponse(
                [
                    'message' => 'Client retrieved successfully',
                    'client' => $client
                ]
            );

        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find client for specified ID'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

	public function update($id)
    {
        try {

            $model = new ClientModel();
            $model->findClientById($id);

          $input = $this->getRequestInput($this->request);

          

            $model->update($id, $input);
            $client = $model->findClientById($id);

            return $this->getResponse(
                [
                    'message' => 'Client updated successfully',
                    'client' => $client
                ]
            );

        } catch (Exception $exception) {

            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function destroy($id)
    {
        try {

            $model = new ClientModel();
            $client = $model->findClientById($id);
            $model->delete($client);

            return $this
                ->getResponse(
                    [
                        'message' => 'Client deleted successfully',
                    ]
                );

        } catch (Exception $exception) {
            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }
	
}
