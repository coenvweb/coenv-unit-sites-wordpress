jQuery(function ($) {
	'use strict';

	if (!$('body').hasClass('lt-ie8')) {
		
		// share buttons
		$('.share').coenvshare();
		
		// lightbox -00
		$('a:not([href*=youtube]):not([href*=vimeo])').nivoLightbox();

		// lightbox captions
        $('figure a img').each(function () {
            var $this = $(this);
            $this.parent().attr('title', $this.attr('alt'));
		});
		$('div.gallery img').each(function () {
            var $this = $(this);
            $this.parent().attr('title', $this.attr('alt'));
		});

		//$(".wp-caption-text.gallery-caption").hide();
		//$("div.gallery dl:gt(0)").hide();

        // split galleries using parent id 
		$('div.gallery a').each(function () {
            var $this = $(this);
            $this.attr('data-lightbox-gallery', $this.closest('div').attr('id'));
		});
        
    }

	var run = false;

	if($('.home')) {
		$(window).on("scroll", function() {
			var scrollPosition = scrollY || pageYOffset;

			if (scrollPosition > $(".full-stats").position().top - $(window).height() && run == false) {
				run = true;
				$('.stat-value').each(function () {
					$(this).prop('Counter',0).animate({
						Counter: $(this).text()
					}, {
						duration: 2000,
						easing: 'swing',
						step: function (now) {
							$(this).text(Math.ceil(now).toLocaleString());
						}
					});
				});
			}
		});
	}
	

    // Category filter for custom post type indicies
    $("select.select-category").on( 'change', function () {
        //alert('This changed!');
        //var url = $(this).parent('div').attr('data-url');
        var cat = $(this).parent('div').attr('data-url');
        var catval = $(this).val();
        window.location.href = cat + catval;
    } );
});





$.fn.blogHeader = function () {
    'use strict';

    var $header = $(this),
            $selectCategory = $header.find('.select-category select'),
            $selectMonth = $header.find('.select-month select');

    $selectCategory.on( 'change', function () {
        var term_id = $(this).val(),
                url = $(this).parent('div').attr('data-url');
        window.location.href = url + term_id;
    } );

    $selectMonth.on( 'change', function () {
        var url = $(this).val();
        window.location.href = url;
    } );
};

// Get season for homepage hero image

var heroSeason = function() {
    var d = new Date();
    var month = d.getMonth()+1;
    var heroClass = '';

    if (month >= 9) {
        heroClass = 'season-fall';

    } else if (month >= 12) {
        heroClass = 'season-winter';

    } else if (month >= 4) {
        heroClass = 'season-spring';

    } else {
        heroClass = 'season-spring';
    }

    return heroClass;

};

jQuery(function ($) {
    'use strict';

    // handle blog header form
    $('#blog-header').blogHeader();

    // Choose seasonal hero image
    $("div.full-feature").addClass(heroSeason());

});










