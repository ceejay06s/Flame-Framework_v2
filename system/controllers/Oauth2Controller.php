<?php

use System\Config\OAuth2;
use OAuth2\Request;

class Oauth2Controller extends Controller
{
    private $server;
    public function __construct()
    {
        parent::__construct();
        $this->server = new OAuth2();
    }
    public function token()
    {
        $request = Request::createFromGlobals();
        $response = $this->server->handleRequest($request);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            http_response_code($statusCode);
            include_once VIEWS_PATH . DS . "error/{$statusCode}.html";
            die;
        }
        $response->send();
    }

    public function refreshToken($refresh_token, $client_id, $client_secret, $scope = null)
    {
        $request = new Request();
        $request->request = [
            'token_type' => "token_type",
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'scope' => $scope,
        ];
        $response = $this->server->handleRequest($request);
        $response->send();
    }

    public function authorize()
    {
        if (!$this->server->server->verifyResourceRequest(\OAuth2\Request::createFromGlobals())) {
            $this->server->server->getResponse()->send();
            die;
        }
        echo json_encode(array('success' => true, 'message' => 'You accessed my APIs!'));
    }
}
