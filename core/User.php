<?php

class User
{
    private $blockchain = null; # Object
    private $params = null; # array
    private $redirect = '/ba/gui/user.html'; # string
    private $vlue = ''; # array

    public function __construct($blockchain = null, $params = array())
    {
        $this->blockchain = $blockchain;
        $this->params = $params;
    }

    public function getWallet()
    {

    }

    public function getPoints()
    {

    }

    /**
     * Get the value of redirect
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * Get the value of vlue
     */
    public function getVlue()
    {
        return $this->vlue;
    }
}
