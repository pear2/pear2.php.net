$(document).ready(function() {
	// select input content when focused
	$('input[type=text],input[type=password],input[type=search]')
		.focus(function(e) {
			this.select();
		});
	$('a.partial').click(function(){
		$.get(this.href+'?format=partial', function(data, textStatus){
			if (textStatus == 'success') {
				$('#maincontent').html(data);
				// @todo push the url onto the history stack
			}
		});
		return false;
	});
});
