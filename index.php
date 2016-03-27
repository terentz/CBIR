

<!DOCTYPE html>
<html>
  <head>
    <title>Show Samples</title>
    <meta charset="utf-8"/>
    <meta baseref="http://localhost/cbir1/"/>
    <link rel="stylesheet" type="text/css" href="./styles.css"/>
	
	<!-- VALUE TESTING SCRIPT -->
	<script>
function test( input ) {
	document.getElementById('test').innerHTML = input;
}
	</script>
  
  </head>
  <body>
  	<form>
      <!-- TODO: animate all hideable div's -->
      
      <!-- TODO: animate the form's opacity change -->
      
	  <!-- VALUE TESTING -->
  	  <div id="test"></div>
  	  <br/>
      
      <!-- HEADING STUFF -->	
      <!-- TODO: consign this to a hideable 'help' div -->    
      <h1>CBIR (Content-Based Image Retrieval)</h1>
      <br/>
      <div align="center">
      </div>
      
      <!-- MAIN FORM COMPONENTS -->
      <!-- TODO: make this part of the form hideable -->
	  <div id="formCont" class="min">
	  	
	  	<!-- IMAGE FEATURES -->
	  	<!-- TODO: adjust feature selection such that sliders are
	  		only visible when two or more features are selected -->
	  	<!-- TODO: style the sliders -->
	   	<table id="featuresTable">
	   	  <!-- Colour Histogram -->
	      <tr>
	        <td>
	          <input type="checkbox" id="colHistCheck" class="colHist featureCheck"/>
	          <label for="colHistCheck" class="featureLabel"><span></span>Colour Histograms</label>
	        </td>
	        <td id="colHistSliderCell" class="colHist slider hidden">
	          <input type="range" id="colHistSlider" class="slider colHist" min="0.0" max="1.0" step="0.01" value="0.5"/>
	        </td>
	        <td>
	          <label for="colHistSlider" id="colHistValue" class="featureLabel hidden"><span></span></label>
	          <input type="hidden" id="colHistHidden"/>
	        </td>
	      </tr>
	      <!-- Colour Moments -->
	      <tr>
	        <td>
	          <input type="checkbox" id="colMomCheck" class="colMom featureCheck"/>
	          <label for="colMomCheck" class="featureLabel"><span></span>Colour Moments</label>
	        </td>
	        <td id="colMomSliderCell" class="colMom slider hidden">
	          <input type="range" id="colMomSlider" class="slider colMom" min="0.0" max="1.0" step="0.01" value="0.5"/>
	        </td>
	        <td>
	          <label for="colMomSlider" id="colMomValue" class="featureLabel hidden"><span></span></label>
	          <input type="hidden" id="colMomHidden"/>
	        </td>
	      </tr>
	      <!-- Texture -->
	      <tr>
	        <td>
	          <input type="checkbox" id="textureCheck" class="texture featureCheck"/>
	          <label for="textureCheck" class="textureLabel"><span></span>Texture</label>
	        </td>
	        <td id="textureSliderCell" class="texture slider hidden">
	          <input type="range" id="textureSlider" class="slider texture" min="0.0" max="1.0" step="0.01" value="0.5"/>
	        </td>
	        <td>
	          <label for="textureSlider" id="textureValue" class="featureLabel hidden"><span></span></label>
	  	      <input type="hidden" id="textureHidden"/>
	        </td>
	      </tr>
	      
        </table>
	    <br/>
	    
	    <!-- TARGET IMAGE -->
	    <table id="targetImageTable">
	      <tr>
	        <td>
	          <input type="text" id="targetImageText" name="targetImageText" maxlength="3" size="3"/>
	          <label for="targetImageText" id="targetImageLabel">&lt;=&nbsp;Target&nbsp;image</label>
	        </td>
	      </tr>
	      <tr>
	        <td id="targetImageValidationOut">
	        </td>
	      </tr>
	    </table>
	    <br/>
	    
	    <!-- ACTION BUTTONS -->
	    <table id="actionSelectTable">
	      <tr>
	        <!-- Reset Gallery -->
	        <td>
	          <div id="resetButton" class="actionButton">
   	            Reset
   	          </div>
	        </td>
	        <!-- Apply Selected Features -->
	        <td>
	          <div id="applyButton" class="actionButton">
	            Apply
	          </div>
	        </td>
	      </tr>
	      
	      <!-- TEST BUTTON -->
	      <tr>
	        <td>
	          <div id="testButton">
	          	TEST BUTTON
	          </div>
	        </td>
	      </tr>
	    </table>
	  </div>
	  
	  <!-- IMAGE GALLERY AND NAVIGATION -->
	  <!-- TODO: style the page bar -->
	  <!-- TODO: make the gallery remain in the centre,
	  		especially when changing browser width -->
	  <div id="galleryCont">
	  	<?php include_once('default.php'); ?>
	  </div>
    </form>

    <!-- SCRIPTS FOR GLOBALS -->
    <script>
