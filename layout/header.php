<!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo BASE_URL?>">GetSetGo PHP</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="<?php if(isset($one)) {echo $one;}?>">
				<a href="<?php echo BASE_URL?>home.php">Home</a>
			</li>
            <li class="dropdown <?php if(isset($two)) {echo $two;}?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Examples <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo BASE_URL?>examples/addressbook/index.php">Address Book</a></li>
                <li><a href="<?php echo BASE_URL?>#">#Example2</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Settings</li>
                <li><a href="<?php echo BASE_URL?>createuser.php">Create new User</a></li>
                <li><a href="<?php echo BASE_URL?>logout.php">Logout</a></li>
              </ul>
            </li>
            <li class="<?php if(isset($three)) {echo $three;}?>">
				<a href="<?php echo BASE_URL?>contact.php">Contact</a>
			</li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>