<?php /**/ ?><?php
/**
 * @copyright  Copyright 2010 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Frank Angermann
 **/
require_once 'SimpleXMLExtended.php';
require_once 'SinglePOI.php';
require_once 'MimeTypes.php';
require_once 'Tools.php';
require_once 'Interactions.php';

class JunaioBuilder 
{
	/**
	 * 
	 * Constructor
	 * @param array current user position, expects array with lat and lng
	 * @param int maximal distance in meters of where POIs will be output
	 * @param bool if POIs are at the same position, shall they be spread (-0.1..0.1 lat and long)
	 */
	public function __construct($userPosition = null, $maxDistance = null, $spread = false)
	{
		$this->aUserPosition = $userPosition;
		$this->iDistance = $maxDistance;
		$this->bActivateSpreading = $spread;	
		$this->aLocations = array();		
	}
	
	/**
	 * 
	 * array current user position, expects array with lat and lng
	 * @var array
	 */
	public $aUserPosition = NULL;
	
	/**
	 * 
	 * int maximal distance in meters of where POIs will be output
	 * @var integer
	 */
	public $iDistance = NULL;	
	
	/**
	 * 
	 * Array with location already taken in this round
	 * @var unknown_type
	 */
	public $aLocations = NULL;
	
	/**
	 * 
	 * bool if POIs are at the same position, shall they be spread (-0.1..0.1 lat and long)
	 * @var unknown_type
	 */
	public $bActivateSpreading = NULL;
	
	/**
	 * 
	 * Create a text location based POI
	 * @param string $name
	 * @param string $location
	 * @param string $description
	 * @param string $icon
	 * @param string $thumbnail
	 * @param string $id
	 * @param string $showNavigationButton
	 * @param string $interactionFeedback
	 */
	public function createTextLBPOI($name = "", $location = "", $description = "", $icon = "", $thumbnail = "", $id = "", $showNavigationButton = "", $interactionFeedback = "none")
	{
		return self::createBasicLocationBasedPOI($name, $location, $description, $icon, $thumbnail, $id, $showNavigationButton, $interactionFeedback);
	}

