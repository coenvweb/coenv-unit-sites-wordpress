<?php

class HTMLEmailGenerator {
    public $newsletter_id;
    public $cdn_url;
    public $newsletter_type;

    function __construct($newsletter_id) {
        $this->newsletter_id = $newsletter_id;
        $this->cdn_url = '//coenv-media-gene1ufvxiloffjq.stackpathdns.com/';
        $this->newsletter_type = get_field('newsletter_type', $newsletter_id);
    }

    public function getHeader() {
        if($this->newsletter_type == 'headlines') {
            return '{{> header }}';
        } else {
            return '{{> sciheader }}';
        }
    }

   public function getCollege() {
		$outside = get_field('outside_news', $this->newsletter_id);
		$content = '<div class="college_wrap">';
			$content .= '<row class="college">';
				$content .= '<columns small="8">';
					$content .= '<spacer size="16"></spacer>';
						$content .= '<h4 class="section-head"><img class="head-tag" height="25px" src="https://explore.uw.edu/rs/131-AQO-225/images/news_tag.png" alt="News From Around The College" /></h4>';
					$content .= '<spacer size="16"></spacer>';
					$content .= '<div class="around_list">';
					foreach($outside as $post) {
						$content .= '<a href="'.$post['link'].'"><p>';
						$content .= $post['title'] . ',<span> '.$post['source'].'</span>';
						$content .= '</p></a>';
					}
					$content .= '</div>';
				$content .= '</columns>';
			$content .= '</row>';
		$content .= '</div>';
		return htmlentities($content);
    }
    
    public function getSciofScicomm() {
		$outside = get_field('outside_news', $this->newsletter_id);
		$content = '<wrapper class="college_wrap">';
			$content .= '<row class="college">';
				$content .= '<columns small="8">';
					$content .= '<spacer size="16"></spacer>';
					$content .= '<h3 class="scicomm-head">In the Literature</h3><p class="scicomm-desc">Read about the nuts and bolts of science communication.</p>';
                $content .= '</columns>';
            $content .= '</row>';
            $content .= '<row>';
                $content .= '<columns small="8" class="around_list">';
                foreach($outside as $post) {
                    $content .= '<a href="'.$post['link'].'"><p>';
                    $content .= $post['title'] . ',<span> '.$post['source'].'</span>';
                    $content .= '</p></a>';
                }
                $content .= '</columns>';
            $content .= '</row>';
		$content .= '</wrapper>';
		return htmlentities($content);
    } 

    public function getFooter() {
        if($this->newsletter_type == 'headlines') {
            return '{{> footer }}';
        } else {
            return '{{> scifooter }}';
        }
    }

    public function getSocial() {
        return '{{> social }}';
    }

  private function buildHeadlinesFeature($post) {
        $attID = get_post_thumbnail_id( $post->ID );
        $image = wp_get_attachment_image_src( $attID, 'large' );
        $imageUrl = str_replace('//environment.uw.edu/wp-content/uploads/', $this->cdn_url, $image[0]);

        $post_content = '<row class="feature_title">';
            $post_content .= '<columns small="8">';
                $post_content .= '<a href="'.get_permalink($this->newsletter_id).'#'.$post->ID.'"><h4 class="post_title text-left">' . $post->post_title . '</h4></a>';
            $post_content .= '</columns>';
        $post_content .= '</row>';
        $post_content .= '<row class="feature_hero">';
            $post_content .= '<columns small="8" class="feature_hero">';
                $post_content .= '<a href="'.get_permalink($this->newsletter_id).'#'.$post->ID.'"><center>';
                    $post_content .= '<img class="feature_image" width="576" src="'.$imageUrl.'" alt="'.get_post_meta($attID, '_wp_attachment_image_alt', true).'" />';
                $post_content .= '</center></a>';
            $post_content .= '</columns>';
        $post_content .= '</row>';
        $post_content .= '<row class="feature_content">';
            $post_content .= '<columns small="8" class="feature_content">';
                $post_content .= '<p class="text-left">' . $post->post_excerpt . '</p>';
                $post_content .= '<spacer size="10"></spacer>';
                $post_content .= '<a href="'.get_permalink($this->newsletter_id).'#'.$post->ID.'"><img class="read_more" width="125" src="https://explore.uw.edu/rs/131-AQO-225/images/Purple_button.png" alt="Read More" /></a>';
            $post_content .= '</columns>';
        $post_content .= '</row>';
        $post_content .= '<spacer size="15"></spacer>';

        return $post_content;
    }

