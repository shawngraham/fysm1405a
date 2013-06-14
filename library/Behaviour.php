<?php /**/ ?><?php
/**
 * @copyright  Copyright 2010 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Frank Angermann
 **/
class Behaviour
{
	/**
	 * Name of the behaviour;
	 * @var string
	 */
	public $sType = NULL;
	
	/**
	 * length of the behaviour;
	 * @var float
	 */
	public $fLength = NULL;
	
	/**
	 * Name of the node_ID;
	 * @var string
	 */
	public $sNodeID = NULL;	
	
	public function getType() { return $this->sType; } 
	public function getLength() { return $this->fLength; } 
	public function getNodeID() { return $this->sNodeID; } 
	public function setType($x) { $this->sType = $x; } 
	public function setLength($x) { $this->fLength = $x; } 
	public function setNodeID($x) { $this->sNodeID = $x; } 
}