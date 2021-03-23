<?php 
//$start = $_POST['s'];
//$loop  = $_POST['l'];
error_reporting(E_ALL);
ini_set("display_errors", 1);
// $start = $_GET['s'];
// $loop  = $_GET['l'];
// $chkbox  = $_GET['cb'];

ini_set('max_execution_time', 0);
ini_set("memory_limit", "1024M");
//require_once 'lib/config_db.php'; 
require_once 'simple_html_dom.php'; 
require_once 'config.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$email = '';
$subject = '';
$message = '';
$sent = false;
$start = 0;
$errors = [];
//require_once('PHPMailer5.2/PHPMailerAutoload.php');
//require_once 'lib/api.php'; 

header("Content-Type: text/html; charset=utf-8");

function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}



function sch_webidyoutube($keyword){
	$query =   $keyword; // $tsongname.' '. $tartist;//"จักรยานสีแดง เสกโลโซ";
	$url = 'https://www.youtube.com/results?search_query='.urlencode($query).'';
	$scrape = file_get_contents_curl($url);
	//echo urlencode($query).'<hr>';
	///echo $scrape.'<hr>';
	$doms = new simple_html_dom();
	$doms->load($scrape);	
	// div id="dismissable"

	//echo 'url: '.$url.'<hr>';
	foreach($doms->find('a') as $element){	
		$item['url'] .= $element->href.','; 
		
	}
	$xurl = explode(",",$item['url']);
	

		foreach($xurl  as $element)
		{	
		//echo substr($element,0,9).'<br>'; 

			if(substr($element,0,9)=="/watch?v="){
			$tidyoutube =  substr($element,9);
				break;
			} else {
				$tidyoutube ='';
			}
		}
	return $tidyoutube;
}

function sch_idyoutube($keyword){

	$query =   $keyword; // $tsongname.' '. $tartist;//"จักรยานสีแดง เสกโลโซ";
	echo 'idyoutube: '.$query.'<br>';
	$url = 'http://www.google.co.th/search?tbm=vid&source=lnms&tbm=vid&sa=X&q='.urlencode($query).'';
	$scrape = file_get_contents_curl($url);
	//echo urlencode($query).'<hr>';
	//echo $scrape.'<hr>';
	$doms = new simple_html_dom();
	$doms->load($scrape);	
		$n =0;
		foreach($doms->find('a') as $ele){
			$res = ($n==5)?  $link = $ele->href  : ""  ; 
			$n++;	
		}

			$xurl =  explode("&", $link );
			$tidyoutube =    substr($xurl[0],-11);
			//echo $tidyoutube.'<br>';

			unset($scrape);
			unset($doms);
			return $tidyoutube;
}  // echo fucntion sch_idyoutube



function getdata_chodtab($runnumber){  // id for run;
	$t=time();
	$ttime =  date("Y-m-d h:m:s",$t);
	
	  
					$url = 'http://chordtabs.in.th/song.php?song_id='.$runnumber;
				   
					$scapeurl=$url;				
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $scapeurl);	
					curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_TIMEOUT, '30');	
					curl_setopt($ch, CURLOPT_ENCODING ,"utf-8");
					$contents  = curl_exec($ch);
					curl_close($ch);
					$dom = new simple_html_dom();
					$dom->load($contents);
	
					//$doms = new simple_html_dom();
					//$doms->load($contents);
				
					$songlyric =  $dom->find('div[id=songMain]', 0)->innertext;// innertext plaintext
					 $restr = '<script type="text/javascript">xajax_getDefault();</script>';
					 $songlyric2  = trim(str_replace($restr,"",$songlyric));
					//echo '$songlyric: '.$songlyric.'<br>';
					
					//$songlyric =  $dom->find('div[id=songMain]', 0)->plaintext;
	
					$songlist =  $dom->find('td[style="border:1px dashed #999;background-color:#FFFCCC;padding-left:10px;font-size:18px;"]', 0)->plaintext;
					//echo ' $songlist : '.$songlist.'<br>'; 
	
					//$songlyric =  $dom->find('div[id=songMain]', 0)->innertext;
					
	
					//$songlyric = trim($songlyricx);
	
				    $tsonglists =  explode(":", $songlist);
					//$tartist =  mysqli_real_escape_string($sCon,trim($tsonglists[0]));
					//$tsongname =  mysqli_real_escape_string($sCon,trim($tsonglists[2]));
					//$talbum =  mysqli_real_escape_string($sCon,trim($tsonglists[1]));
					//$tmusiclabel =  mysqli_real_escape_string($sCon,trim($tsonglists[3]));
					$tartist =trim($tsonglists[0]);
					$tsongname =  trim($tsonglists[2]);
					$talbum =  trim($tsonglists[1]);
					$tmusiclabel = trim($tsonglists[3]);
					$addrel = array();
	
					//if($cb){
						$id_youtube = sch_idyoutube($tsongname.'+'.$tartist);
						//$id_youtube = sch_webidyoutube($tsongname.'+'.$tartist);			
						$shw_idyoutube = $id_youtube;
						$linkyoutube = '<a target="_blank" href="https://www.youtube.com/watch?v='.$shw_idyoutube.'">'.$shw_idyoutube.'</a>'.' ';
					// }else{
					// 	$id_youtube = '';
					// 	$shw_idyoutube = sel_font_color('Non ',"Red");
					// 	$linkyoutube = $shw_idyoutube.' ';
					// }
		 
				 	if((strlen($tsongname)>=1) &&  (strlen($tartist)>=1)){	
					
						$ads1 = '<br/><script type="text/javascript">google_ad_client="ca-pub-5492480815317469";google_ad_slot="1763805254";google_ad_width=300;google_ad_height=250;</script><!-- for content --><script src="//pagead2.googlesyndication.com/pagead/show_ads.js" type="text/javascript"></script>';
						$ads2 = '<br /><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Chordza Responsive --><ins class="adsbygoogle"  style="display:block" data-ad-client="ca-pub-5492480815317469" data-ad-slot="7570498455" data-ad-format="auto"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';    
						
						//$resultshw = 'ID : '.$runnumber.' ';
						//$resultshw .= 'Song : '.$tsongname.' ';
						//$resultshw .= 'Artist : '.$tartist.' ';
						//$resultshw .= 'Album : '.$talbum.' ';
						//$resultshw .= 'Music Label : '.$tmusiclabel.' ';
						//$resultshw  .= 'id Youtoube : '.$linkyoutube;
						//$resultshw  .=  '$songlyric : '.substr($songlyric,0,50).' ';
						$xtitel = 'เนื้อเพลง คอร์ด '.$tsongname.' - '.$tartist.' '.$talbum.' '.$tmusiclabel ;
						//$iembdeyoutube = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'.$linkyoutube.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>';
							
						$iembdeyoutube = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'.$id_youtube.'"  frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>';
						$xconntent = "<center><br><h2>".$xtitel."</h2></br>";	
						$xconntent .= $iembdeyoutube.'<br><center>'.$ads2.'</center>';
						$xconntent .= '<br><center> <h3>'.$xtitel.'</h3></center>';
						$xconntent .= $songlyric2;
						
						
						array_push($addrel,$xtitel,$xconntent);
						$resultshw = $addrel;
					
				} else {
	
					  $resultshw  = 'non';
					  if ($resultshw  = 'non') {
						$errors[] = 'No data subject';
					}
				
				}
				unset($dom);
				return  $resultshw ;
	
	
				   //echo '<hr>';
				  // return $sql.$values;
	  }  // END  getdata_chodtab..

	function sel_font_color($data,$color){   
       
		$fontx =  '<font  color="'.$color.'">'.$data.'</font>';
		return $fontx;
 
   }


   function logfile($data,$file){
	$t=time();
	$ttime =  date("Y-m-d h:m:s",$t);
			$myfile = fopen($file.".txt", "w") or die("Unable to open file!");
			//$told = fgets($myfile);
			//$txt = $ttime.' >> '.$data."\n".$told;
			$txt = $data;
			fwrite($myfile, $txt);
			fclose($myfile);
	} //End logfile

