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

        var autoplay = true;
        var ppbutton = $('.play-pause-hero');
        var hero = $('#hero-video');
        ppbutton.html('<i class="fi-pause"></i>');
        hero.removeClass("fullfade");
        if (window.matchMedia('(prefers-reduced-motion)').matches) {
            hero.removeAttribute("autoplay");
            hero.get(0).pause()
            hero.addClass("fade");
            ppbutton.html('<i class="fi-play"></i>');
            autoplay = false;
        }
        ppbutton.click(function () {
            hero.toggleClass("fade");
            hero.get(0).pause()
            if (autoplay == null || autoplay === false) {
                $(this).html('<i class="fi-pause"></i>');
                hero.get(0).play()
                
                autoplay = true;
                ppbutton.html('<i class="fi-pause"></i>');
                setTimeout(function(){
                    hero.get(0).pause()
                    hero.addClass("fade");
                    ppbutton.html('<i class="fi-play"></i>');
                    autoplay = false;
                }, 75000);
            } else {
                $(this).html('<i class="fi-play"></i>');
                hero.get(0).pause()
                autoplay = false;
            }
        });
        setTimeout(function(){
                hero.get(0).pause()
                hero.addClass("fade");
                ppbutton.html('<i class="fi-play"></i>');
                autoplay = false;
        }, 750000);
    };
    
    // Category filter for custom post type indicies
    $("select.select-category").on( 'change', function () {
        //alert('This changed!');
        //var url = $(this).parent('div').attr('data-url');
        var cat = $(this).parent('div').attr('data-url');
        var catval = $(this).val();
        window.location.href = cat + catval;
    } );


	//filterer
var $grid = $('.filter-list').isotope({
  itemSelector: '.filter-list-item',
  layoutMode: 'fitRows'
});

$grid.imagesLoaded().progress( function() {
    $grid.isotope({
        itemSelector: '.filter-list-item',
        layoutMode: 'fitRows',
        masonry: {
            columnWidth: '.grid-sizer'
          }
    });
});

$('.filter_cat').on('click', function(e) {
    e.preventDefault();
    pushHash($(this).data('cat'));
});

$('.filter_filter').on('change', function(e) {
    e.preventDefault();
    pushHash($(this).val());
});

$(window).on('hashchange', function() {
    readHash();
});

function toggleFacControl(newValue) {
    $('ul.filter-cats li.filter_cat').each(function() {
        
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('ul.filter-cats').addClass('show-reset');
        }
        if($(this).data('cat') == newValue) {
            $(this).addClass('active');
            $('ul.filter-cats').addClass('show-reset');
        }
    });
    $('.filter_filter').val(newValue);
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

$('.datatable table').addClass('row-border').css('width', '100%');
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


//course filter
    if ($('body').hasClass('page-template-courses')) {
        var $grid = $('.filter-list').isotope({
          itemSelector: '.filter-list-item',
          layoutMode: 'fitRows'
        });
        
        // store filter for each group
        var filters = {};

        $('.course-filter').on( 'click', '.button', function() {
          var $this = $(this);
          // get group key
          var $buttonGroup = $this.parents('.button-group');
          var filterGroup = $buttonGroup.attr('data-filter-group');
          // set filter for group
          filters[ filterGroup ] = $this.attr('data-filter');
          // combine filters
          var filterValue = concatValues( filters );
          $grid.isotope({ filter: (filterValue) });
        });

        // change is-checked class on buttons
        $('.button-group').each( function( i, buttonGroup ) {
          var $buttonGroup = $( buttonGroup );
          $buttonGroup.on( 'click', '.button', function( event ) {
            $buttonGroup.find('.active').removeClass('active');
            var $button = $( event.currentTarget );
            $button.addClass('active');
          });
        });
        
        // flatten object by concatting values
        function concatValues( obj ) {
          var value = '';
          for ( var prop in obj ) {
            value += obj[ prop ];
          }
          return value;
        }
        
        $('ul.cats li.course_cat').on('click', function(e) {
            var $buttonGroup = $('.button-group');
            $buttonGroup.find('.active').removeClass('active');
            $buttonGroup.find('.all-quarters').addClass('active');
            $buttonGroup.find('.all-years').addClass('active');
            var topic = '.' + $(this).data('cat');
            $grid.isotope({filter: topic});
        });
        
        $('ul.cats').each( function( i, topicGroup ) {
            var $topicGroup = $( topicGroup );
            $topicGroup.on( 'click', '.course_cat', function( event ) {
                $topicGroup.find('.active').removeClass('active');
                var $button = $( event.currentTarget );
                $button.addClass('active');
            });
        });

    }



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








