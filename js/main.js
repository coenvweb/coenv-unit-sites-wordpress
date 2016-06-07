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

jQuery(function ($) {
    var JQTWEET = {

        // Set twitter hash/user, number of tweets & id/class to append tweets
        user: 'UWPCC',
        numTweets: 5,
        appendTo: '#twitter',
        template: '<div class=""><div class="tweet-wrapper"><div class="tweet-head">{PROF_IMG}<span class="username">{NAME}</span><span class="at_name">@{USER}</span></div>\
                   <span class="content">{TEXT}</span><div class="media">{IMG}</div>\
                   <span class="twitter-logo"><i class="fi-social-twitter"></i></span><span class="time"><a href="{URL}" target="_blank">{AGO}</a></span>\
                   <span class="twitter-actions"><a href="{REPLY}"></a><a href="{RETWEET}"></a><a href="{FAVORITE}"></a></span></div></div>',

        loadTweets: function() {

            var request;

            request = {
              action: 'getUserTimeline',
              screen_name: JQTWEET.user,
              count: JQTWEET.numTweets,
              api: 'statuses/user_timeline'
            }

            $.ajax({
                url: adminAjax.ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: request,
                success: function(data, textStatus, xhr) {
                    if (data) {
                        console.log(data);

                        var text, name, img;

                          // append tweets into page
                          for (var i = 0; i < JQTWEET.numTweets; i++) {
                            img = '';
                            url = 'http://twitter.com/' + data[i].user.screen_name + '/status/' + data[i].id_str;
                            if(data[i].retweeted_status) {
                                user = data[i].retweeted_status.user.screen_name;
                                name = data[i].retweeted_status.user.name;
                                user_url = 'http://twitter.com/' + data[i].retweeted_status.user.screen_name;
                                prof_img = '<a href="' + user_url + '" target="_blank"><img src="' + data[i].retweeted_status.user.profile_image_url + '" /></a>';
                            } else {
                                user = data[i].user.screen_name;
                                name = data[i].user.name;
                                user_url = 'http://twitter.com/' + data[i].user.screen_name;
                                prof_img = '<a href="' + user_url + '" target="_blank"><img src="' + data[i].user.profile_image_url + '" /></a>';

                            }
                            reply = 'http://twitter.com/intent/tweet?lang=en&in_reply_to=' + data[i].id_str;
                            retweet = 'http://twitter.com/intent/retweet?lang=en&tweet_id=' + data[i].id_str;
                            favorite = 'http://twitter.com/intent/favorite?lang=en&tweet_id=' + data[i].id_str;
                            try {
                              if (data[i].entities['media']) {
                                img = '<a href="' + url + '" target="_blank"><img src="' + data[i].entities['media'][0].media_url + '" /></a>';
                              }
                            } catch (e) {
                              //no media
                            }

                            $(JQTWEET.appendTo).append( JQTWEET.template.replace('{TEXT}', JQTWEET.ify.clean(data[i].text) )
                                .replace('{USER}', user)
                                .replace('{NAME}', name)
                                .replace('{PROF_IMG}', prof_img)
                                .replace('{IMG}', img)
                                .replace('{AGO}', JQTWEET.timeAgo(data[i].created_at) )
                                .replace('{REPLY}', reply)
                                .replace('{RETWEET}', retweet)
                                .replace('{FAVORITE}', favorite)
                                .replace('{URL}', url )
                                );
                          }

                    } else {
                        console.log('no data returned');
                    }
                }
            });

        },


        /**
          * relative time calculator FROM TWITTER
          * @param {string} twitter date string returned from Twitter API
          * @return {string} relative time like "2 minutes ago"
          */
        timeAgo: function(dateString) {
            var rightNow = new Date();
            var then = new Date(dateString);

            if ($.browser == 'msie') {
                // IE can't parse these crazy Ruby dates
                then = Date.parse(dateString.replace(/( \+)/, ' UTC$1'));
            }

            var diff = rightNow - then;

            var second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24,
            week = day * 7;

            if (isNaN(diff) || diff < 0) {
                return ""; // return blank string if unknown
            }

            if (diff < second * 2) {
                // within 2 seconds
                return "right now";
            }

            if (diff < minute) {
                return Math.floor(diff / second) + "s";
            }

            if (diff < minute * 2) {
                return "about 1 minute ago";
            }

            if (diff < hour) {
                return Math.floor(diff / minute) + "m";
            }

            if (diff < hour * 2) {
                return "about 1 hour ago";
            }
     
            if (diff < day) {
                return  Math.floor(diff / hour) + "h";
            }
     
            if (diff > day && diff < day * 2) {
                return "yesterday";
            }
     
            if (diff < day * 365) {
                return Math.floor(diff / day) + "d";
            }

            else {
                return "1y+";
            }
        }, // timeAgo()

        /**
          * The Twitalinkahashifyer!
          * http://www.dustindiaz.com/basement/ify.html
          * Eg:
          * ify.clean('your tweet text');
          */
        ify:  {
          link: function(tweet) {
            return tweet.replace(/\b(((https*\:\/\/)|www\.)[^\"\']+?)(([!?,.\)]+)?(\s|$))/g, function(link, m1, m2, m3, m4) {
              var http = m2.match(/w/) ? 'http://' : '';
              return '<a class="twtr-hyperlink" target="_blank" href="' + http + m1 + '">' + ((m1.length > 25) ? m1.substr(0, 24) + '...' : m1) + '</a>' + m4;
            });
          },

          at: function(tweet) {
            return tweet.replace(/\B[@＠]([a-zA-Z0-9_]{1,20})/g, function(m, username) {
              return '<a target="_blank" class="twtr-atreply" href="http://twitter.com/intent/user?screen_name=' + username + '">@' + username + '</a>';
            });
          },

          list: function(tweet) {
            return tweet.replace(/\B[@＠]([a-zA-Z0-9_]{1,20}\/\w+)/g, function(m, userlist) {
              return '<a target="_blank" class="twtr-atreply" href="http://twitter.com/' + userlist + '">@' + userlist + '</a>';
            });
          },

          hash: function(tweet) {
            return tweet.replace(/(^|\s+)#(\w+)/gi, function(m, before, hash) {
              return before + '<a target="_blank" class="twtr-hashtag" href="http://twitter.com/search?q=%23' + hash + '">#' + hash + '</a>';
            });
          },

          clean: function(tweet) {
            return this.hash(this.at(this.list(this.link(tweet.replace(/^RT @\w*: /, "")))));
          }
        } // ify
    };
    $(document).ready( function() {
        // start jqtweet!
        if(jQuery('#twitter').length) {
            JQTWEET.loadTweets();
        }
    });
});


