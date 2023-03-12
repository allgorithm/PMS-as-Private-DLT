<?php

require_once '../api/multichain/mController.php';
require_once '../api/multichain/Stream.php';
require_once '../api/multichain/Wallet.php';
require_once '../api/multichain/Asset.php';
require_once '../api/multichain/Premission.php';

class test
{
    private $attr = '';

    public function __construct()
    {
        $this->attr = 'hy';
    }
}

// Initialisierung
$c = new mController('verwaltung2');
$stream = new Stream($c);
$wallet = new Wallet($c);
$premission = new Premission($c);
$asset = new Asset($c);



#print_r ($stream->createStream('Gruppe1')['result']);
#print_r($stream->subscribe('Gruppe1'));
#print_r ($stream->listStreams());

#print_r($wallet->getnewaddress());
#print_r($wallet->getaddresses());exit;

#print_r (array("result" => $stream->publish('gruppe1', '---', json_encode (array("log"=>"newStudent","wallet"=>"------")))['result']));

#$asset->issue('1QDD9VhVdL41bniVTVTKRjzBr292KrGrhQeB7H', 'token2', 10);exit;
#print_r($asset->listassets());
#print_r($wallet->getaddressbalances('1QDD9VhVdL41bniVTVTKRjzBr292KrGrhQeB7H'));
#exit;
#print_r($wallet->listaddresstransactions('1NtHBUE6RGNmDRYPfzu9FZDTvJrJm47Nc98A8t'));
#print_r(count($stream->liststreams()['result']));
#print_r($stream->liststreams()['result']);
#print_r($stream->liststreamkeys('gruppe1')['result']);exit;
#print_r($stream->liststreams()['result']);
/*
print_r(
$wallet->getaddressbalances(
json_decode(
hex2bin(
$stream->liststreamkeyitems(
'gruppe1', '111'
)['result'][0]['data']
)
, true)['wallet']
)['result']
);exit;
 

foreach ($stream->liststreams()['result'] as $k => $v) {
    $mtr[] = '<b>' . $v['name'] . '</b>';
    #$mtr[] = $v['name'];
    foreach ($stream->liststreamkeys($v['name'])['result'] as $k1 => $v1) {
        $tmp = json_decode(
            hex2bin(
                $stream->liststreamkeyitems(
                    $v['name'], $v1['key']
                )['result'][0]['data']
            ), false);

        $mtr[] = array(
            "mtrNr" => intval($tmp->mtrnr),
            "wallet" => $tmp->wallet,
            "balance" => $wallet->getaddressbalances($tmp->wallet),
        );
    }
}
print_r($mtr);exit;


$stream->publish(
    "gruppe2",
    "888",
    json_encode(
        array(
            "id" => "555",
            "wallet" => $wallet->getnewaddress()['result'],
        )
    )
);

exit;

foreach ($stream->liststreams()['result'] as $k => $v) {

    foreach ($stream->liststreamkeys($v['name'])['result'] as $k1 => $v1) {
        echo $v1['key'];
    }
}
exit;
*/
/*
foreach ($stream->liststreamkeys('gruppe1')['result'] as $k => $v) {
#echo $stream->liststreamkeyitems('gruppe1', $v['key']) . "\n";
echo $wallet->getaddressbalances(
json_decode(
hex2bin(
$stream->liststreamkeyitems(
'gruppe1', '444579'
)['result'][0]['data']
)
, true)['wallet']
);
}exit;*/

#print_r($wallet->getaddresses(true));exit;
#print_r($stream);
#exit;

#print_r($premission->grant('1QmAh4eRkdxo1Gr4nXVc9mFkQQ3RxUYAtrDDLp', array('receive')));
#print_r($asset->sendassetfrom('1QDD9VhVdL41bniVTVTKRjzBr292KrGrhQeB7H', '1HfBNg2dUUX8kK5RprmikpUVj36H1c5MEqHtnh', 'token1', 1));
print_r($wallet->listaddresstransactions('1HfBNg2dUUX8kK5RprmikpUVj36H1c5MEqHtnh')['result']);exit;
#print_r($wallet->getwallettransaction('32f3ddbf15bf1674632a695517479c345f16c0adf83ab9e93753d31374b2ffe8', true));exit;
#print_r($asset->listassets());exit;
/*
foreach ($stream->liststreamkeyitems('Gruppe1', '21')['result'] as $key => $value) {
    #hex2bin($value['data']);
    $wallets = json_decode(hex2bin($value['data']), false)->wallet;
    $r = $wallet->getaddressbalances($wallets)['result'][0]['qty'];
    break;

}
*/
/*
#print_r ($r);
print_r(json_encode($r));
exit;
foreach (json_decode(
    json_encode($stream->liststreamkeyitems('Gruppe1', '123')['result'])
    , false) as $key => $value) {
    #print_r($value);
    for ($i = 0; $i < sizeof($value); $i++) {
        #echo json_decode(hex2bin($value->data), false)->wallet;
        echo $wallet->getaddressbalances(json_decode(hex2bin($value->data), true)['wallet'])['result'][0]['qty'];
        #$result[] = array("result" =>
        #json_decode(hex2bin($value->data), true)['wallet'].': '.
        #$wallet->getaddressbalances('1ZpdstfmtphZhRr2HGfPxo8sxXjLndErXUWWbk')
        #);
    }
}
*/
#var_dump($result);

/*var_dump(
json_decode(
json_encode()
, false)
);*/

// Resultat in Object mappen und auslesen
foreach (json_decode(
    json_encode($stream->liststreamkeyitems('Gruppe1', '43')['result'])
    , false) as $key => $value) {
    for ($i = 0; $i < sizeof($value); $i++) {
        echo json_decode(hex2bin($value->data), false)->wallet . "\n";
    }
}
