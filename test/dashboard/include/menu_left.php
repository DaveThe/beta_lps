            
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo( MEDIA_PATH.'avatar/'.$Dashboard_user->img ); ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Hello, <?php echo( $Dashboard_user->GetUsername() ); ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>            	
			<li>
				<a href="index.php">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>	                        						
            <?php	
            	foreach($area as $a_menu)
            	{ 
            	    if($a_menu['page'] != 'update' && $a_menu['page'] != 'index' && $a_menu['page'] != 'timeline')
            		{ 
	       ?>
            			<li class="<?php echo ( (strtoupper ( $a_menu['area_name'] ) == PAGE_NAME) ? 'active' : '' ); ?> treeview ">
            				<a href="#">
            					<i class="<?php echo ($a_menu['img']); ?>"></i> <span><?php echo ($a_menu['display_name']); ?></span>
            					<i class="fa fa-angle-left pull-right"></i>
            				</a>
            				<ul class="treeview-menu">
            					<?php
            						if(sizeof($a_menu['sub_area'])>0) 
            						{
            							foreach($a_menu['sub_area'] as $a_menu_sub)
            							{ 
            							    if($a_menu_sub['sub_area_name'] != 'LOG_EDIT' && $a_menu_sub['sub_area_name'] != 'PLUGIN_EDIT')
                                            {
            					?>
            								<li  <?php echo ( (strtoupper ( $a_menu_sub['sub_area_name'] ) == PAGE_SUB) ? 'class="active"' : '' ); ?> >
            									<a href="<?php echo ( ( ( strpos($a_menu_sub['page'],'/') !== false ) ? '/plugin/' : '').$a_menu_sub['page']); ?>.php">
            										<i class="fa fa-circle-o"></i> <?php echo ($a_menu_sub['name']); ?>
            									</a>
            								</li>
            					<?php       }
            							}
            						}
            					?>
            				</ul>
            			</li>
            <?php
            		} 
            	}
            ?>
            <!--
			<li>
				<a href="update.php">
					<i class="fa fa-refresh"></i> <span>Updates</span>
					<small class="badge pull-right bg-yellow" id="updatecount">0</small>
				</a>
			</li>

			<li>
				<a href="timeline.php">
					<i class="fa fa-sort-amount-asc"></i> <span>Timeline</span>
				</a>
			</li>
            -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>