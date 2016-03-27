<?php

// start the javascript array
$js_list = "[ ";
// start the gallery html
$gallery = '<table id="galleryTable">'.
				'<tr>'.
					'<td class="galleryContainer">'.
						'<div class="galleryContainer">';

// loop thru the images and make 'em div's 'n' stuff!
for ($frame = 0; $frame<$numPix; $frame++) {
	// set iteration var's
	$id = $php_list[$frame]['id'];
	$imgId = sprintf("%03d", $id);
	$filename = $imgId.$ext;
    $imgUrl = $bm_home.$filename;
    $radioId = "radio$imgId";
	// update js array
	$js_list .= ( $frame == 0 ? "" : ", ").'"'.$filename.'"';
	// update gallery
    $gallery .= '<div id="imgCont'.$imgId.'" class="imgCont'.( $frame < $pixPerPage ? '' : ' hidden' ).'">'.
					'<div class="imgDiv" id="imgDiv'.$imgId.'">'.
						'<img src="'.$imgUrl.'" id="img'.$imgId.'" alt="'.$imgId.$ext.'"/>'.
					'</div>'.
					'<div class="cap">'.
						'<input type="radio" id="'.$radioId.'" name="imgSelector" value="'.$id.'"/>'.
						'<label class="capLabel" for="'.$radioId.'"><span></span>'.$imgId.'</label>'.
					'</div>'.
				'</div>';
}	// end of loop

// close javascript array
$js_list .= " ];";

// close gallery html
$gallery .= 	'</div>'.
			'</td>'.
		'</tr>'.
	'</table>';

// build the navbar
$lastPg = floor( $numPix/$pixPerPage ) + ( $numPix%$pixPerPage > 0 ? 1 : 0 );
// define the page navigator to the end of previous page div
$gallery_nav = '<p id="navPara">'.
					'<div id="pageNumListDiv">'.
						'<span onclick="turnPage(\'<\')" id="prevPgDiv" class="oneTurn">prev</span>';
// loop thru the page numbers
for($page=1; $page<=$lastPg; $page++) {
	$gallery_nav .= '<span id="pg'.sprintf("%03d", $page).
					'click" class="pgNum'.( $page == 1 ? ' currentPg' : '' ).'" '.
					'onclick="turnPage('.$page.');"'.
					'name="pgNum">'.$page.'</span>';
}
// finish off the navbar
$gallery_nav .= 		'<span onclick="turnPage(\'>\')" id="nextPgDiv" class="oneTurn">next</span>'.
					'</div>'.
				'</p>';

// we're done here!

?>