   private function getHeadlinesEvents($events) {
        $content .= '<row>';
            foreach($events as $key => $event) {
                if($event['end_date']) {
                    $sdate = date('l, F j', strtotime($event['start_date']));
                    $edate = date('l, F j', strtotime($event['end_date']));
                    $date = $sdate . " - <br>" . $edate;
                } else {
                    $date = date('l, F j', strtotime($event['start_date']));
                }
                $content .= '<columns class="text-center event" valign="middle" small="8" large="4">';
                    $content .= '<a href="' . $event['link'] . '">';
                        $content .= '<row><columns class="event_container text-center" small="8" large="8">';
                            $content .= '<spacer size="16"></spacer><center><img align="center" class="text-center event_calendar_icon" src="https://explore.uw.edu/rs/131-AQO-225/images/calendar_purple.png" alt="calendar" /></center>';
                            $content .= '<spacer size="16"></spacer><h5 class="event_date text-center">';
                                $content .= $date;
                            $content .= '</h5>';
                            $content .= '<h5 class="event_title text-center">';
                                $content .= $event['title'];
                            $content .= '</h5>';
                        $content .= '</columns></row>';
                    $content .= '</a>';
                $content .= '</columns>';
            }
        $content .= '</row>';
        return $content;
    }

    private function getScicommEvents($events) {
        $content .= '<row>';
            foreach($events as $key => $event) {
                if($event['end_date']) {
                    $sdate = date('l, F j', strtotime($event['start_date']));
                    $edate = date('l, F j', strtotime($event['end_date']));
                    $date = $sdate . " - <br>" . $edate;
                } else {
                    $date = date('l, F j', strtotime($event['start_date']));
                }
                $content .= '<columns class="event" valign="top" small="8" large="4">';
                    $content .= '<div class="event_container">';
                        $content .= '<a href="' . $event['link'] . '">';
                            $content .= '<h5 class="event_title">';
                                    $content .= $event['title'];
                            $content .= '</h5>';
                            $content .= '<h5 class="event_date">';
                                $content .= '<img class="float-left event_calendar_icon" src="https://explore.uw.edu/rs/131-AQO-225/images/calendar_purple.png" alt="calendar" />';
                                $content .= '<span>'.$date.'</span>';
                            $content .= '</h5>';
                        $content .= '</a>';
                    $content .= '</div>';
                    $content .= '<spacer size="16"></spacer>';
                $content .= '</columns>';
            }
        return $content;
    }

    private function buildScicommFeature() {
        $attID = get_field('feature_image', $this->newsletter_id );
        $image = wp_get_attachment_image_src( $attID, 'large' );
        $imageUrl = str_replace('//environment.uw.edu/wp-content/uploads/', $this->cdn_url, $image[0]);
        $postLink = get_field('feature_link', $this->newsletter_id);

        $post_content = '<row class="feature_hero collapse">';
            $post_content .= '<columns small="8" class="feature_hero">';
                $post_content .= '<a href="'.$postLink.'"><center>';
                    $post_content .= '<img class="feature_image" width="640" src="'.$imageUrl.'" alt="'.get_post_meta($attID, '_wp_attachment_image_alt', true).'" />';
                $post_content .= '</center></a>';
            $post_content .= '</columns>';
        $post_content .= '</row>';
        $post_content .= '<row class="feature_title">';
            $post_content .= '<columns small="8">';
                $post_content .= '<a href="'.$postLink.'"><h4 class="post_title text-left">' . get_field('feature_title', $this->newsletter_id) . '</h4></a>';
            $post_content .= '</columns>';
        $post_content .= '</row>';
        $post_content .= '<row class="feature_content">';
            $post_content .= '<columns small="8" class="feature_content">';
                $post_content .= '<p class="text-left">' . get_field('feature_content', $this->newsletter_id) . '</p>';
                $post_content .= '<spacer size="16"></spacer>';
                $post_content .= '<a class="button read_more" href="'.$postLink.'">READ MORE</a>';
            $post_content .= '</columns>';
        $post_content .= '</row>';
        $post_content .= '<spacer size="5"></spacer>';

        return $post_content;
    }

   private function getPost($post) {
        $attID = get_post_thumbnail_id( $post->ID );
        $image = wp_get_attachment_image_src( $attID, 'medium' );
        $imageUrl = str_replace('//environment.uw.edu/wp-content/uploads/', $this->cdn_url, $image[0]);

        $post_content = '<row class="news_item">';
            $post_content .= '<columns small="8" large="4" class="text-center post_hero">';
                $post_content .= '<a href="'.get_permalink($this->newsletter_id).'#'.$post->ID.'"><center>';
                    $post_content .= '<img class="post_image" width="273" src="'.$imageUrl.'" alt="'.get_post_meta($attID, '_wp_attachment_image_alt', true).'" />';
                $post_content .= '</center></a>';
            $post_content .= '</columns>';
            $post_content .= '<columns small="8" large="4" valign="top" align="left" class="post_content">';
                $post_content .= '<a class="text-left" href="'.get_permalink($this->newsletter_id).'#'.$post->ID.'"><h4 class="post_title text-left">' . $post->post_title . '</h4></a>';
                $post_content .= '<spacer size="10"></spacer>';
                $post_content .= '<a class="secondary" href="'.get_permalink($this->newsletter_id).'#'.$post->ID.'"><img class="read_more" width="125" src="https://explore.uw.edu/rs/131-AQO-225/images/Gray_button.png" alt="Read More" /></a>';
            $post_content .= '</columns>';
        $post_content .= '</row>';

        return $post_content;
    }

