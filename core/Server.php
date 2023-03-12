<?php

include 'Controller.php';

/*
Struktur, die gesendet werden muss -> ownFunction ist null per default
{
"function":{"name":"ownFunction"},
"params":{"name":"alex","matrikelnummer":"444579","ownFunktion":"getinfo",
"anzahl":-----}
}
Eigene funktion -> ownFunction ist Name der Funktion aus der Dokumentation
 */

# Abfangen Abfragen aus dem Browser
$post = $_POST == null ? exit : $_POST;

$function = $post['function']['name'];
$controller = new Controller($post['function']['name'], $post['params']);

# Überprüfung der Funktion nach Existenz
echo (!method_exists(get_class($controller), $function)) ?
'#1 Funktion ->' . $function . '<- nicht vorhanden.' :
json_encode($controller->$function($post['params']));

#var_dump($post);exit;

unset($controller);