	/**
	 * 
	 * Create a text location based POI
	 * @param string $name Name of the POI to be displayed in the 
	 * @param string $location POI's location as a string with latitude, longitude and altitude value separated by comma ("11.4564,34.23456,0")
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $icon Icon to be used on the map for the POI
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $showNavigationButton "true" if route button shall be displayed, "false" otherwise
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	
	public function createBasicLocationBasedPOI($name, $location, $description = NULL, $icon = NULL, $thumbnail = NULL, $id = NULL, $showNavigationButton = NULL, $interactionFeedback = "none")
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		if((isset($name) && trim($name) == "") || (isset($location) && trim($location) == ""))
			trigger_error("Name and Location must be given");
			
		$poi->setName($name);
		$poi->setLocation($location);
		$poi->setOrientation("0,0,0");
		$poi->setMIMEType(MimeTypes::TEXT);
		
		if(isset($id) && trim($id) != "")
			$poi->setPoiid($id);
		else
			$poi->setPoiid($tools->removeCharacters($name . $location, array(Tools::ALPH_NUM_SAFE)));
			
		$poi->setInteractionType($interactionFeedback);
		
		if(isset($showNavigationButton) && trim($showNavigationButton) != "")
			$poi->setShowNavigateToButton($showNavigationButton); 
		
		if(isset($description) && trim($description) != "")
			$poi->setDescription($description);

		if(isset($thumbnail) && trim($thumbnail) != "")
			$poi->setThumbpath($thumbnail);
		
		if(isset($icon) && trim($icon) != "")
			$poi->setIcon($icon);		
		
		return $poi;
	}
	
	/** 
	 * Create an image location based POI
	 * @param string $name Name of the POI to be displayed in the 
	 * @param string $location POI's location as a string with latitude, longitude and altitude value separated by comma ("11.4564,34.23456,0")
	 * @param string $mainresource Absolute path to the image file (png / jpg)
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $icon Icon to be used on the map for the POI
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $showNavigationButton "true" if route button shall be displayed, "false" otherwise
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	
	public function createImageLBPOI($name, $location, $mainresource, $description = NULL, $icon = NULL, $thumbnail = NULL, $id = NULL, $showNavigationButton = NULL, $interactionFeedback = "none")
	{
		return self::createImageLocationBasedPOI($name, $location, $mainresource, $description, $icon, $thumbnail, $id, $showNavigationButton, $interactionFeedback);
	}
	
	/**
	 * 
	 * Create an image location based POI
	 * @param string $name Name of the POI to be displayed in the 
	 * @param string $location POI's location as a string with latitude, longitude and altitude value separated by comma ("11.4564,34.23456,0")
	 * @param string $mainresource Absolute path to the image file (png / jpg)
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $icon Icon to be used on the map for the POI
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $showNavigationButton "true" if route button shall be displayed, "false" otherwise
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	
	public function createImageLocationBasedPOI($name, $location, $mainresource, $description = NULL, $icon = NULL, $thumbnail = NULL, $id = NULL, $showNavigationButton = NULL, $interactionFeedback = "none")
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		if(trim($name) == "" || trim($location) == "" || trim($mainresource) == "")
			trigger_error("Name, Location and Mainresource must be given");
			
		$poi->setName($name);
		$poi->setLocation($location);
		$poi->setOrientation("0,0,0");
		$poi->setMainResource($mainresource);
		
		if(strtolower(substr($mainresource, -3)) == "png")
			$poi->setMIMEType(MimeTypes::PNG);
		else
			$poi->setMIMEType(MimeTypes::JPG);
		
		if(trim($id) != "")
			$poi->setPoiid($id);
		else
			$poi->setPoiid($tools->removeCharacters($name . $location, array(Tools::ALPH_NUM_SAFE)));
			
		$poi->setInteractionType($interactionFeedback);
		
		if(trim($showNavigationButton) != "")
			$poi->setShowNavigateToButton($showNavigationButton); 
		
		if(trim($description) != "")
			$poi->setDescription($description);

		if(trim($thumbnail) != "")
			$poi->setThumbpath($thumbnail);
		
		if(trim($icon) != "")
			$poi->setIcon($icon);		
		
		return $poi;
	}
	
	/**
	 * 
	 * Create a sound/audio location based POI
	 * @param string $name Name of the POI to be displayed in the 
	 * @param string $location POI's location as a string with latitude, longitude and altitude value separated by comma ("11.4564,34.23456,0")
	 * @param string $mainresource Absolute path to the sound file (mp3)
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $icon Icon to be used on the map for the POI
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $showNavigationButton "true" if route button shall be displayed, "false" otherwise
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	
	public function createSoundLBPOI($name, $location, $mainresource, $description = "", $icon = "", $thumbnail = "", $id = "", $showNavigationButton = "", $interactionFeedback = "none")
	{
		return self::createSoundLocationBasedPOI($name, $location, $mainresource, $description, $icon, $thumbnail, $id, $showNavigationButton = "", $interactionFeedback);	
	}
	
	/**
	 * 
	 * Create a sound/audio location based POI
	 * @param string $name Name of the POI to be displayed in the 
	 * @param string $location POI's location as a string with latitude, longitude and altitude value separated by comma ("11.4564,34.23456,0")
	 * @param string $mainresource Absolute path to the sound file (mp3)
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $icon Icon to be used on the map for the POI
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $showNavigationButton "true" if route button shall be displayed, "false" otherwise
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	
	public function createSoundLocationBasedPOI($name, $location, $mainresource, $description = "", $icon = "", $thumbnail = "", $id = "", $showNavigationButton = "", $interactionFeedback = "none")
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		if(trim($name) == "" || trim($location) == "" || trim($mainresource) == "")
			trigger_error("Name, Location and Mainresource must be given");
			
		$poi->setName($name);
		$poi->setLocation($location);
		$poi->setOrientation("0,0,0");
		$poi->setMainResource($mainresource);
		
		$poi->setMIMEType(MimeTypes::MP3);
		
		if(trim($id) != "")
			$poi->setPoiid($id);
		else
			$poi->setPoiid($tools->removeCharacters($name . $location, array(Tools::ALPH_NUM_SAFE)));
			
		$poi->setInteractionType($interactionFeedback);
		
		if(trim($showNavigationButton) != "")
			$poi->setShowNavigateToButton($showNavigationButton); 
		
		if(trim($description) != "")
			$poi->setDescription($description);

		if(trim($thumbnail) != "")
			$poi->setThumbpath($thumbnail);
		
		if(trim($icon) != "")
			$poi->setIcon($icon);		
		
		return $poi;
	}
	
	/**
	 * 
	 * Create a video location based POI
	 * @param string $name Name of the POI to be displayed in the 
	 * @param string $location POI's location as a string with latitude, longitude and altitude value separated by comma ("11.4564,34.23456,0")
	 * @param string $mainresource Absolute path to the video file (mp4)
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $icon Icon to be used on the map for the POI
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $showNavigationButton "true" if route button shall be displayed, "false" otherwise
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	
	public function createVideoLBPOI($name = "", $location = "", $mainresource = "", $description = "", $icon = "", $thumbnail = "", $id = "", $showNavigationButton = "", $interactionFeedback = "none")
	{
		return self::createVideoLocationBasedPOI($name, $location, $mainresource, $description, $icon, $thumbnail, $id, $showNavigationButton, $interactionFeedback);
	}
	
	/**
	 * 
	 * Create a video location based POI
	 * @param string $name Name of the POI to be displayed in the 
	 * @param string $location POI's location as a string with latitude, longitude and altitude value separated by comma ("11.4564,34.23456,0")
	 * @param string $mainresource Absolute path to the video file (mp4)
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $icon Icon to be used on the map for the POI
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $showNavigationButton "true" if route button shall be displayed, "false" otherwise
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	
	public function createVideoLocationBasedPOI($name = "", $location = "", $mainresource = "", $description = "", $icon = "", $thumbnail = "", $id = "", $showNavigationButton = "", $interactionFeedback = "none")
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		if(trim($name) == "" || trim($location) == "" || trim($mainresource) == "")
			trigger_error("Name, Location and Mainresource must be given");
			
		$poi->setName($name);
		$poi->setLocation($location);
		$poi->setOrientation("0,0,0");
		$poi->setMainResource($mainresource);
		
		$poi->setMIMEType(MimeTypes::MP4_video);
		
		if(trim($id) != "")
			$poi->setPoiid($id);
		else
			$poi->setPoiid($tools->removeCharacters($name . $location, array(Tools::ALPH_NUM_SAFE)));
			
		$poi->setInteractionType($interactionFeedback);
		
		if(trim($showNavigationButton) != "")
			$poi->setShowNavigateToButton($showNavigationButton); 
		
		if(trim($description) != "")
			$poi->setDescription($description);

		if(trim($thumbnail) != "")
			$poi->setThumbpath($thumbnail);
		
		if(trim($icon) != "")
			$poi->setIcon($icon);		
		
		return $poi;
	}
		
	/**
	 * 
	 * Creates a GLUE/Scan POI with 3D model
	  * @param string $name Name of the POI to be displayed in the 
	 * @param string $translation POI's translation from (0,0,0) as a string with x, y and z value separated by comma ("20,0,0")
	 * @param string $mainresource Absolute path to encrypted md2 file or zip file with obj models
	 * @param string $resource Absolute path to the texture file for a md2 object
	 * @param float $scale scale value of the 3D model
	 * @param int $cosID states the coordinate system to which the model shall be attached. Please see the tracking xml creator at www.junaio.com/publisher/junaioGlue for more information
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $orientation POI's rotation as a string with x, y and z values separated by comma according to the rotation around the axis. Rotation in radians as Euler angles ("1.57,0,0")
	 * @param array $behaviourArray an array defining the behaviour. Example: if on "idle" the animation "start" shall be played looped, do: array("idle" => array("start", 0));
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	public function createGluePOI($name = "", $translation = "", $mainresource = "", $resource = "", $scale = "", $description = "", $thumbnail = "", $id = "", $orientation = "0,0,0", $behaviourArray = array(), $interactionFeedback = "none", $cosID = 1)
	{
		return self::createBasicGluePOI($name, $translation, $mainresource, $resource, $scale, $cosID, $description, $thumbnail, $id, $orientation, $behaviourArray, $interactionFeedback);
	}
	
	/**
	 * 
	 * Creates a GLUE/Scan POI with 3D model
	  * @param string $name Name of the POI to be displayed in the 
	 * @param string $translation POI's translation from (0,0,0) as a string with x, y and z value separated by comma ("20,0,0")
	 * @param string $mainresource Absolute path to encrypted md2 file or zip file with obj models
	 * @param string $resource Absolute path to the texture file for a md2 object
	 * @param float $scale scale value of the 3D model
	 * @param int $cosID states the coordinate system to which the model shall be attached. Please see the tracking xml creator at www.junaio.com/publisher/junaioGlue for more information
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $orientation POI's rotation as a string with x, y and z values separated by comma according to the rotation around the axis. Rotation in radians as Euler angles ("1.57,0,0")
	 * @param array $behaviourArray an array defining the behaviour. Example: if on "idle" the animation "start" shall be played looped, do: array("idle" => array("start", 0));
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	 
	public function createBasicGluePOI($name, $translation, $mainresource = NULL, $resource = NULL, $scale = NULL, $cosID = 1, $description = NULL, $thumbnail = NULL, $id = NULL, $orientation = "0,0,0", $behaviourArray = array(), $interactionFeedback = "none")
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		if(trim($name) == "" || trim($translation) == "")
			trigger_error("Name and Translation must be given");
			
		$poi->setName($name);
		$poi->setTranslation($translation);
		$poi->setForce3D("true");
		$poi->setOrientation($orientation);
		$poi->setCosID($cosID);
		
		if(trim($id) != "")
			$poi->setPoiid($id);
		else
			$poi->setPoiid($tools->removeCharacters($name . $translation, array(Tools::ALPH_NUM_SAFE)));
			
		$poi->setInteractionType($interactionFeedback);
		
		if(trim($description) != "")
			$poi->setDescription($description);

		if(trim($thumbnail) != "")
			$poi->setThumbpath($thumbnail);
		
		if(trim($scale) != "")
			$poi->setScale($scale);	

		if(trim($mainresource) != "")
		{
			$poi->setMainResource($mainresource);
			$extension = substr($mainresource, -strpos(strrev($mainresource), "."));
			
			if(strpos(strtolower($extension), "md2") !== FALSE)
			{
				$poi->setMIMEType(MimeTypes::MD2);
				
				if(count($behaviourArray) > 0)
				{
					foreach($behaviourArray as $type => $behaviour)
					{
						$beh = new Behaviour();
						$beh->setType($type);
						$beh->setLength($behaviour[1]);
						$beh->setNodeID($behaviour[0]);
						
						$poi->addBehaviour($beh);
					}
				}
				
				if(trim($resource) != "")
					$poi->setResources(array($resource));
				else
					trigger_error("resource needed for md2 model.");
			}
			else
				$poi->setMIMEType(MimeTypes::OBJ);
		}
					
		return $poi;
	}
	
	/**
	 * Create a trigger to start a full screen movie based on the GLUE pattern detection
	 * @param string $id POI id
	 * @param string $moviePath path to the movie file to be triggered (mp4)
	 * @param int $cosID id of the pattern / cos to be detected
	 */
	
