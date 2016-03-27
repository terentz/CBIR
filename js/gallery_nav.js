/* gallery_nav.js
 *
 * this is a redesign of the page turning functionality which, by loading
 * all images and only applying the 'hidden' css class to the images not
 * on the current page, instead of modifying the url's etc, will initially
 * load the gallery more slowly, but will from then eliminate server calls
 * from the process of page navigation.
 */
      // FUNCTIONS

function turnPage ( page ) {
    // only run if next/prev page exists
    if ( ( page == '>' && currPg < lastPg )
            || ( page == '<' && currPg > 1 ) 
            || ( typeof page == "number" && page > 0 && page <= lastPg ) ) {
        var oldPg = currPg;
        if ( page == '>' ) currPg++;
        else if ( page == '<' ) currPg--;
        else currPg = Number( page );
        // calculate the first and last visible elements of print list
        var prFirst = ( currPg - 1 ) * pixPerPg;
        var prLast = ( currPg * pixPerPg ) - 1;
        // get all the image divs as an array
        var imgDivs = document.getElementsByClassName("imgCont");
        // loop thru the image divs
        for ( var index = 0 ; index < numPix ; index++ ) {
            var div = imgDivs[index];
            var id = div.id;
            // identify divs to hide
            if ( index < prFirst || index > prLast ) {
            	$('#' + id).addClass('hidden');
                //div.className += ' hidden';
            // otherwise, show
            } else {
            	$('#' + id).removeClass('hidden');
                //div.className = div.className.replace( /(?:^|\s)hidden(?!\S)/g , '' );
            }
        }
        updatePgNo( currPg );
    }    
}

function updatePgNo( current ) {
	var pgNums = document.getElementsByName('pgNum');
	for ( var index = 0; index < lastPg; index++) {
		pgNums[index].className = (pgNums[index].innerHTML == current ? 'pgNum currentPg' : 'pgNum');
	}
}
      
// testing function
function writeToDiv ( id , input ) {
    var div = document.getElementById(id);
    div.innerHTML = input;
}

