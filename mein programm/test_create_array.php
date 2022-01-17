
<?php

/*
	besttraveltime 
	(if may-august then -> 23) later asked str_contains
	a number is given if 2 or more months are included
	sources: https://wetter-atlas.de/
			 https://wohin-und-wann.de/
			 https://diebestereisezeit.de/
	1=>DEZ-FEB
	2=>MAR-MAY
	3=>JUN-AUG
	4=>SEP-NOV 
	*/
	$countryarray = array(
		0 => array (
			'name'=>'abudhabi',
			'count'=>0,
			'besttraveltime'=> '1',
			'group'=>'',
		),
		1 => array (
			'name'=>'admiralty', 
			'count'=>0,
			'besttraveltime'=>'3',
			'group'=>'papuanewguinea',
		),
		2 => array (
			'name'=>'afghanistan',
			'count'=>0,
			'besttraveltime'=> '24',
			'group'=>'',
		),
		3 => array (
			'name'=>'aitutaki', 
			'count'=>0,
			'besttraveltime'=> '234',
			'group'=>'cookislands',
		),
		4 => array (
			'name'=>'ajman', 
			'count'=>0,
			'besttraveltime'=> '12',
			'group'=>'emirates',
		),
		5 => array (
			'name'=>'åland', 
			'count'=>0,
			'besttraveltime'=> '3',
			'group'=>'finnland',
		),
		6 => array (
			'name'=>'albania',
			'count'=>0,
			'besttraveltime'=> '234',
			'group'=>'',
		),
		7 => array (
			'name'=>'alberta', 
			'count'=>0,
			'besttraveltime'=> '3',
			'group'=>'canada',
		),
		8 => array (
			'name'=>'alderney', 
			'count'=>0,
			'besttraveltime'=> '34',
			'group'=>'greatbritain', 
		),
		9 => array (
			'name'=>'algeria',
			'count'=>0,
			'besttraveltime'=> '234',
			'group'=>'',
		),
		10 => array (
			'name'=>'alhucemas', //spain
			'count'=>0,
			'besttraveltime'=> '34',
			'group'=>'spain',
		),
		11 => array (
			'name'=>'alofi', //caledonia
			'count'=>0,
			'besttraveltime'=> '34',
			'group'=>'newcaledonia',
		),
		12 => array (
			'name'=>'samoa',
			'count'=>0,
			'besttraveltime'=> '34',
			'group'=>'',
		),
		13 => array (
			'name'=>'andaman',
			'count'=>0,
			'besttraveltime'=> '12',
			'group'=>'',
		),
		14 => array (
			'name'=>'andorra',
			'count'=>0,
			'besttraveltime'=> '',
			'group'=>'',
		),
		15 => array (
			'name'=>'angola',
			'count'=>0,
			'besttraveltime'=> '',
			'group'=>'',
		),
		16 => array (
			'name'=>'anguilla',
			'count'=>0,
			'besttraveltime'=> '',
			'group'=>'caribbeanislands',
		),
		17 => array (
			'name'=>'anjouan', 
			'count'=>0,
			'besttraveltime'=> '',
			'group'=>'comoros',
		),
		18 => array (
			'name'=>'annobon', 
			'count'=>0,
			'besttraveltime'=> '',
			'group'=>'equatorialguinea',
		),
		19 => array (
			'name'=>'antigua',
			'count'=>0,
			'besttraveltime'=> '',
			'group'=>'caribbeanislands',
		),
		20 => array (
			'name'=>'barbuda',
			'count'=>0,
			'besttraveltime'=> '',
			'group'=>'caribbeanislands',
		),
	);

	$jsnon_countryarray = json_encode($countryarray);
	$test_country = 'testcountry' . '.json';

	if (file_put_contents($test_country,$jsnon_countryarray)){
		echo $test_country . 'file created';
	}else{
		echo 'error';
	};
?>