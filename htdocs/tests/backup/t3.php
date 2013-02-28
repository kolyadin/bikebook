<?php

$filter = '{ka_person|title}';

if (preg_match('@\A\{(?P<table>[^\:\|]+)(\:(?P<sub>[^\|]+)|\|)(?P<field>.+)\}\z@',$filter,$matches))
{
	list($table,$sub,$field) = array($matches['table'],$matches['sub'],trim($matches['field'],'|'));
}



die;
$a = (unset)"binary";

print $a;

die;
$test = '/cat/1/2/3/4/page/1/';

if (preg_match('@\A\/cat\/1\/(\d?)\/3\/4\/(?:page\/(\d?)\/|)\z@',$test,$m))
{
	echo '<pre>'.print_r($m,1).'</pre>';
}

print 666;
print 667;
die;


echo '<pre>'.print_r($c,1).'</pre>';
die;
$keys = array_map(function($value,$key){
	print $value;
},$blocks);

echo '<pre>'.print_r($keys,1).'</pre>';

die;
array_walk($blocks,function(&$value,$key){
	if ($key&1) unset($value);
});

echo '<pre>'.print_r($blocks,1).'</pre>';

die;
$data = array(
	 'id'      => 12371
	,'title'   => 'Тестовое описание проблемы'
	,'content' => 'Бла-бла. Прикольная статья вышла, интересно, что будет дальше?'
);


$fileData = '';

foreach ($data as $k=>$v)
{
	$fileData .= $v;
	$fileData .= pack('L', strlen($v));
	$fileData .= $k;
	$fileData .= pack('L', strlen($k));
}


print $fileData;


$offset = strlen($fileData);
$decode = array();

do
{
	$slen = unpack('L', substr($fileData, $offset-=4, 4));
	$key = substr($fileData, $offset-=$slen, $slen);
	$decode[$key] = substr($fileData, $offset-=$slen, $slen);
}
while ($offset < 4);

echo '<pre>'.print_r($decode,1).'</pre>';



die;
$text = <<<EOL
<html>
	<head>
		<title>Первый тест-заголовок</title>
		<script type="text/javascript">
		$(function(){
			$('h1').replaceWith('h2');
		});
		</script>
	</head>
	<body>
		<span style="color:red;">asd</span>
	</body>
</html>
EOL;


#$data['text_json'] = serialize($data);

$file = $text.pack('L',strlen($text));

print $file;


#echo '<pre>'.print_r($data,1).'</pre>';
