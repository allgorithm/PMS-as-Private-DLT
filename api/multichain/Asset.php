<?php

class Asset
{
    private $connection = null; #object

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function listassets()
    {
        return $this->connection->communication(__FUNCTION__);
    }

    public function issue(string $wallet = '', string $issueName = '', $qty = '')
    {
        return $this->connection->communication(__FUNCTION__, array($wallet, $issueName, $qty));
    }

    public function sendasset(string $wallet, string $issueName, $qty)
    {
        return $this->connection->communication(__FUNCTION__, array($wallet, $issueName, $qty));
    }

    public function sendassetfrom(string $from = '', $to = '', $asset = '', $qty = '')
    {
        return $this->connection->communication(__FUNCTION__, array($from, $to, $asset, $qty));
    }

}
