jQuery(function ($) {
	'use strict';

	if (!$('body').hasClass('lt-ie8')) {
		
		// share buttons
		$('.share').coenvshare();
		
		// lightbox
		$('a').nivoLightbox();

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

        $('.datatable table').addClass('row-border stripe').css('width', '100%');
        $('.datatable.no-search table').DataTable({
            paging: false,
            "sDom": '<"top">rt<"bottom"l><"clear">',
            scrollX: true,
            scrollCollapse: true,
            order: [],
        });
        
        $('.datatable.search table').DataTable({
            paging: false,
            "sDom": '<"top"if>rt<"bottom"lp><"clear">',
            scrollX: true,
            scrollCollapse: true,
            order: [],
        }); 
        
        if ($('body').hasClass('home')) {

            // slick slider
            $('.homepage-features').slick({
                autoplay: true,
                autoplaySpeed: 3000,
                dots: true,
                pauseOnDotsHover: true
            });
            
            var numItems = $('.feature').length;
            if (numItems > 2) {
                var autoplay = $('.homepage-features').slickGetOption('autoplay');
                if (autoplay == null || autoplay === false) {
                    $('.playpause').html('<i class="fi-play"></i>');
                } else {
                    $('.playpause').html('<i class="fi-pause"></i>');
                }

                $('.playpause').click(function () {
                    if (autoplay == null || autoplay === false) {
                        $(this).html('<i class="fi-pause"></i>');
                        $('.homepage-features').slickPlay();
                        autoplay = true;
                    } else {
                        $(this).html('<i class="fi-play"></i>');
                        $('.homepage-features').slickPause();
                        autoplay = false;
                    }
                });
            }
        }
    }

    // Category filter for custom post type indicies
    $("select.select-category").on( 'change', function () {
        //alert('This changed!');
        //var url = $(this).parent('div').attr('data-url');
        var cat = $(this).parent('div').attr('data-url');
        var catval = $(this).val();
        window.location.href = cat + catval;
    } );


	var $grid = $('.faculty-list-teach').isotope({
      itemSelector: '.faculty-list-item',
      layoutMode: 'fitRows'
    });

    $grid.imagesLoaded().progress(function() {
        $grid.isotope({
            itemSelector: '.faculty-list-item',
            layoutMode: 'fitRows',
            fitRows: {
                gutter: 1
            }

        });
    });

    $('.fac_cat').on('click', function(e) {
        e.preventDefault();
        pushHash($(this).data('cat'));
    });

    $('.fac_filter').on('change', function(e) {
        e.preventDefault();
        pushHash($(this).val());
    });

    $(window).on('hashchange', function() {
        readHash();
    });

    function toggleFacControl(newValue) {
        $('ul.cats li.fac_cat').each(function() {
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
            }
            if($(this).data('cat') == newValue) {
                $(this).addClass('active');
            }
        });
        $('.fac_filter').val(newValue);
    }

    function pushHash(hashValue) {
        window.location.hash = hashValue;
    }

    function readHash() {
        if(window.location.hash) {
            var hash = window.location.hash.substr(1);
            var filterValue = '.' + hash;
            toggleFacControl(hash);
            $grid.isotope({filter: filterValue});
        }
    }

	readHash();
});



jQuery(function ($) {
    'use strict';

    // handle blog header form
    $('#blog-header').blogHeader();

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








