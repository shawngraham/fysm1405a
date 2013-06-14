<?php /**/ ?><?php
/**
 * @copyright  Copyright 2010 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Frank Angermann
 **/
class Interactions
{
	/**
	 * No interaction feedback expected by the publisher server
	 * @var const
	 */
	const NONE = "none";
	
	/**
	 * The publisher server expects a click return
	 * @var const
	 */
	const CLICK = "click";	
	
	/**
	 * The publisher server expects a hit return
	 * @var const
	 */
	const HIT = "hit";	
}