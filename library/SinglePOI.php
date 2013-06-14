<?php /**/ ?><?php
/**
 * @copyright  Copyright 2010 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Frank Angermann
 **/
require_once 'Behaviour.php';
require_once 'Customization.php';

class SinglePOI
{
	/**
	 * id of the poi;
	 * @var string
	 */
	public $sPoiid = NULL;
	
	/**
	 * Resources;
	 * @var array of Resources
	 */
	public $sInteractionType = NULL;
	
	/**
	 * Resources;
	 * @var array of Resources
	 */
	public $sDisplayType = NULL;
	
	/**
	 * Name of the poi;
	 * @var string
	 */
	public $sName = NULL;
	
	/**
	 * POI decription;
	 * @var string
	 */
	public $sDescription = NULL;
	
	/**
	 * POI creator;
	 * @var string
	 */
	public $sAuthor = NULL;
	
	/**
	 * POI creation time;
	 * @var string
	 */
	public $sCreation = NULL;
	
	/**
	 * POI LLA;
	 * @var string
	 */
	public $sLocation = NULL;
		
	/**
	 * POI Orientation;
	 * @var string
	 */
	public $sOrientation = NULL;
	
	/**
	 * POI scaling;
	 * @var float
	 */
	public $fScale = NULL;
	
	/**
	 * min accuracy to see POI;
	 * @var int
	 */
	public $iMinAccuracy = NULL;
	
	/**
	 * max distance to see POI;
	 * @var int
	 */
	public $iMaxDistance = NULL;
	
	/**
	 * MIME type of the POI;
	 * @var string
	 */
	public $sMIMEType = NULL;
	
	/**
	 * URI to resource;
	 * @var string
	 */
	public $sMainResource = NULL;
	
	/**
	 * URI to thumbnail;
	 * @var string
	 */
	public $sThumbpath = NULL;
	
	/**
	 * URI to icon;
	 * @var string
	 */
	public $sIcon = NULL;
	
	/**
	 * Phone number belonging to POI;
	 * @var string
	 */
	public $sPhone = NULL;
	
	/**
	 * Mail address belonging to POI;
	 * @var string
	 */
	public $sMail = NULL;
	
	/**
	 * Homepage belonging to POI;
	 * @var string
	 */
	public $sHomepage = NULL;
	
	/**
	 * Customizations;
	 * @var sarray of customizations
	 */
	public $aCustomizations = NULL;
	
	/**
	 * Behaviors;
	 * @var array of Behaviors
	 */
	public $aBehaviours = NULL;
	
	/**
	 * Resources;
	 * @var array of Resources
	 */
	public $aResources = NULL;
	
	/**
	 * Force3D
	 * @var boolean
	 */
	public $sforce3D = NULL;
	
	/**
	 * Show "navigate to button" on the client
	 * @var string
	 */
	public $sShowNavigateToButton = NULL;
	
	/**
	 * Show correct perspective
	 * @var string
	 */
	public $bShowCorrectperspective = NULL;
	
	/**
	 * Show relative to screen
	 * @var string
	 */
	public $sRelativeToScreen = NULL;
	
	/**
	 * Show correct perspective
	 * @var string
	 */
	public $iCosID = NULL;
	
	public $sTranslation = NULL;
	
	public function getPoiid() { return $this->sPoiid; } 
	public function getInteractionType() { return $this->sInteractionType; } 
	public function getDisplayType() { return $this->sDisplayType; } 
	public function getName() { return $this->sName; } 
	public function getDescription() { return $this->sDescription; } 
	public function getAuthor() { return $this->sAuthor; } 
	public function getCreation() { return $this->sCreation; } 
	public function getLocation() { return $this->sLocation; } 
	public function getOrientation() { return $this->sOrientation; } 
	public function getScale() { return $this->fScale; } 
	public function getMinAccuracy() { return $this->iMinAccuracy; } 
	public function getMaxDistance() { return $this->iMaxDistance; } 
	public function getMIMEType() { return $this->sMIMEType; } 
	public function getMainResource() { return $this->sMainResource; } 
	public function getThumbpath() { return $this->sThumbpath; } 
	public function getIcon() { return $this->sIcon; } 
	public function getPhone() { return $this->sPhone; } 
	public function getMail() { return $this->sMail; } 
	public function getHomepage() { return $this->sHomepage; } 
	public function getShowNavigateToButton() { return $this->sShowNavigateToButton; }
	public function getShowCorrectperspective() { return $this->bShowCorrectperspective; }
	public function getForce3D() { return $this->sforce3D; } 
	public function getCosid() { return $this->iCosID; } 
	public function getRelativeToScreen() { return $this->sRelativeToScreen; } 
	public function getTranslation() { return $this->sTranslation; } 
	
