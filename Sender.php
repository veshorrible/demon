<?php

class Sender
{
    private $url;

    CONST EMAIL = 'support@gmail.com';

    public function __construct()
    {
        $this->url = 'https://syn.su/testwork.php';
    }

    /**
     * Send request
     *
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function send(array $params = [])
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $this->url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            $out = curl_exec($curl);

            $response = json_decode($out);

            if ($response === null) {
                throw new \Exception('Invalid response format json');
            }
            curl_close($curl);
            return $response;
        }
    }

    /**
     * Get info
     *
     * @return stdClass
     */
    public function getInfo()
    {
        $response = $this->send([
            'method' => 'get'
        ]);
        return $this->getResponse($response);
    }

    /**
     * Update info
     *
     * @param string $message
     * @return stdClass
     */
    public function updateInfo(string $message)
    {
        $response = $this->send([
            'method' => 'update',
            'message' => $message
        ]);
        return $this->getResponse($response);
    }

    /**
     * Check response
     *
     * @param stdClass $response
     * @return bool
     */
    public function checkResponse(stdClass $response)
    {
        if (isset($response->errorCode)) {
            $this->sendEmail($response->errorMessage);
            return false;
        }
        return true;
    }

    /**
     * Get Response
     *
     * @param stdClass $response
     * @return string|stdClass
     */
    public function getResponse(stdClass $response)
    {
        $status = $this->checkResponse($response);
        $object = (new ResponseDataType())
            ->setMessage('')
            ->setKey('');
        return ($status) ? $response->response : $object;
    }

    /**
     * Send Email
     *
     * @param string $message
     * @return bool
     */
    public function sendEmail(string $message)
    {
        $headers = "From: Dennis";
        return mail(self::EMAIL, "Error", $message, $headers);
    }

}