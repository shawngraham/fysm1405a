<?php /**/ ?><?php
/**
 * @copyright  Copyright 2010 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Frank Angermann
 **/
class Customization
{
	/**
	 * Name of the customization;
	 * @var string
	 */
	public $sName = NULL;
	
	/**
	 * customization type;
	 * @var string
	 */
	public $sType = NULL;
	
	/**
	 * nodeID# name  customization;
	 * @var string
	 */
	public $sNodeID = NULL;
	
	/**
	 * customization value
	 * @var string
	 */
	public $sValue = NULL;	
	
	public function getName() { return $this->sName; } 
	public function getType() { return $this->sType; } 
	public function getNodeID() { return $this->sNodeID; } 
	public function getValue() { return $this->sValue; } 
	public function setName($x) { $this->sName = $x; } 
	public function setType($x) { $this->sType = $x; } 
	public function setNodeID($x) { $this->sNodeID = $x; } 
	public function setValue($x) { $this->sValue = $x; }  
}