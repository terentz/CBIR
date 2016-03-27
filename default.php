<?php
/* INCLUDES */
include 'config.php';
use config as conf;

// test line
//sleep(2);

/* PAGE GLOBALS */
// get parameters
$params = conf\Config::getParams();
// assign them ...
$host = $params['DB_HOST'];
$user = $params['DB_USER'];
$pwd = $params['DB_PWD'];
$db = $params['DB_NAME'];
$link = $params['BITMAP_LINK'];
$bm_home = $params['BITMAP_HOME_REL'];
$pixPerPage = $params['PIX_PER_PAGE'];
$ext = ".bmp";
$numPix; // await DB call
/* DB FETCH */

// create connection
$conn = mysqli_connect($host, $user, $pwd, $db);
if(mysqli_connect_errno()) {
    printf("connection failed: %s<br/>", mysqli_connect_error());
}
// build and execute query
$query_str = "select id from image";
$result_set = mysqli_query($conn, $query_str);
if (!$result_set) {
    print("query failed!<br>");
    // TODO handle this
}
// close connection
mysqli_close($conn);
$numPix = mysqli_num_rows($result_set);



/* BUILD THE GALLERY */

// make an array of images from the result set for gallery.php to use
$php_list = array();
$index = 0;
while($row = mysqli_fetch_array($result_set)) {
	$php_list[$index] = $row;
	$index++;
}

// build the gallery
include_once('gallery.php');

// spit it all out
echo '<div id="pixCont">'.$gallery.'</div>'.
	 '<div id="pgNavCont">'.$gallery_nav.'</div>';
	 
?>	 
