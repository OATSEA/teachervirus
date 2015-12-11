function setup() {
	
	$(window).load(function(){
	    $('.mybutton').imagefit();		
	});
		
	document.ontouchmove = function(event) {
	// prevent screen scroll / bounce for iOS devices
	// event.preventDefault();	
	} 

} // END setup
