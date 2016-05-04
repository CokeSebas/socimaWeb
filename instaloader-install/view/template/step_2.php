<h1>Step 2 - Finished</h1>
<div id="column-right">
  <ul>
    <li>Pre-Installation</li>
    <li><b>Finished</b></li>
  </ul>
</div>
<div id="content">
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <form action="<?php echo $action; ?>" method="post">
    <div class="terms">
      <h3>Log</h3>
      <h4><?php echo $log_file_path; ?></h4>
      <pre><?php echo $log; ?></pre>
    </div>
    <div class="buttons">
      <div class="left">
        <a href="<?php echo $log_link ?>" class="button">Download Log File</a>
      </div>
      <div class="right">
        <a href="<?php echo $admin_link ?>" class="button">Back to Admin</a>
      </div>
    </div>
  </form>
</div>