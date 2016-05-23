<?php namespace Dashboard; ?>
        <!-- header logo: style can be found in header.less -->
        <header class="main-header">
            <a href="index.php" class="logo">
            
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><?php echo (substr($settings->titolo, 0, 1)); ?></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><?php echo ($settings->titolo); ?></span>
          <!-- Add the class icon to your logo image or logo icon to add the margining AdminLTE-->                
				<?php /* echo ( (isset($settings->logo) && $settings->logo != "" && file_exists('images/'.$settings->logo)) ? '<img src="'.'images/'.$settings->logo.'" width="225" height="70" border="0"  alt="Logo"/>' : $settings->titolo );*/ ?>               
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
			            <?php if(isset($mailsIds) && $mailsIds != NULL){ ?>
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success"><?php echo (count($mailsIds)); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have <?php echo (count($mailsIds)); ?> messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach($mailsIds as $mailId) { 
                                                    $mail = $mailbox->getMail($mailId);
                                                    $from = explode(" ", trim($mail->fromName));
                                            ?>
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <div class="img-circle" alt="User Image" style="background-color: #<?php echo (Common::random_color()); ?> !important;width: 40px;height: 40px;text-align: center;line-height: 40px;"><?php echo (filter_var( strtoupper( substr($from[0], 0, 1).''.( (count($from)>1) ? substr($from[1], 0, 1) : ' ') ) , FILTER_SANITIZE_STRING) ); ?></div>
                                                </div>
                                                <h4>
                                                    <?php echo (filter_var( $mail->fromName , FILTER_SANITIZE_STRING)); ?>
                                                    <small><i class="fa fa-clock-o"></i> <?php echo (DateFormat::dynamic_datediff($mail->date)); ?></small>
                                                </h4>
                                                <p><?php echo (filter_var( $mail->subject , FILTER_SANITIZE_STRING)); ?></p>
                                            </a>
                                        </li><!-- end message -->
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="footer"><a href="plugs.php?plug=IncomingMail&p_page=List.php">See All Messages</a></li>
                            </ul>
                        </li> 
						<?php } ?>
                        
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <?php 
                            $ParametersList['pagination'] = false;
                            $ParametersList['status'] = '0'; 
                            $loggy = Log::GetElementsList($ParametersList); ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-warning"><?php echo ($loggy->count()); ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have <?php echo ($loggy->count()); ?> notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach($loggy as $lg){ ?>
                                            <li>
                                                <a href="log_edit.php?id=<?php echo ( $lg->id ); ?>">
                                                    <i class="fa fa-warning <?php echo ( (($lg->error_type == '0') ? 'warning' : 'danger') );  ?>"></i> <?php echo ((strlen($lg->message) > 33) ? substr($lg->message,0,30).'...' : $lg->message); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="footer"><a href="log_list.php">View all</a></li>
                            </ul>
                        </li>
						
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo( $Dashboard_user->GetUsername() ); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo ( MEDIA_PATH.'avatar/'.( (isset($Dashboard_user->img) && $Dashboard_user->img!='') ? $Dashboard_user->img : 'avatar3.png' ) ); ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo( $Dashboard_user->GetUsername() ); ?> - Web Developer
                                        <!-- <small>Member since Nov. 2012</small> -->
                                        <small><?php echo( ( isset($Dashboard_user->company) && $Dashboard_user->company != '') ? 'Company: '.$Dashboard_user->company : '' ); ?> </small>
                                       
                                    </p>
                                </li>
                                <!-- Menu Body --><!--
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
								-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="user_edit.php?id=<?php echo ( $Dashboard_user->id ); ?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>