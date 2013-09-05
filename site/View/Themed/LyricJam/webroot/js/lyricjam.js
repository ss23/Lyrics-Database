function switchFancyItem(el){
	$('.fancy-item.active').removeClass('active');
	$(el).addClass('active');
	// Cycle album list
}

$(function(){
	$(".nav a[href='"+document.location.pathname+"']").parent().addClass('active');
	$(".nav a[href='"+document.location.href+"']").parent().addClass('active');
	
	// Rating tooltip
	$("*[data-toggle='tooltip']").tooltip();
	
	// Carousel
	$('#hot-artists').carousel({
		interval: 5000
	}).on('slide.bs.carousel', function (e) {
		var next = $(e.relatedTarget).index();
		switchFancyItem($('.fancy-item').get(next));
	});
	
	$('.fancy-item').click(function() {
		switchFancyItem(this);
		$('#hot-artists').carousel($(this).index());
	});
	// Pause carousel cycling when hovering over fancy holder
	$('.fancy-holder').mouseenter(function(){
		$('#hot-artists').carousel('pause');
	}).mouseleave(function(){
		$('#hot-artists').carousel('cycle');
	});
});