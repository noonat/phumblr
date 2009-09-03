<h2>Your search returned <?php echo count($tumblr->posts); ?> post<?php if (count($tumblr->posts) !== 1): echo 's'; endif; ?></h2>
<?php include '_posts.php'; ?>