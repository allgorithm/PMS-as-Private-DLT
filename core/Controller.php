<?php

require_once '../api/multichain/mController.php';
require_once '../api/multichain/Stream.php';
require_once '../api/multichain/Wallet.php';
require_once '../api/multichain/Asset.php';
require_once '../api/multichain/Premission.php';
include 'Admin.php';
include 'User.php';

class Controller
{

    private $function = ''; #string
    private $params = array(); #array

    #################
    ### CONSTRUCT ###
    #################
    public function __construct(string $function, array $params)
    {
        session_start();
        $this->function = $function;
        $this->params = $params;
    }

    #############
    ### LOGIN ###
    #############
    public function login(array $params)
    {
        // Verbindung mit Blockchain
        $blockchain = new mController($params['blockchainName']);
        // Initialisierung
        $stream = new Stream($blockchain);
        // Sessions GLOBAL setzen
        // Check ob Admin sonst Student
        $_SESSION['admin'] =
        $_SESSION['adminWallet'] == $params['matrikelnummer'] &&
        $_SESSION['adminPin'] == $params['pin']
        ? true : false;

        $_SESSION['model'] = $_SESSION['admin'] ? new Admin($blockchain, $params) : new User($blockchain, $params);
        #$_SESSION['model'] = new Admin($blockchain, $params);

        return array("result" => array(
            "info" => $_SESSION['model'],
            "model" => "",
            "redirect" => $_SESSION['model']->getRedirect(),
            "value" => ""));
    }

    ###############################################################
    ### Check ob Session für Admin gesetzt ist und Daten laden ####
    ###############################################################
    public function isSession()
    {
        return !$_SESSION['admin'] ? $_SESSION['admin'] :
        array(
            "result" => array(
                "info" => $_SESSION['admin'],
                "value" => array(
                    "streams" => $_SESSION['model']->getStreams(),
                    "data" => $_SESSION['model']->getIdData(),
                    "tokens" => $_SESSION['model']->getTokenData(),
                ),
            ),
        );
    }

    #######################
    ### Session löschen ###
    #######################
    public function logout()
    {
        session_destroy();
        return array("result" => array(
            "info" => $this->isSession(),
            "model" => "",
            "redirect" => "",
            "value" => ""));
    }

    ########################
    ### Stream erstellt? ###
    ########################
    public function isStream($stream, string $streamName)
    {
        foreach ($stream->liststreams()['result'] as $key => $value) {
            if ($value['name'] == $streamName) {
                return true;
            }
        }
        return false;
    }

    ########################
    ### STREAM ERSTELLEN ###
    ########################
    public function streamErstellen(array $params)
    {
        return !$_SESSION['admin'] ? exit : # eventuell Korregieren exit -> $_SESSION['admin']
        array(
            "result" => array(
                "info" => $_SESSION['admin'],
                "model" => get_class($_SESSION['model']),
                "redirect" => $_SESSION['model']->getRedirect(),
                "value" => array(
                    "data" => $_SESSION['model']->streamErstellen($params['streamName'])),
            ),
        );
    }

    #########################################################
    ### Student wird eingetragen und neue Wallet erstellt ###
    #########################################################
    public function studentEintragen(array $params = null)
    {
        return !$_SESSION['admin'] ? exit : # eventuell Korregieren exit -> $_SESSION['admin']
        array(
            "result" => array(
                "info" => $_SESSION['admin'],
                "model" => get_class($_SESSION['model']),
                "redirect" => $_SESSION['model']->getRedirect(),
                "value" => array(
                    "data" => $_SESSION['model']->insert($params['id'], $params['streamName'])),
            ),
        );
    }

    #######################
    ### Token erstellen ###
    #######################
    public function tokenErstellen(array $params = null)
    {
        return !$_SESSION['admin'] ? $_SESSION['admin'] :
        array(
            "result" => array(
                "info" => $_SESSION['admin'],
                "model" => $_SESSION['model'],
                "redirect" => $_SESSION['model']->getRedirect(),
                "value" => array(
                    "data" => $_SESSION['model']->createToken($params['tokenName'], $params['tokenAnzahl']),
                ),
            ),
        );
    }

    ####################
    ### Token senden ###
    ####################
    public function tokenSenden(array $params = null)
    {
        return !$_SESSION['admin'] ? $_SESSION['admin'] :
        array(
            "result" => array(
                "info" => $params['token'],
                "model" => $_SESSION['model'],
                "redirect" => $_SESSION['model']->getRedirect(),
                "value" => array(
                    "data" => $_SESSION['model']->sendToken($params['mtrnr'], $params['token']), #$_SESSION['model']->createToken($params['tokenName'], $params['tokenAnzahl']),
                ),
            ),
        );
    }

    ### eigene Funktion
    public function ownFunction(array $param = null)
    {
        return "bin drin in ownFunction " . $param['matrikelnummer'] . "\n";
    }

}