	public function createMovieTrigger($id = "", $moviePath = "", $cosID = 1)
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		$poi->setName($id);
		$poi->setTranslation("0,0,0");
		$poi->setForce3D("true");
		$poi->setOrientation("0,0,0");
		
		if(trim($id) != "")
			$poi->setPoiid($id);		
			
		$poi->setInteractionType("none");
		$poi->setScale("1");	

		$poi->setMainResource(" ");			
		$poi->setMIMEType(MimeTypes::MP4_video);
		$poi->setCosid($cosID);
		
		$cust = new Customization();
		$cust->setName("videoTrigger");
		$cust->setType("video");
		$cust->setNodeID("onTargetDetect");
		$cust->setValue($moviePath);
		
		$poi->addCustomization($cust);
							
		return $poi;
	}
	
	/**
	 * Create a trigger to open a website based on the GLUE pattern detection
	 * @param string $id POI id
	 * @param string $url website url to be opened
	 * @param int $cosID id of the pattern / cos to be detected
	 */
	
	public function createWebsiteTrigger($id = "", $url = "", $cosID = 1)
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		$poi->setName($id);
		$poi->setTranslation("0,0,0");
		$poi->setForce3D("true");
		$poi->setOrientation("0,0,0");
		
		if(trim($id) != "")
			$poi->setPoiid($id);		
			
		$poi->setInteractionType("none");
		$poi->setScale("1");	

		$poi->setMainResource(" ");			
		$poi->setCosid($cosID);
		
		$cust = new Customization();
		$cust->setName("webTrigger");
		$cust->setType("url");
		$cust->setNodeID("onTargetDetect");
		$cust->setValue($url);
		
		$poi->addCustomization($cust);
							
		return $poi;
	}
	
	/**
	 * Create a trigger to send a pois/event request to your server
	 * @param string $id POI id
	 * @param int $cosID id of the pattern / cos to be detected
	 */
	
	public function createEventTrigger($id, $cosID = 1)
	{
		$tools = new Tools();
		$poi = new SinglePOI();
						
		if(trim($id) != "")
			$poi->setPoiid($id);		
			
		$poi->setTranslation("0,0,0");
		$poi->setForce3D("true");
		$poi->setOrientation("0,0,0");	
		$poi->setInteractionType("none");
		$poi->setCosid($cosID);
		
		$cust = new Customization();
		$cust->setName("eventTrigger");
		$cust->setType("triggerEvent");
		$cust->setNodeID("onTargetDetect");
		$cust->setValue("1");
		
		$poi->addCustomization($cust);
							
		return $poi;
	}
	
	/**
	 * Create a trigger to start a sound on the GLUE pattern detection
	 * @param string $id POI id
	 * @param string $soundPath website url to be opened
	 * @param int $cosID id of the pattern / cos to be detected
	 */
	
	public function createSoundTrigger($id = "", $soundPath = "", $cosID = 1)
      {
            $tools = new Tools();
            $poi = new SinglePOI();
            
            $poi->setName($id);
            $poi->setTranslation("0,0,0");
            $poi->setForce3D("true");
            $poi->setOrientation("0,0,0");
            $poi->setMIMEType("audio/mp3");
            
            if(trim($id) != "")
                  $poi->setPoiid($id);         
                  
            $poi->setInteractionType("none");
            $poi->setScale("1");    

            $poi->setMainResource(" ");              
            $poi->setCosid($cosID);
            
            $cust = new Customization();
            $cust->setName("soundTrigger");
            $cust->setType("sound");
            $cust->setNodeID("onTargetDetect");
            $cust->setValue($soundPath);
            
            $poi->addCustomization($cust);
                                         
            return $poi;
      }
      
      /**
	 * Create a trigger to switch the channel once the pattern is detected
	 * @param string $id POI id
	 * @param int $channelID channel to be opened
	 * @param int $cosID id of the pattern / cos to be detected
	 */
      public function createChannelSwitchTrigger($id = "", $channelID = "", $cosID = 1)
      {
            $tools = new Tools();
            $poi = new SinglePOI();
            
            $poi->setName($id);
            $poi->setTranslation("0,0,0");
            $poi->setForce3D("true");
            $poi->setOrientation("0,0,0");
            $poi->setMIMEType("video/mp4");
            
            if(trim($id) != "")
                  $poi->setPoiid($id);         
                  
            $poi->setInteractionType("none");
            $poi->setScale("1");    

            $poi->setMainResource(" ");              
            $poi->setCosid($cosID);
            
            $cust = new Customization();
            $cust->setName("SwitchChannel");
            $cust->setType("switchChannel");
            $cust->setNodeID("onTargetDetect");
            $cust->setValue($channelID);
            
            $poi->addCustomization($cust);
                                         
            return $poi;
      }
	
      /**
	 * 
	 * Creates 3D Location Based POI
	 * @param string $name Name of the POI to be displayed in the
	 * @param string $location POI's location as a string with latitude, longitude and altitude value separated by comma ("11.4564,34.23456,0")
	 * @param string $mainresource Absolute path to encrypted md2 file or zip file with obj models
	 * @param string $resource Absolute path to the texture file for a md2 object
	 * @param float $scale scale value of the 3D model
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $orientation POI's rotation as a string with x, y and z values separated by comma according to the rotation around the axis. Rotation in radians as Euler angles ("1.57,0,0")
	 * @param array $behaviourArray an array defining the behaviour. Example: if on "idle" the animation "start" shall be played looped, do: array("idle" => array("start", 0));
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	public function create3DLBPOI($name = "", $location = "", $mainresource = "", $resource = "", $scale = "", $description = "", $thumbnail = "", $id = "", $orientation = "0,0,0", $behaviourArray = array(), $interactionFeedback = "none")
	{
		return self::create3DLocationBasedPOI($name, $location, $mainresource, $resource, $scale, $description, $thumbnail, $id, $orientation, $behaviourArray, $interactionFeedback);
	}
	
	/**
	 * 
	 * Creates 3D Location Based POI
	 * @param string $name Name of the POI to be displayed in the
	 * @param string $location POI's location as a string with latitude, longitude and altitude value separated by comma ("11.4564,34.23456,0")
	 * @param string $mainresource Absolute path to encrypted md2 file or zip file with obj models
	 * @param string $resource Absolute path to the texture file for a md2 object
	 * @param float $scale scale value of the 3D model
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $orientation POI's rotation as a string with x, y and z values separated by comma according to the rotation around the axis. Rotation in radians as Euler angles ("1.57,0,0")
	 * @param array $behaviourArray an array defining the behaviour. Example: if on "idle" the animation "start" shall be played looped, do: array("idle" => array("start", 0));
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
      
	public function create3DLocationBasedPOI($name = "", $location = "", $mainresource = "", $resource = "", $scale = "", $description = "", $thumbnail = "", $id = "", $orientation = "0,0,0", $behaviourArray = array(), $interactionFeedback = "none")
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		if(trim($name) == "" || trim($location) == "")
			trigger_error("Name and Location must be given");
			
		$poi->setName($name);
		$poi->setLocation($location);
		$poi->setForce3D("true");
		$poi->setOrientation($orientation);
		
		if(trim($id) != "")
			$poi->setPoiid($id);
		else
			$poi->setPoiid($tools->removeCharacters($name . $location, array(Tools::ALPH_NUM_SAFE)));
			
		$poi->setInteractionType($interactionFeedback);
		
		if(trim($description) != "")
			$poi->setDescription($description);

		if(trim($thumbnail) != "")
			$poi->setThumbpath($thumbnail);
		
		if(trim($scale) != "")
			$poi->setScale($scale);	

		if(trim($mainresource) != "")
		{
			$poi->setMainResource($mainresource);
			$extension = substr($mainresource, -strpos(strrev($mainresource), "."));
			
			if(strpos(strtolower($extension), "md2") !== FALSE)
			{
				$poi->setMIMEType(MimeTypes::MD2);
				
				if(count($behaviourArray) > 0)
				{
					foreach($behaviourArray as $type => $behaviour)
					{
						$beh = new Behaviour();
						$beh->setType($type);
						$beh->setLength($behaviour[1]);
						$beh->setNodeID($behaviour[0]);
						
						$poi->addBehaviour($beh);
					}
				}
				
				if(trim($resource) != "")
					$poi->setResources(array($resource));
				else
					trigger_error("resource needed for md2 model.");
			}
			else
				$poi->setMIMEType(MimeTypes::OBJ);
		}
					
		return $poi;
	}
	
	/**
	 * 
	 * Creates a Location Based POI with no location reference but relative to the users position
	 * @param string $name Name of the POI to be displayed in the
	 * @param string $translation POI's translation from (0,0,0) as a string with x, y and z value separated by comma ("20,0,0")
	 * @param string $mainresource Absolute path to encrypted md2 file or zip file with obj models
	 * @param string $resource Absolute path to the texture file for a md2 object
	 * @param float $scale scale value of the 3D model
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $orientation POI's rotation as a string with x, y and z values separated by comma according to the rotation around the axis. Rotation in radians as Euler angles ("1.57,0,0")
	 * @param array $behaviourArray an array defining the behaviour. Example: if on "idle" the animation "start" shall be played looped, do: array("idle" => array("start", 0));
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	
	public function create360POI($name = "", $translation = "", $mainresource = "", $resource = "", $scale = "", $description = "", $thumbnail = "", $id = "", $orientation = "0,0,0", $behaviourArray = array(), $interactionFeedback = "none")
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		if(trim($name) == "" || trim($translation) == "")
			trigger_error("Name and Location must be given");
			
		$poi->setName($name);
		$poi->setTranslation($translation);
		$poi->setForce3D("true");
		$poi->setOrientation($orientation);
		
		if(trim($id) != "")
			$poi->setPoiid($id);
		else
			$poi->setPoiid($tools->removeCharacters($name . $location, array(Tools::ALPH_NUM_SAFE)));
			
		$poi->setInteractionType($interactionFeedback);
		
		if(trim($description) != "")
			$poi->setDescription($description);

		if(trim($thumbnail) != "")
			$poi->setThumbpath($thumbnail);
		
		if(trim($scale) != "")
			$poi->setScale($scale);	

		if(trim($mainresource) != "")
		{
			$poi->setMainResource($mainresource);
			$extension = substr($mainresource, -strpos(strrev($mainresource), "."));
			
			if(strpos(strtolower($extension), "md2") !== FALSE)
			{
				$poi->setMIMEType(MimeTypes::MD2);
				
				if(count($behaviourArray) > 0)
				{
					foreach($behaviourArray as $type => $behaviour)
					{
						$beh = new Behaviour();
						$beh->setType($type);
						$beh->setLength($behaviour[1]);
						$beh->setNodeID($behaviour[0]);
						
						$poi->addBehaviour($beh);
					}
				}
				
				if(trim($resource) != "")
					$poi->setResources(array($resource));
				else
					trigger_error("resource needed for md2 model.");
			}
			else
				$poi->setMIMEType(MimeTypes::OBJ);
		}
					
		return $poi;
	}
	
	/**
	 * 
	 * Creates a screen fixed (GUI) POI
	 * @param string $name Name of the POI to be displayed in the 
	 * @param string $relativeToScreen Set a POI fixed to the screen, where "0,0" is lower left corner, "1,1" upper right corner and "0.5,0.5" the center
	 * @param string $mainresource Absolute path to encrypted md2 file or zip file with obj models
	 * @param string $resource Absolute path to the texture file for a md2 object
	 * @param float $scale scale value of the 3D model
	 * @param string $description Description to be displayed in the POIs pop up
	 * @param string $thumbnail Thumbnail to be used in the list and live view 
	 * @param string $id unique id for the POI
	 * @param string $orientation POI's rotation as a string with x, y and z values separated by comma according to the rotation around the axis. Rotation in radians as Euler angles ("1.57,0,0")
	 * @param array $behaviourArray an array defining the behaviour. Example: if on "idle" the animation "start" shall be played looped, do: array("idle" => array("start", 0));
	 * @param string $interactionFeedback "none" as default. Use "click" without description to avoid popup to be shown
	 */
	 
	public function createGUIPOI($name = "", $relativeToScreen = "", $mainresource = "", $resource = "", $scale = "", $description = "", $thumbnail = "", $id = "", $orientation = "0,0,0", $behaviourArray = array(), $interactionFeedback = "none")
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		if(trim($name) == "" || trim($relativeToScreen) == "")
			trigger_error("Name and relative to Screen must be given");
			
		$poi->setName($name);
		$poi->setRelativeToScreen($relativeToScreen);
		$poi->setForce3D("true");
		$poi->setOrientation($orientation);
		
		if(trim($id) != "")
			$poi->setPoiid($id);
		else
			$poi->setPoiid($tools->removeCharacters($name . $relativeToScreen, array(Tools::ALPH_NUM_SAFE)));
			
		$poi->setInteractionType($interactionFeedback);
		
		if(trim($description) != "")
			$poi->setDescription($description);

		if(trim($thumbnail) != "")
			$poi->setThumbpath($thumbnail);
		
		if(trim($scale) != "")
			$poi->setScale($scale);	

		if(trim($mainresource) != "")
		{
			$poi->setMainResource($mainresource);
			$extension = substr($mainresource, -strpos(strrev($mainresource), "."));
			
			if(strpos(strtolower($extension), "md2") !== FALSE)
			{
				$poi->setMIMEType(MimeTypes::MD2);
				
				if(count($behaviourArray) > 0)
				{
					foreach($behaviourArray as $type => $behaviour)
					{
						$beh = new Behaviour();
						$beh->setType($type);
						$beh->setLength($behaviour[1]);
						$beh->setNodeID($behaviour[0]);
						
						$poi->addBehaviour($beh);
					}
				}
				
				if(trim($resource) != "")
					$poi->setResources(array($resource));
				else
					trigger_error("resource needed for md2 model.");
			}
			else
				$poi->setMIMEType(MimeTypes::OBJ);
		}
					
		return $poi;
	}
	
	/**
	 * 
	 * Creates a GlUE POI with 3D model
	 * @param unknown_type $id
	 * @param unknown_type $translation
	 * @param unknown_type $mainresource
	 * @param unknown_type $scale
	 * @param unknown_type $orientation
	 * @param unknown_type $behaviourArray
	 */
	
	public function createGlueOcclusionPOI($id = "", $translation = "", $mainresource = "", $scale = "", $orientation = "0,0,0", $behaviourArray = array())
	{
		$tools = new Tools();
		$poi = new SinglePOI();
		
		if(trim($id) == "" || trim($translation) == "")
			trigger_error("ID and Translation must be given");
			
		$poi->setName("occlusion");
		$poi->setTranslation($translation);
		$poi->setForce3D("true");
		$poi->setOrientation($orientation);
		$poi->setPoiid($id);
		$poi->setScale($scale);		
			
		$poi->setInteractionType("click");
		
		if(trim($mainresource) != "")
		{
			$poi->setMainResource($mainresource);
			$extension = substr($mainresource, -strpos(strrev($mainresource), "."));
			
			if(strpos(strtolower($extension), "md2") !== FALSE)
			{
				$poi->setMIMEType(MimeTypes::MD2);
				
				if(count($behaviourArray) > 0)
				{
					foreach($behaviourArray as $type => $behaviour)
					{
						$beh = new Behaviour();
						$beh->setType($type);
						$beh->setLength($behaviour[1]);
						$beh->setNodeID($behaviour[0]);
						
						$poi->addBehaviour($beh);
					}
				}				
			}
			else
				$poi->setMIMEType(MimeTypes::OBJ);
		}
		
		$customization = new Customization();
		$customization->setName("occlusionName");
		$customization->setType("occlusion");
		$customization->setNodeID("occlusion");
		$customization->setValue("true");
		
		$poi->addCustomization($customization);
					
		return $poi;
	}
	
	/**
	 * 
	 * Start output to junaio
	 * @param string $trackingXML Path to the tracking xml -> only needed for GLUE
	 */
	public function start($trackingXML = null)
	{
		$this->createOutput(true, false, null, $trackingXML);
	}
	
	/**
	 * 
	 * end output to junaio
	 */
	public function end()
	{
		$this->createOutput(false, true, null);
	}
	
	/**
	 * 
	 * remove a single POI
	 * @param unknown_type $poi
	 */
	public function removePOI($poi)
	{
		$this->createOutput(false, false, $poi, null, true);
	}

	/**
	 * 
	 * Output a POI to junaio
	 * @param Single_POI $poi
	 */
	public function outputPOI($poi)
	{
		$this->createOutput(false, false, $poi);
	}
	
	/**
	 * 
	 * Remove POI by ID
	 * @param string $poiID ID of the POI to be removed
	 */
	public function removePOIByID($poiID)
	{
		$poi = new SinglePOI();
		$poi->setPoiid($poiID);
		
		$this->createOutput(false, false, $poi, null, true);
	}
	
	/**
	 * 
	 * Overal class for junaio output
	 * @see start, end, outputPOI, removePOI, removePOIByID
	 */
	public function createOutput($start, $end, $oPoi = null, $trackingXML = null, $removed = false)
	{
		if($start)
		{
			ob_start();
			ob_clean();
			if(isset($trackingXML) && $trackingXML != "")
		 		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><results trackingurl=\"$trackingXML\">";
			else
				echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><results>";
		}
		
		if(isset($oPoi))
		{
			$generatePOIInfo = true;
			$echoPOI = true;
			
			if($removed)
			{
				$poi = new SimpleXMLExtended("<poi></poi>");
				$poi->addAttribute('id', (string)$oPoi->getPoiid());
				$poi->addAttribute('removed', "true");
				$generatePOIInfo = false;
			}
			else if(isset($this->aUserPosition) && isset($this->iDistance) && !empty($this->aUserPosition) && !empty($this->iDistance))
			{
				$tools = new Tools();
				$poiLocationString = $oPoi->getLocation();
							
				//if the poi has a location to consider, check whether it is not too far away to be returned
				if(isset($poiLocationString) && !empty($poiLocationString) && $poiLocationString != "0,0,0")
				{
					$poiLocation = explode(",", $poiLocationString);
					
					//get the distance between the users position and the poi
					$distance = $tools->distanceBetweenLLAsInMeters($poiLocation[0], $poiLocation[1], $this->aUserPosition[0], $this->aUserPosition[1]);
					
					//if it is more than the preset or passed value, do not create the POI
					if($distance > $this->iDistance)
						$echoPOI = false;						
				}
			}			
							
			if($generatePOIInfo && $echoPOI)
			{
				//if spread is activated, check if the poi location has been called before and spread it if necessary
				if($this->bActivateSpreading)
				{
					if(in_array((string)$oPoi->getLocation(), $this->aLocations))
					{
						$position = explode(",", $oPoi->getLocation());
						$newLat = $position[0] + rand(-10,10) / 100;
						$newLong = $position[1] + rand(-10,10) / 100;
						
						$oPoi->setLocation(implode(",", array($newLat, $newLong, 0)));
					}
					else
						$this->aLocations[] = (string)$oPoi->getLocation();
				}
								
				$poi = new SimpleXMLExtended("<poi></poi>");
				$poi->addAttribute('id', (string)$oPoi->getPoiid());
				$poi->addAttribute('interactionfeedback', (string)$oPoi->getInteractionType());
				if($oPoi->getCosid() != "")
					$poi->addAttribute('cosid', (string)$oPoi->getCosid());
				if($oPoi->getName() != "")
					$poi->addCData('name', $oPoi->getName());
				if($oPoi->getDescription() != "")
					$poi->addCData('description', $oPoi->getDescription());	
				if($oPoi->getAuthor() != "")
					$poi->addChild('author', $oPoi->getAuthor());	
				if($oPoi->getCreation() != "")
					$poi->addChild('date', $oPoi->getCreation());	
				if($oPoi->getLocation() != "")
					$poi->addChild('l', $oPoi->getLocation());
				if($oPoi->getTranslation() != "")
					$poi->addChild('translation', $oPoi->getTranslation());	
				if($oPoi->getRelativeToScreen() != "")
					$poi->addChild('relativetoscreen', $oPoi->getRelativeToScreen());			
				if($oPoi->getOrientation() != "")
					$poi->addChild('o', $oPoi->getOrientation());	
				if($oPoi->getMinAccuracy() != "")
					$poi->addChild('minaccuracy', $oPoi->getMinAccuracy());	
				if($oPoi->getMaxDistance() != "")
					$poi->addChild('maxdistance', $oPoi->getMaxDistance());	
				if($oPoi->getMIMEType() != "")
					$poi->addChild('mime-type', $oPoi->getMIMEType());	
				if($oPoi->getMainResource() != "")
					$poi->addCData('mainresource', $oPoi->getMainResource());	
				if($oPoi->getThumbpath() != "")
					$poi->addChild('thumbnail', $oPoi->getThumbpath());	
				if($oPoi->getIcon() != "")
					$poi->addChild('icon', $oPoi->getIcon());	
				if($oPoi->getPhone() != "")
					$poi->addChild('phone', $oPoi->getPhone());	
				if($oPoi->getMail() != "")
					$poi->addChild('mail', $oPoi->getMail());	
				if($oPoi->getHomepage() != "")
					$poi->addCData('homepage', $oPoi->getHomepage());	
				if($oPoi->getShowNavigateToButton() != "")
					$poi->addChild('route', $oPoi->getShowNavigateToButton());
				if($oPoi->getShowCorrectperspective() != "")
					$poi->addChild('showcorrectperspective', $oPoi->getShowCorrectperspective());
					
				//check whether it is not a image or audio file -> otherwise extend more info
			    if(strpos($oPoi->getMIMEType(), "model") !== FALSE)
			    {
			    	if($oPoi->getForce3D() != "")
						$poi->addChild('force3d', $oPoi->getForce3D());
				   	if($oPoi->getScale() != "")
			    		$poi->addChild('s', $oPoi->getScale());	
			    	
			    	if($oPoi->getDisplayType() != "")
			    		$poi->addChild('display_type', $oPoi->getDisplayType());
			
			    	//Behaviours
			    	if(count($oPoi->getBehaviours()) > 0)
			    	{
				    	$behaviours = $poi->addChild("behaviours");
				    	foreach($oPoi->getBehaviours() as $oBehaviour)
				    	{
				    		$behaviour = $behaviours->addChild("behaviour");
				    		$behaviour->addAttribute('type', $oBehaviour->getType());
				    		$behaviour->addChild('length', $oBehaviour->getLength());
				    		$behaviour->addChild('node_id', $oBehaviour->getNodeID());
				    	}
			    	}   		
	
			    	if(count($oPoi->getResources()) > 0)
			    	{
				   		//Resources
				    	$resources = $poi->addChild("resources");
				    	foreach($oPoi->getResources() as $sResource)
				    		$resources->addCData("resource", $sResource);
			    	}
			    }
			    
				//Customizations
		    	if(count($oPoi->getCustomizations()) > 0)
		    	{
			    	$customizations = $poi->addChild("customizations");
			    	foreach($oPoi->getCustomizations() as $oCustomization)
			    	{
			    		$customization = $customizations->addChild("customization");
			    		$customization->addCData('name', $oCustomization->getName());
			    		$customization->addChild('type', $oCustomization->getType());
			    		$customization->addChild('node_id', $oCustomization->getNodeID());
			    		$customization->addCData('value', $oCustomization->getValue());
			    	}
		    	}
			}
			
			if($echoPOI)
			{
			    //remove the automatically created xml declaration of the simpleXMLElement
		    	$out = $poi->asXML();
		    	$pos = strpos($out, "?>");
			    echo trim(substr($out, $pos + 2));
			    ob_flush();
			}
		}	
		
		if($end)
		{	
			echo "</results>";
			ob_end_flush();			
		}
	}
}
?>
