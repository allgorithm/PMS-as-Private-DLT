<?php

class Wallet
{
    private $connection = null; #object

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getaddresses(bool $verbose = false)
    {
        return $this->connection->communication(__FUNCTION__, array($verbose));
    }

    public function getnewaddress()
    {
        return $this->connection->communication(__FUNCTION__);
    }

    public function getaddressbalances(string $wallet = '')
    {
        return $this->connection->communication(__FUNCTION__, array($wallet));
    }

    public function listaddresstransactions(string $wallet = '')
    {
        return $this->connection->communication(__FUNCTION__, array($wallet));
    }

    public function listaddresses(string $wallet = '', bool $verbose = false)
    {
        return $this->connection->communication(__FUNCTION__, array($wallet, $verbose));
    }

    public function getwallettransaction(string $txid = '', bool $verbose = false)
    {
        return $this->connection->communication(__FUNCTION__, array($txid, $verbose));
    }

}
