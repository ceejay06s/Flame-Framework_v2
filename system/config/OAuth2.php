<?php

namespace System\Config;

use OAuth2\Server;
use OAuth2\Storage\Pdo;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\RefreshToken;
use OAuth2\GrantType\UserCredentials;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\Request;

class OAuth2
{
    public $server;
    public function __construct()
    {
        $db_type = getenv('DB_TYPE');
        $dsn = '';
        switch ($db_type) {
            case 'mssql':
                $dsn = "sqlsrv:server=" . getenv('DB_HOST') . ";database=" . getenv('DB_NAME');
                break;
            case 'mysql':
            case 'mysqli':
                $dsn = "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME');
                break;
            case 'sqlite':
                $dsn = "sqlite:" . getenv('DB_PATH');
                break;
            default:
                $dsn = "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME');
                break;
        }

        $storage = new Pdo([
            'dsn' =>  $dsn,
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
        ]);

        $this->server = new Server(
            $storage,
            [
                'enforce_state' => true,
                'allow_implicit' => true,
                'access_lifetime' => 3600,
                'refresh_token_lifetime' => 1296000,
            ]
        );

        $this->server->addGrantType(new UserCredentials($storage));
        $this->server->addGrantType(new AuthorizationCode($storage));
        $this->server->addGrantType(new RefreshToken($storage));
        $this->server->addGrantType(new ClientCredentials($storage));
    }

    public function handleRequest($request = null)
    {
        $request = $request ?? Request::createFromGlobals();
        // var_dump($request);
        $response =  $this->server->handleTokenRequest($request);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            http_response_code($statusCode);
            include_once VIEWS_PATH . DS . "error/{$statusCode}.html";
            die;
        }
        return $response;
    }
    public function generateToken($client_id, $client_secret, $grant_type, $username, $password, $scope = null)
    {
        $request = new Request();
        $request->request = [
            'grant_type' => $grant_type,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'username' => $username,
            'password' => $password,
            'scope' => $scope,
        ];
        $response = $this->server->handleTokenRequest($request);
        return $response;
    }

    public function authorize()
    {
        global $session;
        if (!$this->server->verifyResourceRequest(Request::createFromGlobals())) {
            $response = $this->server->getResponse();
            $statusCode = $response->getstatusCode();
            http_response_code($statusCode);
            include_once VIEWS_PATH . DS . "error/{$statusCode}.html";
            die;
        }
        $session->set('authorized', true);
    }

    public function refreshToken($refresh_token, $client_id, $client_secret, $scope = null)
    {
        $request = new Request();
        $request->request = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'scope' => $scope,
        ];
        $response = $this->server->handleTokenRequest($request);
        return $response;
    }
}
