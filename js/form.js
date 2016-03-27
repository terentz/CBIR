/*
 *  EVENT HANDLERS 
 */


/**
 * When an image is selected using associated radio buttons,
 * this function applies the image number to the image text field.
 */

var updateSelectedImageTextbox = function() {
	var radio = $('input[type=radio]:checked');
	var id = radio.id;
	var val = radio.val();
	var tb = document.getElementById('targetImageText');
	tb.value = pad(val.toString(), 3);
};
/** Event attachment for updateSelectedImageTextbox() */
$('input[name=imgSelector]').on('click', updateSelectedImageTextbox);



/**
* Validates the target image textbox content.
* 
* TODO - make this function work in realtime,
* 		 ie, as the user types.
* 
* TODO - consider using a styled alert or tooltip
* 		 for the user message, esp. as tabbing 
* 		 out of the field takes one to the bottom
* 		 of the page (tho this is temporary). 
*/
$(function() {
   var validateTargetImageText = function() {
       return function( e ) {
           // get the value from the input tag
    	   var textBox = $('input#targetImageText');
           var content = textBox.val();
           // do a regex check
           var passed = validImgVal(content);
           // get the div and write to the user
           var div = document.getElementById('targetImageValidationOut');
/*           if ( passed ) {
               $('#targetImageValidationOut').addClass('hidden');
               div.innerHTML = '';
           } else {
               $('#targetImageValidationOut').removeClass('hidden');
               div.innerHTML = 'Must be an integer between 1 & ' + numPix + '!';
           }
*/
           if ( !passed ) {
        	   alert('Target image must be an integer between 1 & ' + numPix + '!');
        	   textBox.val('');
        	   textBox.focus();
        	   //document.getElementById('targetImageText').focus();
           }
           // set timeout and if field still has focus, recursive call
           //setTimeout('isFieldStillInFocus()', 1000);
           //setTimeout('validateValue()', 1000);
           // test line
           //test(targetImgTxtFocus);
           //if ( targetImgTxtFocus )
           //    validateValue;
       };
   };
   $('input#targetImageText').change(validateTargetImageText());
   $('input#targetImageText').on('blur', validateTargetImageText);
   //$('input#targetImageText').focus(validateValue());
   //$('body').load(validateValue());
});

/**
 * Slider toggle
 * TODO animate this feature as well.
 */
$(function() {
    var toggleSlider = function( checkId, sliderCellId, sliderId, valueId, hiddenId ) {
        return function( e ) {
            // is the checkbox checked?
            var selected = document.getElementById(checkId).checked;
            // if so, show the slider and the value ... 
            if ( selected ) { 
                $('#'+sliderCellId).removeClass('hidden');
                $('#'+valueId).removeClass('hidden');
                //$('#'+sliderId).removeClass('hidden'); 
                var value = Number(document.getElementById(sliderId).value).toFixed(2);
                //var strVal = numeral(numVal).format('0.00');
                document.getElementById(valueId).innerHTML = '<span></span>'+value;
                document.getElementById(hiddenId).value = value;
            // ... otherwise, hide them both
            } else { 
                $('#'+sliderCellId).addClass('hidden');
                $('#'+valueId).addClass('hidden');
                //$('#'+sliderId).addClass('hidden'); 
                document.getElementById(valueId).innerHTML = '<span></span>';
                document.getElementById(hiddenId).value = '';
            }
            checkFormSize();
        };
    };
    // event handlers
    $('#colHistCheck').click(toggleSlider('colHistCheck', 'colHistSliderCell', 'colHistSlider', 'colHistValue', 'colHistHidden')); 
    $('#colMomCheck').click(toggleSlider('colMomCheck', 'colMomSliderCell', 'colMomSlider', 'colMomValue', 'colMomHidden'));
    $('#textureCheck').click(toggleSlider('textureCheck', 'textureSliderCell', 'textureSlider', 'textureValue', 'textureHidden'));
});

/**
 * Update POST-able and visible value associated with slider
 */
$(function() {
    var sliderValue = function( sliderId, valueId, hiddenId ) {
        return function( e ) {
        	// get the value from the slider
            var value = Number(document.getElementById( sliderId ).value).toFixed(2);
            // update both the visible and hidden text versions
            document.getElementById(valueId).innerHTML = '<span></span>'+value;
            document.getElementById(hiddenId).innerHTML = value;
        };
    };
    // event handlers
    $('#colHistSlider').change(sliderValue('colHistSlider', 'colHistValue', 'colHistHidden'));
    $('#colMomSlider').change(sliderValue('colMomSlider', 'colMomValue', 'colMomHidden'));
    $('#textureSlider').change(sliderValue('textureSlider', 'textureValue', 'textureHidden'));
});

/*
 *  UTILITIES
 */

/**
 * Updates the width of the form if necessary.
 * TODO - animate this feature!
 */
function checkFormSize() {
    var checks = document.getElementsByClassName('featureCheck');
    var form = document.getElementById('formCont');
    for (var i=0; i<checks.length; i++) {
        // if there is a checked checkbox, maximise width
        if( checks[i].checked ) {
            $('#formCont').removeClass('min');
            $('#formCont').addClass('max');  
            return;
        }
    }
    // otherwise, minimise it
    $('#formCont').removeClass('max');
    $('#formCont').addClass('min');
    return;
}

function pad( val, digits ) {
    var str = '' + val;
    if( val < Math.pow(10, digits) ) {
        for(var zeros = 0; zeros < digits ; ++zeros){
            var yardStick = Math.pow(10,(digits-(zeros+1)));
            if( val < yardStick )
                str = '0' + str;
            else 
                break;
        }
        return str;
    }
    alert('invalid arguments for pad( val, digits )!');
}

function validImgVal( value ) {
    var num = Number(value);
    if( num <= numPix && num > 0 ) {
        var str = value + '';
        var regEx = /^([0-9]{0,3})$/;
        return regEx.test(str);
    }
    return false;
}
