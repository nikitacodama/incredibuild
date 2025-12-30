<?php
$socials = get_field('footer', 'option')['socials'];
?> 
<?php if( $socials ): ?>
<div class="socials flex align_c gap_12">
    <?php foreach( $socials as $social ): ?>
       <a class="social_link" href="<?php echo $social['link']['url']; ?>" target="_blank">
        <?php echo wp_get_attachment_image( $social['image']['id'], 'full' ); ?>
       </a>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>