function rfile($file){
	$myfile = fopen("$file.txt", "r") or die("Unable to open file!");
	$tstr = fread($myfile,filesize($file.".txt"));
	fclose($myfile);
	return $tstr;
} // end rfile





  ////// -------------- Procress Zone ---------------------------


//echo 'Last Data: '.sel_data($conn,$tsql_seldata,$filde_sel).'<hr>';

echo 'logwork : '.rfile("logwork").'<hr>';
$nwork = intval(rfile("logwork")) + 1 ;
echo 'newlogwork : '.$nwork.'<hr>';
logfile($nwork,"logwork");

//$button_home = '<button type="button" onclick="window.location.href = "getchordtab.php";">Home</button>';
?> 



<?php

 $x = $nwork;
	              // if(chk_idsong($x,$conn)>=1){
					if($start==1){

	                  	$report =  $x.' HAVE Data..!!'; 	
	                  //	echo sel_font_color($report,"red");  
	                  	             	
	                  } else {
	                  //	echo $nums .' : ';
	                  	$resultdata  = getdata_chodtab($x);
						//  print_r(	$resultdata );
	                  	if(	$resultdata == 'non') {
                          echo sel_font_color("Non have data..from URL !!!","red");  
	                  	//$nums++;

	                  	} else {
	                  	//	echo $resultdata;
						 // print_r(	$resultdata );
	                  		echo sel_font_color("New Insert Reccord $x : $resultdata[0] ","green");  
	                  //	$nums++;
	                  }
	                
	                  	//echo '<font  color="green">New Insert Reccord Data!!</font>';
	                  	
	                  }
	               
	             echo '<hr>';
				flush();
				ob_flush();
//	} 

	//echo '<hr><a href="exportcsv.php" method="get" ><button name="order">'.$start.'</button></a>';
//}
if(	$resultdata != 'non'){
	 
if (empty($errors)) {

	$mail = new PHPMailer(true);
	try
	{

		$subject = $resultdata[0].' '.POSFIX;
		$message = $resultdata[1];
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->CharSet = 'UTF-8';
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = SMTP_SECURE; // secure transfer enabled REQUIRED for Gmail
		$mail->Host =  SMTP_HOST; //"smtp.gmail.com";
		$mail->Port = SMTP_PORT; // 465 or 587
		$mail->IsHTML(true);
		$mail->Username =  SMTP_USER; // "somporn5913unapasita@gmail.com";
		$mail->Password =  SMTP_PASS; //"FECC463811";
		$mail->SetFrom(SMTP_SETFROM);
		$mail->Subject = $subject; //"testtest";
		$mail->Body = $message; //"test";
		$mail->AddAddress(SMTP_EMAILADDRESS);  //  // SMTP_ADDRESS  // somporn5913unapasita@gmail.com
		$mail->AddAddress(SMTP_EMAILADDRESS2);
		$mail->AddAddress(SMTP_EMAILADDRESS3);
		
		$mail->AddReplyTo(SMTP_EMAILREPLYTO);  // // gamblings2019.sharenow@blogger.com



		$mail->send();

		$sent = true;
	}
	catch(Exception $e)
	{
		$errors[] = $mail->ErrorInfo;
	}

}


}
echo memory_get_usage();
exit();
?>