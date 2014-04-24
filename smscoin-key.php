<?php 
/* ==================== 
[BEGIN_COT_EXT]
Code=smscoin-key 
Part=main 
File=smscoin-key 
Hooks=page.tags 
Tags= 
Order=10 
[END_COT_EXT]
==================== */  

defined('COT_CODE') or die('Wrong URL');

if((stristr($pag['page_text'],'[smskey]') == true) && (stristr($pag['page_text'],'[/smskey]') == true ))
{
header('Content-Type: text/html; charset=utf-8');
### SMS:Key v1.0.6 ###
$old_ua = @ini_set('user_agent', 'smscoin_key_1.0.7');
$key_id = $cfg['plugin']['smscoin-key']['key_id'];
$response = @file("http://key.smscoin.com/language/".$cfg['plugin']['smscoin-key']['lang']."/key/?s_pure=1&s_enc=utf-8&s_key=".$key_id
."&s_pair=".urlencode(substr($_GET["s_pair"],0,10))
."&s_language=".urlencode(substr($_GET["s_language"],0,10))
."&s_ip=".$_SERVER["REMOTE_ADDR"]
."&s_url=".$_SERVER["SERVER_NAME"].htmlentities(urlencode($_SERVER["REQUEST_URI"])));
if ($response !== false) {
 if (count($response)>1 || $response[0] != 'true') {
    $hidden = substr($pag['page_text'],0,strpos($pag['page_text'],'[smskey]')).implode("", $response).substr(stristr($pag['page_text'],'[/smskey]'), 9);
    $pag['page_text'] = $pag['page_tabs'][$pag['page_tab']];
    $t->assign(array(
        'PAGE_TEXT' => $hidden
    ));
 } else{
	$pag['page_text'] = $pag['page_tabs'][$pag['page_tab']];
    $pag['page_text'] = str_replace('[smskey]',null,$pag['page_text']);
    $pag['page_text'] = str_replace('[/smskey]',null,$pag['page_text']);
    $t->assign(array(
        'PAGE_TEXT' => $pag['page_text']
    ));
 }
} else die('Не удалось запросить внешний сервер');
@ini_set('user_agent', $old_ua);
}
?>
