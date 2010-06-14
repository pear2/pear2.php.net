$(document).ready(function() {
	// select input content when focused
	$('input[type=text],input[type=password],input[type=search]')
		.focus(function(e) {
			this.select();
		});
});