    private function getScicommPost($post) {
        $attID = $post['image'];
        $image = wp_get_attachment_image_src( $attID, 'medium' );
        $imageUrl = str_replace('//environment.uw.edu/wp-content/uploads/', $this->cdn_url, $image[0]);

            $post_content .= '<columns small="8" large="4" class="text-center post_hero news_item" valign="top">';
                $post_content .= '<a href="'.$post['link'].'"><center>';
                    $post_content .= '<img class="post_image" width="273" src="'.$imageUrl.'" alt="'.get_post_meta($attID, '_wp_attachment_image_alt', true).'" />';
                $post_content .= '</center></a>';
                $post_content .= '<spacer size="10"></spacer>';
                $post_content .= '<a href="'.$post['link'].'"><h4 class="post_title text-left">' . $post['title'] . '</h4></a>';
                $post_content .= '<spacer size="10"></spacer>';
                $post_content .= '<a class="secondary" href="'.$post['link'].'">'.$post['source'].'</a>';
            $post_content .= '</columns>';

        return $post_content;
    } 

    public function getNews() {
		if($this->newsletter_type == 'headlines') {
            $content = '<row><columns small="8"><h4 class="section-head"><img class="head-tag" height="25px" src="https://explore.uw.edu/rs/131-AQO-225/images/moreNews_tag.png" alt="More News" /></h4></columns></row>';
            $content .= '<spacer size="10"></spacer>';
            $news_posts = get_field('news_items', $this->newsletter_id);
            foreach($news_posts as $post) {
                $content.=$this->getPost($post['news_item']);
            }
        } else {
            $content = '<row><columns small="8"><spacer size="16"></spacer><h3 class="section-head">Good Reads</h3></columns></row>';
            $content .= '<spacer size="10"></spacer>';
            $news_posts = get_field('scicomm_news_items', $this->newsletter_id);
            $count = 0;
            foreach ($news_posts as $post) {
                if($count % 2 == 0) {
                    $content.= '<row class="news_item">';
                }
                $content.=$this->getScicommPost($post);
                if($count % 2 == 1) {
                    $content.= '</row>';
                } elseif ($count == count($news_posts) - 1) {
                    $content.= '<columns class="news_item" large="4" small="8"></columns></row>';
                } else {
                }
                $count++;
            }
        }

        return htmlentities($content);
    }

    public function getFeature() {
		if($this->newsletter_type == 'headlines') {
            $content = '<row><columns small="8"><spacer size="16"></spacer><h4 class="section-head"><img class="head-tag" height="25px" src="https://explore.uw.edu/rs/131-AQO-225/images/featureStory_tag.png" alt="Featured Story" /></h4></columns></row>';
            $post = get_field('feature_story', $this->newsletter_id);
            $content.=$this->buildHeadlinesFeature($post);
        } else {
            $content=$this->buildScicommFeature();
        }
        return htmlentities($content);
    }

   public function getEvents() {
        $events = get_field('events', $this->newsletter_id);


        $content = '<wrapper class="events">';
            $content .= '<row>';
                $content .= '<columns small="8">';
                    $content .= '<spacer size="16"></spacer>';
					if($this->newsletter_type == 'headlines') {
                        $content .= '<h4 class="section-head"><img class="head-tag" height="25px" src="https://explore.uw.edu/rs/131-AQO-225/images/events_tag.png" alt="Events" /></h4>';
                        $content .= '</columns>';
                        $content .= '</row>';
                        $content .= $this->getHeadlinesEvents($events);
                        $content .= '<row>';
                            $content .= '<columns small="8" class="text-center">';
                                $content .= '<h5 class="more_events text-center"><img class="more_events_icon" valign="middle" src="https://explore.uw.edu/rs/131-AQO-225/images/calendar_gray.png" />   Check out our calendar for <a href="http://environment.uw.edu/alumni-and-community/calendar-events/">more</a> events</h5>';
                            $content .= '</columns>';
                        $content .= '</row>';
                    } else {
                        $content .= '<h3 class="section-head">Events and Opportunities</h3><p class="section-desc">Trainings, workshops, discussions and other opportunities allow you to learn, practice and deploy your science communication skills.</p>';
                        $content .= '</columns>';
                        $content .= '</row>';
                        $content .= $this->getScicommEvents($events);
                    }
        $content .= '</wrapper>';

        return htmlentities($content);
    } 

    public function getScicomm() {
        return '{{> scicomm }}';
    }


    public function getNewsletter() {
        $content =  $this->getHeader();
        $content .= $this->getFeature();
        $content .= $this->getNews();
        if($this->newsletter_type == 'headlines') {
            $content .= $this->getSocial();
        } else {
            $content .= $this->getSciofScicomm();
        }
        $content .= $this->getEvents();
        if($this->newsletter_type == 'headlines') {
            $content .= $this->getCollege();
        }
        if($this->newsletter_type == 'scicomm') {
            $content .= $this->getScicomm();
        }
        $content .= $this->getFooter();
        return $content;
    }
}

?>
