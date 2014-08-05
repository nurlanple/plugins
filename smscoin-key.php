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

//if((stristr($pag['page_text'],'[smskey]') == true) && (stristr($pag['page_text'],'[/smskey]') == true ))
//{
header('Content-Type: text/html; charset=utf-8');
### SMS:Key v1.0.6 ###
$old_ua = @ini_set('user_agent', 'smscoin_key_1.0.7');

//ЕСЛИ ИСПОЛЬЗУЕМ БИБЛИОТЕКУ ТО ДЕЛАЕМ ТАК:
/**require_once(dirname(__FILE__).'/lib/config.php');
$key_id = KEY_ID; **/

//ЕСЛИ НЕТ ТО ТАК:
$key_id = $cfg['plugin']['smscoin-key']['key_id'];


$result = -1;
if (isset($_GET['s_pair']) && $_GET['s_pair'] !='' && strlen($_GET['s_pair'])<=10) {
	$result = do_key_local_check ($key_id, $_GET['s_pair'], $_GET['content']);
}


if ($response !== false) {
if ($result != 1) {
  //  $hidden = substr($pag['page_text'],0,strpos($pag['page_text'],'[smskey]')).implode("", $response).substr(stristr($pag['page_text'],'[/smskey]'), 9);
 //   $pag['page_text'] = $pag['page_tabs'][$pag['page_tab']];
 //  $t->assign(array(
 //       'PAGE_TEXT' => $hidden
  //  ));
  	$array_qs = array();
	parse_str($_SERVER["QUERY_STRING"], $array_qs);

	
	$filename = dirname(__FILE__).'/lib/local.xml';
	$slabs = xml2array(file_get_contents($filename));
	# check if there is any countries
	if (isset($slabs[0]['children']) && is_array($slabs[0]['children'])) {
		# countries one by one
		foreach ($slabs[0]['children'] as $i=>$slabb) {
			$slab = $slabb['attrs'];
		
			# check if there is separate pricing for different providers
	if (isset($slabb['children']) && count($slabb['children']) > 0) {
		
				foreach ($slabb['children'] as $k=>$slab_provider) {
					$slab = $slab_provider['attrs'];
					$output .= '
                                            




<div class="tab-pane" id="s'.$i.'_'.$k.'"> <br/>
   <p class="well well-smail" align="center" style="width:550px; ">	
Таңдаған дипломдық жұмысты алу үшін,<br/> 
<span class="label label-important" style="font-size:16px;">'.$slab['NUMBER'].'</span> номеріне <span class="label label-important" style="font-size:16px;">'.($slab['REWRITE']==''?$slab['PREFIX'].' '.$key_id:$slab['REWRITE']).' w'.$item['item_id'].'</span> мәтінімен SMS жіберіңіз.<br/> 				
					'.$slab['SPECIAL'].'</span>
   </p>                                         
         <p align="center"><span style="color:red;"><b>Көңіл бөліңіз!!! Мұқият болыңыз!!! Барлық әріптер латын (ағылшын)!!!</b> </span><br/>
Мәтінді көрсетілгендей енгізіңіз: <br/> 
<span class="label label-important" style="font-size:16px;">'.$slab['PREFIX'].'</span>
    және 
    <span class="label label-important" style="font-size:16px;">'.($slab['REWRITE']==''?$key_id:$slab['REWRITE']).'</span>
    және 
<span class="label label-important" style="font-size:16px;">w'.$item['item_id'].'</span>
    арасындағы 2 бос орынды ұмытпаңыз!<br/>
SMS қате жіберілген жағдайда, қызмет көрсетілген болып есептелінеді!<br/>
<span align="center"><b>SMS бағасы</b> <span class="text-success" style="font-size:18px;"><b>'.substr($slab['PRICE'], 0,3).' теңге.</b></span></span><br/> 
Сізге жауап ретінде кілт сөзі бар SMS келеді. <br/>
Сол кілт сөзді енгізіп. "Скачать" пернесін басыңыз. </p>                        
 <form name="smsform" action="http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"].'" method="get" class="well form-inline" style="text-align:center;">
     <label class="control-label">Пароль</label>
     <input name="e" type="hidden" value="projects" />
<input name="c" type="hidden" value="'.$item['item_cat'].'" />
<input name="al" type="hidden" value="'.$item['item_alias'].'" />     
<input name="s_pair" type="text" value="" />
<input name="content" type="hidden" value="w'.$item['item_id'].'" />
       <button class="btn btn-primary" type="submit" ><i class="icon-download-alt icon-white"></i>&nbsp;Жүктеу</button>
     <div class="pull-right"></div>
     </form>

					</div>';
				}
                               
			}  else {
				$output .= 'Для получения пароля, отправьте сообщение <span class="sms_msg">'.($slab['REWRITE']==''?$slab['PREFIX'].' '.$key_id:$slab['REWRITE']).'</span><br />
				на номер <span class="sms_num">'.$slab['NUMBER'].'</span>.<br />
				Стоимость сообщения <span class="sms_price">'.$slab['PRICE'].' '.$slab['CURRENCY'].' ('.($slab['VAT'] ? 'включая НДС' : 'не включая НДС').')<br />
				'.$slab['SPECIAL'].'</span></div>';
			}
			
		}
	}


    $t->assign(array(
//        'PRJ_SMS' => "<div>".substr($hidden, 4756, 10000)
         'PRJ_500' => $output 
    ));
    
 } else{
//	$pag['page_text'] = $pag['page_tabs'][$pag['page_tab']];
//    $pag['page_text'] = str_replace('[smskey]',null,$pag['page_text']);
//    $pag['page_text'] = str_replace('[/smskey]',null,$pag['page_text']);
//    $t->assign(array(
//        'PAGE_TEXT' => $pag['page_text']
 //   ));
    $t->assign(array(
        'PRJ_500' =>' 
    <br/> <div  align="center">       
<b>Сатып алғаныңызға рахмет!</b><br/>
Файлды төмендегі сілтеме арқылы жүктей аласыз: <br/><br/>



<a href="/datas/exflds/'.$item['item_document'].'" class="btn btn-primary"><i class="icon-download-alt icon-white"></i> Жүктеу</a>
    
</div><br/>'
        
       
    ));
 }
 
 if ($result != 1) {
     
      $t->assign(array(
//        'PRJ_SMS' => "<div>".substr($hidden, 4756, 10000)
         'PRJ_9999' => ''
    ));
 }
 
 else {
  $t->assign(array(
        'PRJ_9999' =>'<a href="/datas/exflds/'.$item['item_document'].'" class="btn btn-large btn-block btn-success">Жүктеу</a>'
        
       
    ));
 }
 
} else die('Не удалось запросить внешний сервер');
@ini_set('user_agent', $old_ua);
//}
?>
