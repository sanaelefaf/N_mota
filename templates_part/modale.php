<!-- contact-modal.php -->

  <div class="modal-content">
    <span id="modalClose" class="close">&times;</span>
    <img class="contact" src="<?php echo get_template_directory_uri(); ?>/img/contact.png" alt="Image">
    <?php echo do_shortcode('[wpforms id="45"]'); ?>
  </div>
</div>
