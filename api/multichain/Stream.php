<?php

class Stream
{
    private $connection = null; #object

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function liststreams()
    {
        return $this->connection->communication(__FUNCTION__);
    }

    // Stream erstellen
    public function createStream(string $streamName = '')
    {
        // The false means the stream can only be written to by those with explicit permissions.
        return $this->connection->communication('create', array('stream', $streamName, false));
    }

    // In Blockchain schreiben
    public function publish(string $streamName = '', string $key = '', string $data = '')
    {
        return $this->connection->communication(__FUNCTION__, array($streamName, $key, bin2hex($data)));
    }

    // Stream abonieren
    public function subscribe(string $streamName = '')
    {
        return $this->connection->communication(__FUNCTION__, array($streamName));
    }

    // Inhalt des Streams auflisten
    public function liststreamitems(string $streamName = '')
    {
        return $this->connection->communication(__FUNCTION__, array($streamName));
    }
    
    // Inhalt nach Key ausgeben
    public function liststreamkeyitems(string $streamName = '', string $key = '')
    {
        return $this->connection->communication(__FUNCTION__, array($streamName, $key));
    }

    // Keys einzeln
    public function liststreamkeys(string $streamName = '', string $verbose = '*')
    {
        return $this->connection->communication(__FUNCTION__, array($streamName, $verbose));
    }
}
