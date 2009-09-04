<?php

class Tumblr {   
   function __construct($username) {
      $this->username = $username;
   }
   
   function read($args=array()) {
      $json = $this->_api('read', $args);
      $posts = array();
      foreach ($json->posts as $post) {
         $posts[] = new Tumblr_Post($post);
      }
      $this->name = $json->tumblelog->name;
      $this->title = $json->tumblelog->title;
      $this->description = $json->tumblelog->description;
      $this->timezone = $json->tumblelog->timezone;
      $this->cname = $json->tumblelog->cname;
      $this->feeds = $json->tumblelog->feeds;
      $this->posts = $posts;
      $k = 'posts-start'; $this->posts_start = $json->$k;
      $k = 'posts-total'; $this->posts_total = $json->$k;
      $k = 'posts-type'; $this->posts_type = $json->$k;
      return $posts;
   }
   
   function _api($method, $args) {
      $url = 'http://'.$this->username.'.tumblr.com/api/'.$method.'/json?' . http_build_query($args);
      return Tumblr_HTTP::get_cached($url);
   }
}

class Tumblr_Post {
   const TYPE_REGULAR = 'regular';
   const TYPE_PHOTO = 'photo';
   const TYPE_QUOTE = 'quote';
   const TYPE_LINK = 'link';
   const TYPE_CONVERSATION = 'conversation';
   const TYPE_VIDEO = 'video';
   const TYPE_AUDIO = 'audio';
   
   function __construct($data) {
      $vars = get_object_vars($data);
      $this->id = (int)$vars['id'];
      $this->url = $vars['url'];
      $this->url_with_slug = $vars['url-with-slug'];
      $this->slug = substr($this->url_with_slug, strlen($this->url)+1);
      $this->type = $vars['type'];
      $this->date_gmt = strtotime($vars['date-gmt']);
      $this->date = strtotime($vars['date']);
      $this->bookmarklet = (int)$vars['bookmarklet'];
      $this->mobile = (int)$vars['mobile'];
      $this->feed_item = $vars['feed-item'];
      $this->from_feed_id = (int)$vars['from-feed-id'];
      $this->unix_timestamp = (int)$vars['unix-timestamp'];
      $this->format = $vars['format'];
      $this->tags = isset($vars['tags']) ? $vars['tags'] : array();
      switch ($this->type) {
      case self::TYPE_REGULAR:
         $this->regular_title = $vars['regular-title'];
         $this->regular_body = $vars['regular-body'];
         break;
      case self::TYPE_PHOTO:
         $this->photo_caption = $vars['photo-caption'];
         $this->photo_urls = array();
         foreach ($vars as $key=>$value) {
            if (preg_match('/^photo-url-([0-9]+)$/', $key, $matches)) {
               $this->photo_urls[(int)$matches[1]] = $value;
            }
         }
         $this->photo_url = $this->photo_urls[max(array_keys($this->photo_urls))];
         $this->photos = isset($vars['photos']) ? $vars['photos'] : array();
         break;
      case self::TYPE_QUOTE:
         $this->quote_text = $vars['quote-text'];
         $this->quote_source = $vars['quote-source'];
         break;
      case self::TYPE_LINK:
         $this->link_text = $vars['link-text'];
         $this->link_url = $vars['link-url'];
         $this->link_description = $vars['link-description'];
         break;
      case self::TYPE_CONVERSATION:
         $this->conversation_title = $vars['conversation-title'];
         $this->conversation_text = $vars['conversation-text'];
         $this->conversation_lines = array();
         foreach ($vars['conversation'] as $line) {
            $this->conversation_lines[] = array(
               'name' => $line->name,
               'label' => $line->label,
               'phrase' => $line->phrase);
         }
         break;
      case self::TYPE_VIDEO:
         $this->video_caption = $vars['video-caption'];
         $this->video_source = $vars['video-source'];
         $this->video_player = $vars['video-player'];
         break;
      case self::TYPE_AUDIO:
         $this->audio_caption = $vars['audio-caption'];
         $this->audio_player = $vars['audio-player'];
         $this->audio_plays = isset($vars['audio-plays']) ? (int)$vars['audio-plays'] : 0;
         break;
      }
   }
   
   function permalink() {
      global $url_prefix;
      return $url_prefix.'/post/'.$this->id.'/'.$this->slug;
   }
}

class Tumblr_HTTP {
   static $cache_time = 300; // 5 minutes
   static $_cache_pending = array();
   
   static function get($url, $fn=null) {
      if (function_exists('curl_init')) {
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
         $json = curl_exec($ch);
         curl_close($ch);
      }
      else {
         $json = file_get_contents($url);
      }
      if (preg_match('/^.+?(\{.+\});$/m', $json, $matches)) {
         $json = $matches[1];
      }
      self::_cache($url, $json, $fn);
      return $json;
   }
   
   static function get_cached($url) {
      $fn = self::_cache_filename($url);
      $json = @file_get_contents($fn);
      if ($json !== false) $json = json_decode($json);
      if ($json === false) $json = json_decode(self::get($url, $fn));
      else {
         $mtime = @filemtime($fn);
         if ($mtime+self::$cache_time < time()) {
            self::$_cache_pending[] = $url;
         }
      }
      return $json;
   }
   
   static function _cache($url, $json, $fn=null) {
      if (is_null($fn)) $fn = self::_cache_filename($url);
      return file_put_contents($fn, $json);
   }
   
   static function _cache_filename($url) {
      return dirname(__FILE__).'/cache/'.md5($url);
   }
   
   static function _cache_pending() {
      foreach (self::$_cache_pending as $url) {
         self::get($url);
      }
   }
}

function tumblr_http_shutdown() {
   Tumblr_HTTP::_cache_pending();
}
register_shutdown_function('tumblr_http_shutdown');
