<?php /**/ ?><?php
/**
 * @copyright  Copyright 2010 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Frank Angermann
 **/
class Tools
{
	/**
	 * remove Everything not being alphanumeric
	 * @var const
	 */
	const ALPH_NUM = "alphanumeric";
	
	/**
	 * Remove everything not being 0-9, A-Z or a-z
	 * @var const
	 */
	const ALPH_NUM_SAFE = "alphNumPlus";
	
	/**
	 * Remove German �,�,�,� and replace with ss, ae, ue, oe
	 * @var const
	 */
	const UML = "umlaut";
	
	/**
	 * Remove German ß, ä, ü,ö and replace with ss, ae, ue, oe
	 * @var const
	 */
	const UML2 = "umlaut2";
	
	/**
	 * Remove German html &uuml; etc and replace with e.g. �
	 * @var const
	 */
	const HTML = "html";
	
	/**
	 * alphanummeric filling to split a string again
	 * @var const
	 */
	const ALPH_NUM_SAFE_SPLIT = "alphNumPlusSplit";
	const delimiter = "zzzaaazz";
	
	
	/**
	 * 
	 * @param string $string String to be cleaned of values
	 * @param array $what Array with what to do (see Tools.php)
	 * @return string
	 */
	public static function removeCharacters($string, $what)
	{
		$out = $string;
		
		for($i = 0; $i < count($what); ++$i)
		{
			switch($what[$i])
			{
				case Tools::ALPH_NUM:
					$out = preg_replace('/\W+/', '', $out);
					break;
				case Tools::UML:
					$ger = array("�","�","�","�");
					$standard = array("ss","ue","oe","ae"); 
					$out = str_replace($ger,$standard,$out);					
					break;
				case Tools::UML2:
					$ger = array("ß","ü","ö","ä");
					$standard = array("ss","ue","oe","ae"); 
					$out = str_replace($ger,$standard,$out);					
					break;
				case Tools::HTML:
					$ger = array("&uuml;","&auml;","&ouml;");
					$standard = array("�","�","�"); 
					$out = str_replace($ger,$standard,$out);					
					break;
				case Tools::ALPH_NUM_SAFE:
					$out = preg_replace("@[^A-Za-z0-9\-_]+@i","",$out); 
					break;
				case Tools::ALPH_NUM_SAFE_SPLIT:
					$out = preg_replace("@[^A-Za-z0-9]+@i",Tools::delimiter,$out); 
					break;					
			}
		}
		
		return $out;
	}
	
	/**
	 * Cut a string to a certain length given by $char - 3 (last 3 characters "..." is being attached)
	 * @param $string string to be cut
	 * @param $char length of the string total (including the "..." automatically added)
	 * @return shortened string
	 * */
	public function cutString($string, $char = 255)
	{
		if(strlen($string) > $char)
			return substr($string, 0, $char - 3)."...";
		else
			return $string;		
	}
	
	/**
	 * HTML linebreaks to PHP linebrakes
	 * Remove all <br> or <br /> and replace with "\n".
	 * @param $str string where linebreaks shall be replaced
	 * @return $str with php linebreaks for HTML linebreaks
	 * 
	 * */
	public function br2nl($str) 
	{
  	 	$str = preg_replace("/(\r\n|\n|\r)/", "", $str);
   		return preg_replace("=<br */?>=i", "\n", $str);
	} 
	
	/**
	 * Calculate the distance between two points given by latitude and longitude
	 * @param float $latitude1 
	 * @param float $longitude1
	 * @param float $latitude2
	 * @param float $longitude2
	 * @return float distance in meters
	 */
	public function distanceBetweenLLAsInMeters($latitude1, $longitude1, $latitude2, $longitude2)
	{
		$deg2RadNumber = (float)(pi() / 180);
		$earthRadius= 6371009; 

		$latitudeDistance=((float)$latitude1-(float)$latitude2)*$deg2RadNumber;
        $longitudeDistance=((float)$longitude1-(float)$longitude2)*$deg2RadNumber;                                      
        $a=pow(sin($latitudeDistance/2.0),2) +  cos((float)$latitude1*$deg2RadNumber) * cos((float)$latitude2*$deg2RadNumber) * pow(sin($longitudeDistance/2.0),2);
		$c=2.0*atan2(sqrt($a),sqrt(1.0-$a));                                               
		$distance=$earthRadius*$c; 
		
		return $distance;
	}
	
	public function meterToMiles($meter)
	{
		return $meter / 1609.344;		
	}
	
	public static function encodeUTF8($x)
	{
		if(mb_detect_encoding($x)=='UTF-8')
			return $x;
		else
			return utf8_encode($x);			
	} 
	
	public static function decodeUTF8($x)
	{
		if(mb_detect_encoding($x)=='UTF-8')
			return utf8_decode($x);
		else
			return $x;
		
	} 
	
	public static function getNewLLAPosition($startLat, $startLon, $bearing, $distanceInM)
	{
		$earthRadius= 6371009; 
		$deg2RadNumber = (float)(pi() / 180.0);
		$rad2DegNumber = (float)(180.0 / pi());
		
		$AngularDistance = ($distanceInM / $earthRadius) * $deg2RadNumber;
		$startLat *= $deg2RadNumber;
		$startLon *= $deg2RadNumber;
		$bearing *= $deg2RadNumber;
		
		
		$lat2 = asin( sin($startLat) * cos($AngularDistance) + 
	                      cos($startLat)*sin($AngularDistance)*cos($bearing) );
		$lon2 = $startLon + atan2(sin($bearing)*sin($AngularDistance)*cos($startLat), 
	                             cos($AngularDistance)-sin($startLat)*sin($lat2));
	    
	    return array($lat2 * $rad2DegNumber , $lon2 * $rad2DegNumber);
	}	
}