var prList = <?php echo $js_list; ?>;
// GLOBALS
var pixPerPg = <?php echo $pixPerPage; ?>;
var numPix = <?php echo $numPix; ?>;
var lastPg = ( Math.floor(numPix/pixPerPg) ) + ( numPix%pixPerPg > 0 ? 1 : 0 );
var bmPath = "../images/cbir/bmp/";
var currPg = 1;
    </script>

    <!-- IMPORT COMMON JS LIB'S FIRST -->
    <script src="../js/jquery-1.10.2.js" type="text/javascript"></script>
    <!-- FOLLOWED BY YOUR OWN STUFF... -->
    <script src="js/gallery_nav.js" type="text/javascript"></script>
    <script src="js/string_utils.js" type="text/javascript"></script>
    <script src="js/form.js" type="text/javascript"></script>
     
	<!-- SCRIPT FOR PAGE-TO-LOAD -->
	<script>
// load default gallery
var loadDefaultGallery = function() {
	$.ajax({
		"type":"POST",
		"url":"default.php",
		"data":"",
		"success":function(data) {
			$("#galleryCont").html(data);
		}
	});
};
$('#resetButton').on('click', loadDefaultGallery);

// load comparison gallery
var compare = function() {
	// 1. Check slider values and create name/value pairs
	// get the checkbox and slider elements
	var checks = $('input.featureCheck[type="checkbox"]');
	var sliders = $('input.slider[type="range"]');
	// iterate thru sliders and build nam/val pairs
	var features = ""; 
	for ( var i = 0 ; i < checks.length ; i++ ) {
		if ( checks[i].checked == true ) {
			features += "&" + sliders[i].id + "="  + sliders[i].value;
		}
	}
	// if no features selected, alert and break out
	if ( features == "" ) {
		alert('At least one image feature must be selected for a comparison!');
		document.getElementById('colHistCheck').focus();
		return;
	}
	//alert($('#targetImageText').val());
	
	// 2. Check control image selection and create nam/val pair..
	// if target image is not set, alert user and kill function
	if ( $('#targetImageText').val() == "undefined"
			|| $.trim($('#targetImageText').val()) == "" ) {
		// TODO: validate the value in target image text
		alert('Target image must be set for comparison');
		$('#targetImageText').focus();
		//document.getElementById('targetImageText').focus();
		return;
	}
	//alert($('#targetImageText').val());
	//var baseImg = "baseImg=" + pad($('input#targetImageText').val(), 3);
	var baseImg = "baseImg=" + $('input#targetImageText').val();
	
	// 3. Join the two
	var queryString = baseImg + features;
	test(queryString);
	
	// do the Ajax thing
	$.ajax({
		"type":"POST",
		"url":"process.php",
		"data": queryString,
		"success":function(data) {
			$("#galleryCont").html(data);
		}
	});
};
$('#applyButton').on('click', compare);
	</script>


    <!-- test script -->
    <script>
function test( input ) {
	document.getElementById('test').innerHTML = input;
}
var loadBlankGallery = function() {
	var gall = document.getElementById('galleryCont');
	gall.innerHTML = '';
};
$('#testButton').on('click', loadBlankGallery);
    </script>
  </body>
</html>



