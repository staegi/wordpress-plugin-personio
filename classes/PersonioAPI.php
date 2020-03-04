<?php

class PersonioAPI
{
    static $baseUrl = 'https://api.personio.de/v1/';

    /**
     * @return int|array
     */
    public function getEmployees()
    {
        static $employees = [];

        if (count($employees) > 0) {
            return $employees;
        }

        $token = self::authenticate();
        if (is_null($token)) {
            return -1;
        }

        $teamEndpoint = self::$baseUrl . 'company/employees';
        $headers = array('Authorization' => 'Bearer ' . $token);
        $response = wp_remote_get($teamEndpoint, array('headers' => $headers));
        if ($response['response']['code'] != '200') {
            return 0;
        }

        return $employees = json_decode($response['body'])->data;
    }

    /**
     * @return array
     */
    public function getEmployeesFieldList()
    {
        $employees = $this->getEmployees();
        if (is_int($employees)) {
            return [];
        }

        return array_keys(get_object_vars($employees[0]->attributes));
    }

    /**
     * @return string|null
     */
    private static function authenticate()
    {
        $authEndpoint = self::$baseUrl . 'auth';
        $clientID = get_option('personio_client_id');
        $clientSecret = get_option('personio_client_secret');
        $credentials = array('client_id' => $clientID, 'client_secret' => $clientSecret);
        $response = wp_remote_post(add_query_arg($credentials, $authEndpoint));

        if ($response['response']['code'] == '200') {
            return json_decode($response['body'])->data->token;
        }

        return null;
    }

}