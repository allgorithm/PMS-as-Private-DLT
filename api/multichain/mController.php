<?php

class mController
{
    private $chain = ''; # String

    # Controller
    public function __construct(String $chain)
    {
        $this->chain = $chain;
        $config = $this->read_config();

        // Admin GLOBAL setzen als Session
        $_SESSION['adminWallet'] = $config[$this->chain]['admin'];
        $_SESSION['adminPin'] = $config[$this->chain]['pin'];
    }

    private function read_config()
    {
        $config = array();

        $contents = file_get_contents('../api/multichain/config.txt'); # 2do
        $lines = explode("\n", $contents);

        foreach ($lines as $line) {
            $content = explode('#', $line);
            $fields = explode('=', trim($content[0]));
            if (count($fields) == 2) {
                if (is_numeric(strpos($fields[0], '.'))) {
                    $parts = explode('.', $fields[0]);
                    $config[$parts[0]][$parts[1]] = $fields[1];
                } else {
                    $config[$fields[0]] = $fields[1];
                }
            }
        }

        return $config;
    }

    # Controller
    private function json_rpc_send($host, $port, $user, $password, $method, $params = array())
    {
        $url = 'http://' . $host . ':' . $port . '/';

        $payload = json_encode(array(
            'id' => time(),
            'method' => $method,
            'params' => $params,
        )); #print_r($payload);exit;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $user . ':' . $password);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
        ));

        $response = curl_exec($ch);

        $result = json_decode($response, true);

        if (!is_array($result)) {
            $info = curl_getinfo($ch);
            $result = array('error' => array(
                'code' => 'HTTP ' . $info['http_code'],
                'message' => strip_tags($response) . ' ' . $url,
            ));
        }

        return $result;
    }

    # Controller
    public function communication(String $method = '', $param = array())
    {
        $config = $this->read_config();

        $out = $this->json_rpc_send(
            $config[$this->chain]['rpchost'],
            $config[$this->chain]['rpcport'],
            $config[$this->chain]['rpcuser'],
            $config[$this->chain]['rpcpassword'],
            $method, $param);

        return $out;
    }

}
