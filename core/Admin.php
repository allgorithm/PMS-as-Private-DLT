<?php

class Admin
{
    private $blockchain = null; # Object
    private $params = null; # array
    private $redirect = '/ba/gui/admin1.html'; # string
    private $value = ''; # array

    public function __construct($blockchain = null, $params = array())
    {
        $this->blockchain = $blockchain;
        $this->params = $params;
    }

    public function getStreams()
    {
        $stream = new Stream($this->blockchain);

        return $stream->liststreams()['result'];
    }

    public function getAllWallets()
    {
        $wallet = new Wallet($this->blockchain);

        return $wallet->getaddresses()['result'];
    }

    public function getItemFromId(string $id = '')
    {
        $stream = new Stream($this->blockchain);

        return $stream->liststreamkeyitems('gruppe1', $id)['result'];
    }

    ####################################
    ### DATEN AUS BLOCKCHAIN SAMMELT ###
    ####################################
    public function getIdData()
    {
        $stream = new Stream($this->blockchain);
        $wallet = new Wallet($this->blockchain);
        foreach ($stream->liststreams()['result'] as $k => $v) {
            $mtr[] = '<b>' . $v['name'] . '</b>';
            foreach ($stream->liststreamkeys($v['name'])['result'] as $k1 => $v1) {if ($v1['key'] == '444580') {continue;} #AUSNAHME!!! wegen falschen Eintrag in BC
            // Inhalt lesen
                $tmp = json_decode(
                    hex2bin(
                        $stream->liststreamkeyitems(
                            $v['name'], $v1['key']
                        )['result'][0]['data']
                    ), false);
                $attr = property_exists($tmp, 'mtrnr') ? $tmp->mtrnr : 0;
                // Inhalt parsen
                $mtr[] = array(
                    "mtrnr" => $attr,
                    "wallet" => $tmp->wallet,
                    "balance" => $wallet->getaddressbalances($tmp->wallet)['result'],
                );
            }
        }

        return $mtr;
    }

    ##################
    ### ADMINDATEN ###
    ##################
    public function getTokenData()
    {
        $wallet = new Wallet($this->blockchain);
        return $wallet->getaddressbalances($_SESSION['adminWallet'])['result'];
    }

    ########################
    ### STREAM ERSTELLEN ###
    ########################
    public function streamErstellen(string $streamName)
    {
        // Verbindung mit Blockchain
        $stream = new Stream($this->blockchain);
        // Neues Stream anlegen und subscribe
        $stream->createStream($streamName);
        $stream->subscribe($streamName);
    }

    ################################
    ### INSERT DATENSATZ STUDENT ###
    ################################
    public function insert($id, string $tabelle)
    { #return array($id, $tabelle);
    // Verbindung mit Blockchain
        $stream = new Stream($this->blockchain);
        // Wallet initialisierung
        $wallet = new Wallet($this->blockchain);
        //
        $premission = new Premission($this->blockchain);
        $w = $wallet->getnewaddress()['result'];
        $premission->grant($w); # Rechte in Library festgeschrieben 'receive'
        // Datensatz eintragen
        $stream->publish(
            $tabelle,
            $id,
            json_encode(
                array(
                    "mtrnr" => $id,
                    "wallet" => $w,
                )
            )
        );
    }

    #######################
    ### TOKEN ERSTELLEN ###
    #######################
    public function createToken(string $tokenName, int $tokenAnz)
    { #return array($_SESSION['adminWallet'], $tokenName, $tokenAnz);
    // Verbindung mit Blockchain
        $asset = new Asset($this->blockchain);
        $asset->issue($_SESSION['adminWallet'], $tokenName, $tokenAnz);
    }

    ####################
    ### TOKEN SENDEN ###
    ####################
    public function sendToken($mtrnr, $token)
    { #return array($mtrnr, explode(' ', $token)[0]);
    $stream = new Stream($this->blockchain);
        $wallet = new Wallet($this->blockchain);
        $asset = new Asset($this->blockchain);
        foreach ($stream->liststreams()['result'] as $k => $v) {
            //$mtr[] = '<b>' . $v['name'] . '</b>';
            foreach ($stream->liststreamkeys($v['name'])['result'] as $k1 => $v1) {if ($v1['key'] == '444580') {continue;} #AUSNAHME!!! wegen falschen Eintrag in BC
            if ($v1['key'] == $mtrnr) {
                // Inhalt lesen
                $tmp = json_decode(
                    hex2bin(
                        $stream->liststreamkeyitems(
                            $v['name'], $v1['key']
                        )['result'][0]['data']
                    ), false);
                $attr = property_exists($tmp, 'mtrnr') ? $tmp->mtrnr : 0;
                // Inhalt parsen
                $mtr[] = array(
                    "mtrnr" => $attr,
                    "wallet" => $tmp->wallet,
                    "balance" => $asset->sendassetfrom($_SESSION['adminWallet'], $tmp->wallet, explode(' ', $token)[0], 1),
                );
                return $mtr;
            }
            }
        }

        return false;
    }

    /**
     * Get the value of redirect
     */
    public function getRedirect()
    {
        return $this->redirect;
    }
}
