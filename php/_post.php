<div class="post">
   <div class="<?php echo htmlentities($post->type); ?>">
      <div class="permalink"><a href="<?php echo $url_prefix; ?>/post/<?php echo $post->id; ?>/<?php echo $post->slug; ?>">+</a></div>
      <?php if ($post->type === Tumblr_Post::TYPE_REGULAR): ?>
         <h2 class="regular_title"><?php echo $post->regular_title; ?></h2>
         <div class="regular_body"><?php echo $post->regular_body; ?></div>
      <?php elseif ($post->type === Tumblr_Post::TYPE_PHOTO): ?>
         <a class="photo_url" href=""><img src="<?php echo $post->photo_url; ?>" alt="<?php echo htmlentities($post->photo_caption); ?>"/></a>
         <?php if (!empty($post->photo_caption)): ?>
         <div class="photo_caption"><?php echo $post->photo_caption; ?></div>
         <?php endif; ?>
      <?php elseif ($post->type === Tumblr_Post::TYPE_QUOTE): ?>
         <div class="quote_text"><?php echo $post->quote_text; ?></div>
         <div class="quote_source">&mdash; <?php echo $post->quote_source; ?></div>
      <?php elseif ($post->type === Tumblr_Post::TYPE_LINK): ?>
         <a class="link_text" href="<?php echo $post->link_url; ?>"><?php echo $post->link_text; ?></a>
         <?php if (!empty($post->link_description)): ?>
         <span class="link_description"><?php echo $post->link_description; ?></span>
         <?php endif; ?>
      <?php elseif ($post->type === Tumblr_Post::TYPE_CONVERSATION): ?>
         <?php if (!empty($post->conversation_title)): ?>
         <h2 class="conversation_title"><?php echo $post->conversation_title; ?></h2>
         <?php endif; ?>
         <div class="conversation_lines">
            <?php foreach ($post->conversation_lines as $line): ?>
            <div class="line">
               <span class="label"><?php echo $line['label']; ?></span>
               <span class="text"><?php echo $line['phrase']; ?></span>
            </div>
            <?php endforeach; ?>
         </div>
      <?php elseif ($post->type === Tumblr_Post::TYPE_VIDEO): ?>
         <div class="video_player"><?php echo $post->video_player; ?></div>
         <?php if (!empty($post->video_player)): ?>
         <div class="video_caption"><?php echo $post->video_caption; ?></div>
         <?php endif; ?>
      <?php elseif ($post->type === Tumblr_Post::TYPE_AUDIO): ?>
         <div class="audio_player"><?php echo $post->audio_player; ?></div>
         <?php if (!empty($post->audio_caption)): ?>
         <div class="audio_caption"><?php echo $post->audio_caption; ?></div>
         <?php endif; ?>
      <?php endif; ?>
   </div>
   <div class="meta">
      <div class="comments"><a class="dsq-comment-count" href="<?php echo $url_prefix; ?>/post/<?php echo $post->id ?>/<?php echo $post->slug; ?>#disqus_thread">comments</a></div>
      <div class="date">
         <span class="month"><?php echo date('M j', $post->unix_timestamp); ?></span>
         <span class="year"><?php echo date('Y', $post->unix_timestamp); ?></span>
      </div>
   </div>
   <?php if ($action === 'post'): ?><div class="comments_thread" id="disqus_thread"></div><?php endif; ?>
</div>
