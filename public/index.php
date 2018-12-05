<?php

require '../src/bootstrap.php';

$months = array("janvier","février", "mars", "avril", "mai","juin",
    "juillet", "août", "septembre", "octobre", "novembre", "décembre");

$days = array("Lundi","Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi",
    "Dimanche");

    $websites = [];
    $websites = array("https://store.fcnantes.com/",
                  "http://web.digitick.com/ext/billetterie5/?site=hbcnantes",
                  "http://www.nrmv.fr/billetterie/billetterie-en-ligne/",
                  "http://www.volleyballnantes.com/crbst_0.html",
                  "http://billetterie.nantes-reze-basket.dspsport.com/dsp/WEB/Site/index.htm?wId=NRB&rId=Ticketing",
                  "http://web.digitick.com/index-css5-nantesbaskethermine-pg1.html",
                  "http://www.nla-handball.fr/billetterie/internet.php",
                  "http://billetterie.stadenantais.dspsport.com/dsp/WEB/Site/index.htm?wId=SNR&rId=Ticketing",
                  "http://www.nahg.fr/accueil",
                  "http://narh.fr/",
                  "http://nantesmetropolefutsal.fr/");

$now = date("Y-m-d H:i:s");

$pdo = get_pdo();

$pdo->exec('SET NAMES UTF8');

$now = date('Y-m-d h:i:s', time());


$query = $pdo->prepare
('SELECT * FROM sn_teams ORDER BY id');

$query->execute();

$clubs = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i<=10; $i++){
    $query = $pdo->prepare
    (
        'SELECT
            *
         FROM sn_matches
         WHERE teamId=? AND start > ?
         ORDER BY start
         LIMIT 1'
    );

    $query->execute([$i+1,$now]);

    $res = $query->fetchAll(PDO::FETCH_ASSOC);

	if (empty($res)){
		$clubs[$i]['preview']=false;
		} else {
		$clubs[$i]['matches'] = $res;
        for ($j=0;$j<count($res);$j++){

            $clubs[$i]['matches'][$j]['teams'] = utf8_decode($clubs[$i]['matches'][$j]['teams']);

            $game_date = new \DateTimeImmutable($clubs[$i]['matches'][$j]['start']);

            $hour = $game_date->format('H:i');
            $month = $game_date->format('m');
            $day = $game_date->format('d');

            $weekday = str_replace('0','7',$game_date->format('w'));

            $clubs[$i]['matches'][$j]['day']= $day.' '.$months[$month-1];
            $clubs[$i]['matches'][$j]['weekday'] = $days[$weekday-1];
            $clubs[$i]['matches'][$j]['hour'] = $hour;
        };
		$clubs[$i]['preview']=true;
	}
}

include 'index.phtml';