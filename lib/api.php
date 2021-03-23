<?php 
// Function Zone
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


function getdata_chodtab($runnumber,$sCon,$cb){  // id for run;
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

                $songlyric =  $dom->find('div[id=songMain]', 0)->plaintext;
				//$songlyric =  $dom->find('div[id=songMain]', 0)->plaintext;

                $songlist =  $dom->find('td[style="border:1px dashed #999;background-color:#FFFCCC;padding-left:10px;font-size:18px;"]', 0)->plaintext;

				//$songlyric =  $dom->find('div[id=songMain]', 0)->innertext;
				

				//$songlyric = trim($songlyricx);

				$tsonglists =  explode(":", $songlist);
				$tartist =  mysqli_real_escape_string($sCon,trim($tsonglists[0]));
				$tsongname =  mysqli_real_escape_string($sCon,trim($tsonglists[2]));
				$talbum =  mysqli_real_escape_string($sCon,trim($tsonglists[1]));
				$tmusiclabel =  mysqli_real_escape_string($sCon,trim($tsonglists[3]));

				if($cb){
					$id_youtube = sch_idyoutube($tsongname.'+'.$tartist);
					//$id_youtube = sch_webidyoutube($tsongname.'+'.$tartist);			
					$shw_idyoutube = $id_youtube;
					$linkyoutube = '<a target="_blank" href="https://www.youtube.com/watch?v='.$shw_idyoutube.'">'.$shw_idyoutube.'</a>'.' ';
				}else{
					$id_youtube = '';
					$shw_idyoutube = sel_font_color('Non ',"Red");
					$linkyoutube = $shw_idyoutube.' ';
				}
	 
			    if((strlen($tsongname)>=1) &&  (strlen($tartist)>=1)){	
		$resultshw = 'ID : '.$runnumber.' ';
		$resultshw .= 'Song : '.$tsongname.' ';
		$resultshw .= 'Artist : '.$tartist.' ';
		$resultshw .= 'Album : '.$talbum.' ';
		$resultshw .= 'Music Label : '.$tmusiclabel.' ';
		$resultshw  .='id Youtoube : '.$linkyoutube;
		$resultshw  .=  '$songlyric : '.substr($songlyric,0,50).' ';
				$sql = 'INSERT INTO  lyrics ( id ,idchordtab ,fTitel ,fArtist ,fLyric ,fAlbum ,ftypesong ,ftag ,fimgchord ,fidyoutube ,fmusiclabel ,fopt3 ,fCreatedate ,fEditdate ) ';
				$values = " VALUES( NULL,
				          '".$runnumber."',
				          '".str_replace("_"," ",$tsongname)."',
				          '".str_replace("_"," ",$tartist)."',
				          '".trim(mysqli_real_escape_string($sCon,$songlyric))."',
				          '".$talbum."',
				          '".''."',
				          '".$tartist.':'.$talbum.':'.$tmusiclabel."', 
				          '".''."',
				          '".$id_youtube."',
				          '".$tmusiclabel."',
				          '".''."',
				           '".$ttime."',
				           '".$ttime."'
			              );";
                  //    echo $sql.$values ;
                 ins_data( $sCon,$sql.$values);   // insert data !!!!!!
            
               //$resultshw  = $sql.$values;
            } else {

                  $resultshw  = 'non';
			}
			unset($dom);
            return  $resultshw ;


               //echo '<hr>';
              // return $sql.$values;
  }  // END  getdata_chodtab..


  function sel_data($ConDb,$tsql,$filde){
  	    $ifiled = explode(",", $filde); 
  	     $xrow  = "";       
  		 if( $objQuery = mysqli_query($ConDb, $tsql  )){    			
          while($row=mysqli_fetch_array($objQuery,MYSQLI_ASSOC))
                {                
                	foreach($ifiled as $key) {
                    $xrow .=  $row[$key].':';
                    }
                   $result = 'result : '.$xrow;
                }
  		   } else {
  			$result = "Error: " . $tsql . "<br>" . $ConDb->error;
  		   }
  		   return $result ;
  } // END sel_data

  function ins_data($ConDb,$tsql){
  	//$result=mysqli_query($ConDb,$sql)
  	if ($ConDb->query($tsql) === TRUE) {
       $result = " New record created successfully";
      } else {
       $result = "Error: " . $tsql . "<br>" . $ConDb->error;
      }
      return $result;
  } // END  ins_data

  function upd_data($ConDb,$tsql){
  	//$result=mysqli_query($ConDb,$sql)
  	if ($ConDb->query($tsql) === TRUE) {
       $result = "Update Record successfully";
      } else {
       $result = "Error: " . $tsql . "<br>" . $ConDb->error;
      }
      return $result;
  } // END  ins_data

  function chk_idsong($id,$ConDb){

  	      $sql = "SELECT * from lyrics where idchordtab = '".$id."'";
                $rowcount = 0;
				if ($result=mysqli_query($ConDb,$sql))
				{				
				$rowcount=mysqli_num_rows($result);				
				mysqli_free_result($result);
				}      
                	return  $rowcount;
  } //End chk_idsong

	function logfile($data){
		$t=time();
		$ttime =  date("Y-m-d h:m:s",$t);
				$myfile = fopen("logfile.txt", "w") or die("Unable to open file!");
				$told = fgets($myfile);
				$txt = $ttime.' >> '.$data."\n".$told;
				fwrite($myfile, $txt);
				fclose($myfile);
		} //End logfile

	function rfile($order){
		$myfile = fopen("logfile.txt", $order) or die("Unable to open file!");
		$tstr = fread($myfile,filesize("logfile.txt"));
		fclose($myfile);
		return $tstr;
	} // end rfile



  function sel_font_color($data,$color){   
       
       $fontx =  '<font  color="'.$color.'">'.$data.'</font>';
       return $fontx;

  }

  ////// ------------- Function ZONE -------------------------
?> 

