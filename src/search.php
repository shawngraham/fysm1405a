<?php /**/ ?><?php

/**
 * @copyright  Copyright 2010 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Frank Angermann
 **/

 require_once '../library/poibuilder.class.php';
 
/**
 * When the channel is being viewed, a poi request will be sent
 * $_GET['l']...(optional) Position of the user when requesting poi search information
 * $_GET['o']...(optional) Orientation of the user when requesting poi search information
 * $_GET['p']...(optional) perimeter of the data requested in meters.
 * $_GET['uid']... Unique user identifier
 * $_GET['m']... (optional) limit of to be returned values
 * $_GET['page']...page number of result. e.g. m = 10: page 1: 1-10; page 2: 11-20, e.g.
 **/
 
//use the poiBuilder class   --- this might not be right, for 
$jPoiBuilder = new JunaioBuilder();

//create the xml start
$jPoiBuilder->start("http://ar.graeworks.net/cmc-arbook/resources/tracking.xml_enc");

//bookcover-trackingimage1
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI(
		"Movie Texture",	//name
		"0,0,0", //position
		"http://dev.junaio.com/publisherDownload/tutorial/movieplane3_2.md2_enc", //model
		"http://ar.graeworks.net/cmc-arbook/resources/movie-reel.mp4", //texture
		95, //scale
		1, //cosID
		"Universal Newspaper Newsreel November 6, 1933, uploaded to youtube by publicdomain101", //description
		"", //thumbnail
		"movie1", //id
		"1.57,1.57,3.14", //orientation
		array(), //animation specification
		"click"
                
);

//deliver the POI
$jPoiBuilder->outputPOI($poi);

//trackingimage2 pg 9 xxi-a:55 - will this be a model or a movie?
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI(
		"Movie Texture",	//name
		"0,0,0", //position
		"http://dev.junaio.com/publisherDownload/tutorial/movieplane3_2.md2_enc", //model
		"http://ar.graeworks.net/cmc-arbook/resources/edited-museum-1.mp4", //texture
		90, //scale
		2, //cosID
		"Faces of Mexico - Museo Nacional de Antropologia", //description
		"", //thumbnail
		"movie2", //id
		"1.57,1.57,3.14", //orientation
		array(), //animation specification
		"click"
                
);
$cust = new Customization();
$cust->setName("Website");
$cust->setNodeID("click");
$cust->setType("url");
$cust->setValue("http://www.youtube.com/watch?v=Dfc257xI0eA");
 
$poi->addCustomization($cust);
//deliver the POI
$jPoiBuilder->outputPOI($poi);

//trackingimage3 pg 11 xxi-a:347 bighead -3d model
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI (
"Effigy", //name
    "0,0,0",  //translation
    "http://ar.graeworks.net/cmc-arbook/resources/id3-big-head.zip", //mainresource (model)
    "http://ar.graeworks.net/cmc-arbook/resources/big-head-statue_tex_0.jpg", //resource (texture)
    5, //scale
    3, //cos ID -> which reference the POI is assigned to
    "XXI-A:51", //description
    "", //thumbnail
    "Zapotec Effigy", //id
    "0,3.14,1.57" //orientation
);

//deliver the POI
$jPoiBuilder->outputPOI($poi);

//trackingimage4 pg13 xxi-a:51 guy from shaft tomb, model
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI (
"Shaft Tomb Figurine", //name
    "0,0,0",  //translation
    "http://ar.graeworks.net/cmc-arbook/resources/id4-shaft-grave.zip", //mainresource (model)
    "http://ar.graeworks.net/cmc-arbook/resources/april25-statue.jpg", //resource (texture)
    5, //scale
    4, //cos ID -> which reference the POI is assigned to
    "XXI-A:51", //description
    "", //thumbnail
    "Shaft Tomb Figurine", //id
    "0,0,3.14" //orientation
);
 //echo the POI
$jPoiBuilder->outputPOI($poi); 

