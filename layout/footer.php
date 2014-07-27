	<div id="footer">
      <div class="container">
        <p class="text-muted">
			&copy; <?php echo date("Y", time()); ?>
			<a href="http://www.yashbeer.com">GetSetGo PHP Framework</a>
		</p>
      </div>
    </div>
	
	<!-- Closing database connection by default -->
	<?php if(isset($database)) { $database->close_connection(); } ?>