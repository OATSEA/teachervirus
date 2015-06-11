function setup() {
	
	$(window).load(function(){
	    $('.myfig').imagefit();
		$('.mybutton').imagefit();	
	});
	
	
	/*
	document.ontouchmove = function(event) {
	// prevent screen scroll / bounce for iOS devices
	event.preventDefault();	
	} 
	*/
	
	// Setup watcher for exit full screen so that we can pause the video when exit full screen
	// $('.videoclip').css( "border", "3px solid red" );
	$('.videoclip').bind('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e) {
		var state = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
	    // var event = state ? 'FullscreenOn' : 'FullscreenOff';

	    if (state==false) {
			//alert('Event: ' + state);
	    	$('.videoclip').each( function() { 
					$(this).get(0).pause(); }
			);
			$('#overlay').addClass('hideMe');
			// $('.videoclip').get(0).pause();
	    }// Now do something interesting
	        
	});	
} // END setup
		
function playvid(value) {
	// alert(value);
	var video = document.getElementById(value);
	if(video.paused){
		video.play(); 
		video.webkitRequestFullScreen();
		$('#overlay').addClass('hideMe');
		
	} else {
		video.pause();
		$('#overlay').removeClass('hideMe');
		
		// video.webkitExitFullScreen();
	}
	
	// make this button highlighted to indicate played
	var button = value+"_icon";
	$('#'+button).addClass("played");

} // END playvid

function videoEnded(value) {
	// alert(value);
	var video = document.getElementById(value);
	video.webkitExitFullScreen();

} // END playvid

function doBack() {
	// alert(value);
	$('#overlay').addClass('hideMe');
	$('.videoclip').each( function() { 
			$(this).get(0).webkitExitFullScreen(); }
	);


} // END playvid

function toggleView() {
	/* alert("Toggle View"); */
	$('.mycaption').toggleClass('hideMe');
	$('.imgtitle').toggleClass('hideMe');
	/* $('.myfig').toggleClass('smallmyfig'); */
	
} // END toggleView

function catToggle(value) {
	// alert(value);
		
		/*$('.videoicon').hide();
		$('.imgtitle').hide();
		$('.videoclip').hide();*/
		
		if (value=="All") {
			$('.myfig').show(); 
		} else {
			$('.myfig').hide(); 
		$('.'+value).show();
		}

		$('.mybutton').removeClass("played");
		$('#'+value+'_nav').addClass("played");
		
		var display = value.replace("-", " ");
		
	$('#moviecat').text(display);
	$('#moviecat').css('textTransform', 'capitalize');
	
}