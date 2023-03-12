<?php

class Premission
{
    private $connection = null; #object

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function grant(string $wallet)
    {
        return $this->connection->communication(__FUNCTION__, array($wallet, 'receive'));
    }

}
