$(function(){
	$(".nav a[href='"+document.location.pathname+"']").parent().addClass('active');
	$(".nav a[href='"+document.location.href+"']").parent().addClass('active');
	
	// Rating tooltip
	$("*[data-toggle='tooltip']").tooltip();
});