//trackingimage5 pg15 xxi-a:28 movie?
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI(
		"Movie Texture",	//name
		"0,0,0", //position
		"http://dev.junaio.com/publisherDownload/tutorial/movieplane4_3.md2_enc", //model
		"http://ar.graeworks.net/cmc-arbook/resources/pg15-movie.mp4", //texture
		90, //scale
		5, //cosID
		"Showing the finished model in Meshlab", //description
		"", //thumbnail
		"movie3", //id
		"1.57,1.57,3.14", //orientation
		array(), //animation specification
		"click"
                
);

//deliver the POI
$jPoiBuilder->outputPOI($poi);

//trackingimage6 pg17 xxi-a:139 man with club movie?
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI(
		"Movie Texture",	//name
		"0,0,0", //position
		"http://dev.junaio.com/publisherDownload/tutorial/movieplane4_3.md2_enc", //model
		"http://ar.graeworks.net/cmc-arbook/resources/archaeologicalsites-1.mp4", //texture
		90, //scale
		6, //cosID
		"Universal Newspaper Newsreel November 6, 1933, uploaded to youtube by publicdomain101", //description
		"", //thumbnail
		"movie4", //id
		"1.57,1.57,3.14", //orientation
		array(), //animation specification
		"click"
                
);

//deliver the POI
$jPoiBuilder->outputPOI($poi);

//trackingimage7 pg19 xxi-a:27 fat dog model
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI (
"Fat Dog", //name
    "0,0,0",  //translation
    "http://ar.graeworks.net/cmc-arbook/resources/id5-dog-model.zip", //mainresource (model)
    "http://ar.graeworks.net/cmc-arbook/resources/april25-dog_tex_0-small.png", //resource (texture)
    5, //scale
    7, //cos ID -> which reference the POI is assigned to
    "XXI-A:27, Created using 123D Catch", //description
    "", //thumbnail
    "Fat Dog", //id
    "0,0,3.14" //orientation
);
 

//deliver the POI
$jPoiBuilder->outputPOI($poi); 

//trackingimage8 pg21 xxi-a:373 ring of people - model
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI (
"Ring of People", //name
    "0,0,0",  //translation
    "http://ar.graeworks.net/cmc-arbook/resources/ring.zip", //mainresource (model)
    "http://ar.graeworks.net/cmc-arbook/resources/ring-2_tex_0.jpg", //resource (texture)
    5, //scale
    8, //cos ID -> which reference the POI is assigned to
    "XXI-A:29, Old woman seated with head on knee. Created using 123D Catch", //description
    "", //thumbnail
    "Ring of People", //id
    "1.57,0,3.14" //orientation
);
 
//deliver the POI
$jPoiBuilder->outputPOI($poi); 

//trackingimage 9 pg 23 xxi-a:29 old woman with head on knee. movie? or model?
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI (
"Old Woman", //name
    "0,0,0",  //translation
    "http://ar.graeworks.net/cmc-arbook/resources/statue2.zip", //mainresource (model)
    "http://ar.graeworks.net/cmc-arbook/resources/Statue_try_1_tex_0.png", //resource (texture)
    5, //scale
    9, //cos ID -> which reference the POI is assigned to
    "XXI-A:29, Old woman seated with head on knee. Created using 123D Catch", //description
    "", //thumbnail
    "Old Woman", //id
    "0,3.14,3.14" //orientation
);
 
//deliver the POI
$jPoiBuilder->outputPOI($poi); 

//trackingimage 10 pg29 Anything but textbook movie
$poi = new SinglePOI();
$poi = $jPoiBuilder->createBasicGluePOI(
		"Movie Texture",	//name
		"0,0,0", //position
		"http://dev.junaio.com/publisherDownload/tutorial/movieplane3_2.md2_enc", //model
		"http://ar.graeworks.net/cmc-arbook/resources/carleton-promo.mp4", //texture
		100, //scale
		10, //cosID
		"Carleton University - Anything but textbook!", //description
		"", //thumbnail
		"movie5", //id
		"1.57,1.57,3.14", //orientation
		array(), //animation specification
		"click"
                
);
$cust = new Customization();
$cust->setName("Website");
$cust->setNodeID("click");
$cust->setType("url");
$cust->setValue("http://carleton.ca");
 
$poi->addCustomization($cust);


//deliver the POI
$jPoiBuilder->outputPOI($poi);


///end of tracking images
$jPoiBuilder->end();




exit;