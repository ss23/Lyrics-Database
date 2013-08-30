<nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <span class="navbar-brand" href="#">LyricJam</span>
  </div>

  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <li><a href="/">
      	<span class="glyphicon glyphicon-home"></span> <?php echo __("Home") ?>
      </a></li>
      <li class="dropdown">
        <?php
        	echo $this->Html->link('<span class="glyphicon glyphicon-list"></span> '.__("Browse").' <b class="caret"></b>',
				array('controller'=>'songs'),
				array(
					'escape' => false,
					'class' => 'dropdown-toggle',
					'data-toggle' => 'dropdown',
				)
			);
        ?>
        <ul class="dropdown-menu browse-list">
          <li><a href="<?php echo Router::url(array('controller' => 'artists', 'action' => 'index')) ?>">
            <span class="glyphicon glyphicon-user"></span><span class="browse-item-text"><?php echo __("Artists") ?></span><span class="badge pull-right"><?php echo $counts['Artists'] ?></span>
          </a></li>
          <li><a href="<?php echo Router::url(array('controller' => 'albums', 'action' => 'index')) ?>">
            <span class="glyphicon glyphicon-folder-open"></span><span class="browse-item-text"><?php echo __("Albums") ?></span><span class="badge pull-right"><?php echo $counts['Albums'] ?></span>
          </a></li>
          <li><a href="<?php echo Router::url(array('controller' => 'songs', 'action' => 'index')) ?>">
            <span class="glyphicon glyphicon-music"></span><span class="browse-item-text"><?php echo __("Songs") ?></span><span class="badge pull-right"><?php echo $counts['Songs'] ?></span>
          </a></li>
        </ul>
      </li>
      <li><a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'display', 'apidocs')) ?>">
      	<span class="glyphicon glyphicon-book"></span> <?php echo __("API Docs") ?>
      </a></li>
      <li><a href="<?php echo Router::url(array('controller' => 'pages', 'action' => 'display', 'about')) ?>">
      	<span class="glyphicon glyphicon-info-sign"></span> <?php echo __("About") ?>
      </a></li>
    </ul>
	<form action="/search" method="get" class="navbar-form navbar-right" role="search">
      <div class="form-group">
      <div id="searchbar" class="input-group">
	      <input name="q" type="text" class="form-control" placeholder="Lyric, Artist, or Song title...">
	      <span class="input-group-btn">
	        <button class="btn btn-default" type="submit" title="Search"><span class="glyphicon glyphicon-search"></span></button>
	      </span>
	    </div>
      </div>
    </form>
  </div><!-- /.navbar-collapse -->
  
  
</nav>