$(function(){
	$(".nav a[href='"+document.location.pathname+"']").parent().addClass('active');
	$(".nav a[href='"+document.location.href+"']").parent().addClass('active');
	
	// Rating tooltip
	$("*[data-toggle='tooltip']").tooltip();
});

$('document').ready(function() {
	$('.fancy-item').click(function() {
		// Unactivate the one that's active
		$('.fancy-item.active').removeClass('active');
		$(this).addClass('active');
		// Chrome sux
		$(this).find('.arrow').css('display', 'none');
		window.setTimeout(function() {
			console.log('redrawn');
			$('.fancy-item.active .arrow').css('display', '');	
		}, 0);
		// Like seriously, it sucks. You have to not only toggle the display
		// but you have to do it in a fucked up redraw like this. I swear
	});
});
