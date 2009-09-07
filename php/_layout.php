<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
   <title><?php if (!empty($title)): echo "$title - "; endif; ?>noonat+games</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="shortcut icon" href="http://7.media.tumblr.com/avatar_d74a28b04fef_16.png"/>
   <link rel="alternate" type="application/rss+xml" href="<?php echo $url_prefix; ?>/rss"/>
   <link rel="stylesheet" href="<?php echo $url_prefix; ?>/css/blueprint/screen.css" type="text/css" media="screen, projection"/>
   <link rel="stylesheet" href="<?php echo $url_prefix; ?>/css/blueprint/print.css" type="text/css" media="print"/>
   <!--[if lt IE 8]><link rel="stylesheet" href="<?php echo $url_prefix; ?>/css/blueprint/ie.css" type="text/css" media="screen, projection"/><![endif]-->
   <!--<link rel="stylesheet" href="<?php echo $url_prefix; ?>/css/blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection"/>-->
   <link rel="stylesheet" type="text/css" href="<?php echo $url_prefix; ?>/css/styles.css"/>
</head>

<body class="action_<?php echo $action; ?>">
<div class="container">
   <div id="nav" class="span-20">
      <ul>
         <li><a href="<?php echo $url_prefix; ?>/archive">Archives</a></li>
         <li><a href="<?php echo $url_prefix; ?>/rss">RSS</a></li>
      </ul>
   </div>
   <div id="body" class="span-13"><?php echo $body; ?></div>
   <div id="mast" class="span-7 last">
      <h1><a href="<?php echo $url_prefix; ?>"><?php echo $tumblr->title; ?></a></h1>
      <div class="search">
         <form action="<?php echo $url_prefix ?>/search" method="get">
            <input type="text" name="q" value="<?php echo !empty($_GET['q']) ? $_GET['q'] : ''; ?>"/>
            <input type="submit" value="Search"/>
         </form>
      </div>
      <div class="contact">
         <a href="http://github.com/noonat">github.com/noonat</a><br/>
         email
         <script type="text/javascript">
         function omclick(){ window.location='mai'+'lto:'+this.innerHTML; };
         var m = ['noon','com','phuce','at'];
         document.write(
            '<a href="#" onclick="omclick.call(this); return false;">'+
            m[0]+m[3]+'@'+m[2]+'.'+m[1]+'</a>');
         </script>
         <br/>
         twitter @noonat
      </div>
   </div>
</div>

<!-- disqus -->
<?php if ($action === 'post'): ?>
<script type="text/javascript">
var disqus_url = <?php echo $tumblr->posts[0]->post->url_with_slug; ?>;
var disqus_title = <?php echo $tumblr->posts[0]->post->title ?>;
</script>
<script charset="utf-8" type="text/javascript" src="http://disqus.com/forums/noonat/embed.js"></script><?php endif; ?>
<script type="text/javascript">
//<![CDATA[
(function() {
   var links = document.getElementsByTagName('a');
   var query = '?';
   for(var i = 0; i < links.length; i++) {
      if(links[i].href.indexOf('#disqus_thread') >= 0) {
         query += 'url' + i + '=' + encodeURIComponent(links[i].href) + '&';
      }
   }
   document.write('<script charset="utf-8" type="text/javascript" src="http://disqus.com/forums/noonat/get_num_replies.js' + query + '"></' + 'script>');
})();
//]]>
</script>

<!-- ga -->
<script type="text/javascript">
   var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
   document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
   var pageTracker = _gat._getTracker("UA-9140800-1");
   pageTracker._trackPageview();
} catch(err) {}
</script>

</body>

</html>
