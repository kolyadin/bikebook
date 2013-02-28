<?php
$path = '/a/b/c/d/e';

$p = preg_split('@\/@',$path,-1,PREG_SPLIT_NO_EMPTY);

$method = array_pop($p);
$file = array_pop($p);

print implode('/',$p).'/'.$file;

print '<pre>'.print_r($p,true).'</pre>';