	public function getCustomizations() { 
		if(!isset($this->aCustomizations))
			$this->aCustomizations = array();
		
		return $this->aCustomizations; 
	} 
	public function getBehaviours() { 
		if(!isset($this->aBehaviours))
			$this->aBehaviours = array();
			
		return $this->aBehaviours;
	} 
	public function getResources() { 
		if(!isset($this->aResources))
			$this->aResources = array();
		
		return $this->aResources; 
	} 
	
	public function setPoiid($x) { $this->sPoiid = $x; } 
	public function setInteractionType($x) { 
		$x = strtolower($x);
		
		if($x != Interactions::CLICK && $x != Interactions::NONE && $x != Interactions::HIT)
			trigger_error("unknown interaction type");
			
		$this->sInteractionType = $x; 
	} 
	
	public function setDisplayType($x) { 
		$x = strtolower($x);
		
		if($x != DisplayType::NONE)
			trigger_error("unknown display type");
			
		$this->sDisplayType = $x; 
	} 
	
	public function setName($x) { $this->sName = $x; } 
	public function setDescription($x) { $this->sDescription = $x; } 
	public function setAuthor($x) { $this->sAuthor = $x; } 
	public function setCreation($x) { $this->sCreation = $x; } 
	public function setLocation($x) { $this->sLocation = $x; } 
	public function setOrientation($x) { $this->sOrientation = $x; } 
	public function setScale($x) { $this->fScale = $x; } 
	public function setMinAccuracy($x) { $this->iMinAccuracy = $x; } 
	public function setMaxDistance($x) { $this->iMaxDistance = $x; } 
	public function setMIMEType($x) { $this->sMIMEType = $x; } 
	public function setMainResource($x) { $this->sMainResource = $x; } 
	public function setThumbpath($x) { $this->sThumbpath = $x; } 
	public function setIcon($x) { $this->sIcon = $x; } 
	public function setPhone($x) { $this->sPhone = $x; } 
	public function setMail($x) { $this->sMail = $x; } 
	public function setHomepage($x) { $this->sHomepage = $x; } 
	public function setCustomizations($x) { $this->aCustomizations = $x; } 
	public function setBehaviours($x) { $this->aBehaviours = $x; } 
	public function setResources($x) { $this->aResources = $x; } 
	public function setShowNavigateToButton($x) { $this->sShowNavigateToButton = $x; }	
	public function setShowCorrectperspective($x) { $this->bShowCorrectperspective = $x; }
	public function setForce3D($x) { $this->sforce3D = $x; }
	public function setCosid($x) { $this->iCosID = $x; } 
	public function setRelativeToScreen($x) { $this->sRelativeToScreen = $x; } 
	public function setTranslation($x) { $this->sTranslation = $x; } 
	
	public function addResource($x) { 
		if(!isset($this->aResources))
			$this->aResources = array($x);
		else
			$this->aResources[] = $x; 
	} 
	
	public function addBehaviour($x) { 
		if(!isset($this->aBehaviours))
			$this->aBehaviours = array($x);
		else
			$this->aBehaviours[] = $x; 
	}
	
	public function addCustomization($x) { 
		if(!isset($this->aCustomizations))
			$this->aCustomizations = array($x);
		else
			$this->aCustomizations[] = $x; 
	}
}
