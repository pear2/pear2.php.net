
function changeContents(url) {
	//first, set the height of maincontent to fix jumping
	$('#maincontent').css({'height' : $('#maincontent').height()});
    //$('#maincontent').html('<div class="wdn_loading"><img src="/wdn/templates_3.0/css/header/images/colorbox/loading.gif" /></div>');
    $.get(
        url+"?format=partial",
        function(data) {
            $('#maincontent').html(data);
            $('#maincontent').css({'height' : 'auto'});
            $('pre code').each(function(i, e) {hljs.highlightBlock(e, '    ')});
        }
    );
}

$(document).ready(function() {
	// select input content when focused
	$('input[type=text],input[type=password],input[type=search]')
		.focus(function(e) {
			this.select();
		});
	$('a.partial').live('click', function(event){
		var url = this.href;
	    var direction = {'right': "+=1000px"};
	    if (this.id == 'next') {
	    	direction = {'right': "+=1000px"};
	    } else {
	    	// figure out how to determine which way to go
	    }
	    
	    $("#maincontent").animate(direction, "fast", function(){
	        if (supports_history()) {
	            var title = url.split(window.url);
	            window.History.pushState(null, title, url);
	        } else {
	        	changeContents(url);
	        }
	    });
		return false;
	});
});

function supports_history() {
	return !!(window.history && history.pushState)
}

//Smart browser history for HTML 5 browsers.
(function(window,undefined){
	if (supports_history()) {
		var History = window.History;
		$(window).bind('statechange',function(){
			var State = History.getState();
			changeContents(State.url);
		});
	}
})(window);
