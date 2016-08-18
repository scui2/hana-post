jQuery(document).ready(function($){

	$(document).foundation();	

    var backtotop = $('.back-to-top'); 
	// Back-to-top Script
	backtotop.hide();
	$('.back-to-top a').click(function (e) {
		e.preventDefault();
		$('body,html,header').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
	// Mouse Scroll Check
	var sectionMenu = $('.sectionmenu');
	var leftMenuToggle = $('.top-bar .leftmenu-toggle');
	$(window).scroll(function () {
		hanaScroll();
	});
    hanaScroll();
	function hanaScroll() {
		var scrollPos = $(window).scrollTop();
		if (scrollPos > 500) {
			backtotop.fadeIn();
		} else {
			backtotop.fadeOut();
		}     
	}
	// Search Focus
    $(window).on(
        'open.zf.reveal', function () {
			$('#modelSearch' ).find( '.search-query' ).each(function(){
       			$(this).focus();
       			var searchStr = $(this).val();
				$(this).val('');
				$(this).val(searchStr);
   			});
        }  
    );
    // Toggle Class
	$('.hana-toggle').click(function (e) {
		$(this).toggleClass('is-open');
	});   
	// Show Comments
    var hanaHash = window.location.hash;
	var postCommnet = $('#comments');
	var commentToggle = $('.comment-toggle');
	if ( postCommnet !== undefined ) {
		if ( '#respond' == hanaHash || hanaHash.match('#comment') ) {
			postCommnet.css("display", "block");
			commentToggle.addClass('is-open');
		} else {
			postCommnet.css("display", "none");	
			commentToggle.removeClass('is-open');	
		}		
	}
	$('.comment-link').click(function (e) {
		postCommnet.css("display", "block");
		commentToggle.addClass('is-open');
	});

    // Shrinking Topbar
	var stickyContainer = $('.sticky');
	stickyContainer.on('sticky.zf.stuckto:top', function(){
		var shrinkTopBar = stickyContainer.attr('data-shrink');
		if (shrinkTopBar !== undefined) {
	  		stickyContainer.find('.top-bar').addClass('shrunk');
			if($('.top-bar').is(':visible')) {
                 $('body').addClass('shrunk-header');
//				topbarHeight = $(".top-bar").outerHeight( false );
  //              $('body').css("padding-top",topbarHeight+"px");
			}
        }

	}).on('sticky.zf.unstuckfrom:top', function(){
		var shrinkTopBar = stickyContainer.attr('data-shrink');
		if (shrinkTopBar !== undefined) {
	  		stickyContainer.find('.top-bar').removeClass('shrunk');
            $('body').removeClass('shrunk-header');
            //$('body').css("padding-top","0");
		}
	});
		
    //Resize
	$(window).on("orientationchange resize", function () {
		if ( $("#offCanvasLeft").length !== 0 ) {
			$("#offCanvasLeft").foundation("close");
		}
	});
//Portfolio Ajax Loading
	if  ( $('.portfolio').length !== 0 ) {
		var page = 2;
		var loading = false;

		$('body').on('click', '.portfolio .load-more', function(){
			if( ! loading ) {
				$('.portfolio .load-more').remove();
				loading = true;
				var data = {
					action: 'hana_portfolio_load_more',
					nonce: hanaloadmore.nonce,
					page: page,
					column: hanaloadmore.column,
					entry_meta: hanaloadmore.entry_meta,
					thumbnail: hanaloadmore.thumbnail,
					query: hanaloadmore.query,
				};
				$.post(hanaloadmore.url, data, function(res) {
					if( res.success) {
						$('.portfolio').append( res.data );
						if ( hanaloadmore.column > 1 ) {
							var newHanaEqualizer = new Foundation.Equalizer($(".portfolio"), {
 								equalizeOnStack: false,equalizeByRow: true, equalizeOn: 'medium'
							});					
						}
						page = page + 1;				
						loading = false;
					} else {
					 	//console.log(res);
					}
				}).fail(function(xhr, textStatus, e) {
					 //console.log(xhr.responseText);
				});
			}
		});	
	} //Portfolio

});
