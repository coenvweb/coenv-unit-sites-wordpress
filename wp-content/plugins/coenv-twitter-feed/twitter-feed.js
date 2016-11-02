JQTWEET = {

    // Set twitter hash/user, number of tweets & id/class to append tweets
    appendTo: '#twitter',
    template: '<div class="tweet"><div class="tweet-wrapper"><div class="tweet-head">{PROF_IMG}\
               <div class="names"><div class="username"><a href="{USER_URL}" target="_blank">{NAME}</a></div><div class="at_name"><a href="{USER_URL2}" target="_blank">@{USER}</a></div></div></div>\
               <span class="content">{TEXT}</span><div class="media">{IMG}</div>\
               <div class="tweet-footer"><div class="timestamp"><span class="twitter-logo"><i class="fa fa-twitter"></i></span><a href="{URL}" target="_blank"> {AGO}</a></div>\
               <div class="twitter-actions"><a class="fa fa-reply" href="{REPLY}"></a>\
                 <a class="fa fa-retweet" href="{RETWEET}"></a>\
                 <a class="fa fa-star" href="{FAVORITE}"></a></div></div>\
                 </div></div>',

    loadTweets: function(user, numTweets) {

        var request;

        request = {
          action: 'getUserTimeline',
          screen_name: user,
          count: numTweets,
          api: 'statuses/user_timeline'
        }

        $.ajax({
            url: adminAjax.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: request,
            success: function(data, textStatus, xhr) {
                if (data) {

                    var text, name, img;

                      // append tweets into page
                      for (var i = 0; i < numTweets; i++) {
                        img = '';
                        url = 'https://twitter.com/' + data[i].user.screen_name + '/status/' + data[i].id_str;
                        if(data[i].retweeted_status) {
                            user = data[i].retweeted_status.user.screen_name;
                            name = data[i].retweeted_status.user.name;
                            user_url = 'https://twitter.com/' + data[i].retweeted_status.user.screen_name;
                            prof_img = '<a href="' + user_url + '" target="_blank"><img src="' + data[i].retweeted_status.user.profile_image_url_https + '" /></a>';
                            text = data[i].retweeted_status.text;
                        } else {
                            user = data[i].user.screen_name;
                            name = data[i].user.name;
                            user_url = 'https://twitter.com/' + data[i].user.screen_name;
                            prof_img = '<a href="' + user_url + '" target="_blank"><img src="' + data[i].user.profile_image_url_https + '" /></a>';
                            text = data[i].text;
                        }
                        reply = 'https://twitter.com/intent/tweet?lang=en&in_reply_to=' + data[i].id_str;
                        retweet = 'https://twitter.com/intent/retweet?lang=en&tweet_id=' + data[i].id_str;
                        favorite = 'https://twitter.com/intent/favorite?lang=en&tweet_id=' + data[i].id_str;
                        try {
                          if (data[i].entities['media']) {
                            img = '<a href="' + url + '" target="_blank"><img src="' + data[i].entities['media'][0].media_url + '" /></a>';
                          }
                        } catch (e) {
                          //no media
                        }

                        $(JQTWEET.appendTo).append( JQTWEET.template.replace('{TEXT}', JQTWEET.ify.clean(text) )
                            .replace('{USER}', user)
                            .replace('{NAME}', name)
                            .replace('{PROF_IMG}', prof_img)
                            .replace('{IMG}', img)
                            .replace('{AGO}', JQTWEET.timeAgo(data[i].created_at) )
                            .replace('{REPLY}', reply)
                            .replace('{RETWEET}', retweet)
                            .replace('{FAVORITE}', favorite)
                            .replace('{USER_URL}', user_url )
                            .replace('{USER_URL2}', user_url )
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
            return "now";
        }

        if (diff < minute) {
            return Math.floor(diff / second) + "s";
        }

        if (diff < hour) {
            return Math.floor(diff / minute) + "m";
        }

        if (diff < day) {
            return  Math.floor(diff / hour) + "h";
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
        return this.hash(this.at(this.list(this.link(tweet))));
      }
    } // ify
};

