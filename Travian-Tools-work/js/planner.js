function scrollTop(){
	var fixmeTop = $('.target').offset().top;
	$(window).scroll(function() {
	  var currentScroll = $(window).scrollTop();
	  if (currentScroll >= fixmeTop) {
	    $('.target').css({
	      position: 'fixed',
	      top: '0',
	      left: '0'
	    });
	  } else {
	    $('.target').css({
	      position: 'static'
	    });
	  }
	});
}