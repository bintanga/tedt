<?php
/*
copyright @ medantechno.com
Modified @ Farzain - zFz
2017

*/

require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$channelAccessToken = 'EIcP7PLq1xfO3zWxUK84Grdx8kyyzL42TJR72JTNwlgKFfydkeajjo+uT2wBt642GUq1QDFvCRFIQ+hv4RiNE5K5TWep1XrwilhFIVg+4ozE0nIKdWrp8IlJGKjoaRnqIbfWFLktKGFPTuMGbwurxAdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$ channelSecret  =   'a4b79ae020b8ba981d1f7e4e4776254b'; // sesuaikan

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$groupId 	= $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp	= $client->parseEvents()[0]['timestamp'];
$type 		= $client->parseEvents()[0]['type'];

$message 	= $client->parseEvents()[0]['message'];
$messageid 	= $client->parseEvents()[0]['message']['id'];

$profil = $client->profil($userId);

$pesan_datang = explode(" ", $message['text']);

$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}

#-------------------------[Function]-------------------------#
function shalat($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Jadwal Shalat Sekitar ";
	$result .= $json['location']['address'];
	$result .= "\nTanggal : ";
	$result .= $json['time']['date'];
	$result .= "\n\nShubuh : ";
	$result .= $json['data']['Fajr'];
	$result .= "\nDzuhur : ";
	$result .= $json['data']['Dhuhr'];
	$result .= "\nAshar : ";
	$result .= $json['data']['Asr'];
	$result .= "\nMaghrib : ";
	$result .= $json['data']['Maghrib'];
	$result .= "\nIsya : ";
	$result .= $json['data']['Isha'];
    return $result;
}
#-------------------------[Function]-------------------------#

# require_once('./src/function/search-1.php');
# require_once('./src/function/download.php');
# require_once('./src/function/random.php');
# require_once('./src/function/search-2.php');
# require_once('./src/function/hard.php');

//show menu, saat join dan command /menu
if ($type == 'join' || $command == '/menu') {
    $text = "Assalamualaikum Kakak, aku adalah bot jadwal shalat, silahkan ketik\n\n/shalat <nama tempat>\n\nnanti aku bakalan kasih tahu jam berapa waktunya shalat ^_^";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}

//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/shalat') {

        $result = shalat($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }

}else if($message['type']=='sticker')
{	
	$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Makasih Kak Stikernya ^_^'										
									
									)
							)
						);
						
}
if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();

    file_put_contents('./balasan.json', $result);


    $client->replyMessage($balas);
}
?>
#---------------ntahlah apa ini ------------------------------#
# ------------------------- [Fungsi] --------------------- ---- #
function  Cuaca ( $ keyword ) {
    $ uri  =  " http://api.openweathermap.org/data/2.5/weather?q= "  .  kata kunci $  .  " , ID & units = metrik & appid = e172c2f3a3c620591582ab5242e0e6c4 " ;
    $ response  =  Unirest \ Request :: get ( " $ uri " );
    $ json  =  json_decode ( $ response -> raw_body , true );
    $ result  =  " Halo Kak ^ _ ^ Ini Ada Ramalan Cuaca Untuk Daerah " ;
	$ result  . =  $ json [ ' name ' ];
	$ result  . =  " Dan Sekitarnya " ;
	$ result  . =  " \ n \ n Cuaca: " ;
	$ result  . =  $ json [ ' cuaca ' ] [ ' 0 ' ] [ ' utama ' ];
	$ result  . =  " \ n Deskripsi: " ;
	$ result  . =  $ json [ ' cuaca ' ] [ ' 0 ' ] [ ' deskripsi ' ];
    kembali  $ hasil ;
}
# ------------------------- [Fungsi] --------------------- ---- #
# require_once ('./ src / function / search-1.php');
# require_once ('./ src / function / download.php');
# require_once ('./ src / function / random.php');
# require_once ('./ src / function / search-2.php');
# require_once ('./ src / function / hard.php');
// tampilkan menu, saat bergabung dan perintah / menu
if ( $ type  ==  ' join '  ||  $ command  ==  ' / menu ' ) {
    $ text  =  " Halo Kak ^ _ ^ \ n Aku Bot Prediksi Cuaca, Kamu bisa mengetahui nilai cuaca di daerah kamu sesuai dengan BMKG " ;
    $ balas  =  array (
        ' replyToken '  =>  $ replyToken ,
        ' messages '  =>  array (
            larik (
                ' type '  =>  ' text ' ,
                ' text '  =>  $ teks
            )
        )
    );
}
// pesan bergambar
if ( $ message [ ' type ' ] == ' text ' ) {
	    if ( $ command  ==  ' / Cuaca ' ) {
        $ result  = Cuaca ( $ opsi );
        $ balas  =  array (
            ' replyToken '  =>  $ replyToken ,
            ' messages '  =>  array (
                larik (
                    ' type '  =>  ' text ' ,
                    ' text '  =>  $ hasil
                )
            )
        );
    }
#-----------ini juga haha-----------------------#
if(strtolower($message['text']) == 'contoh'){
	$balas = array(
		'UserID' => $userId,
		'replyToken' => $replyToken,
		'messages' => array(
			array(
			'type' => 'template',
			'title' => 'Menu :',
			'altText' => 'Menu :',
			'template' => array(
					'type' => 'buttons',
					'thumbnailImageUrl' => 'urlgambar,
					'text' => 'Menu :',
					'actions' => array(
							array(
									'type' => 'message',
									'label' => 'Text',
									'text' => 'Text'
							)							
						)
				) 
			)
		)
	);
	$client->replyMessage($balas);
}
