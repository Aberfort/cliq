<div class="wrap">
  <h1>Cliq test plugin</h1>

  <form method="post" action="options.php">
    <?php
    settings_fields("section");

    do_settings_sections("shortcode-checker");

    submit_button();
    ?>
  </form>
</div>