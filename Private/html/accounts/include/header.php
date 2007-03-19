</head>
<body>
<table class="main" width="100%" border="0">
<tr>
	<td>
	<div id="accounts_header">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" >
						<tr>
						<td  valign="top" style="white-space:nowrap; font-size:1.1em; ">
					
						<div><a href="http://sakaiproject.org"> <img src="<?=$admin_logo?>" align="left" alt="sakaiproject.org home page " style="border:0;padding-right: 30px; height:50px;"/></a>
						<div style="padding-top:10px;"><strong><?=$CONF_NAME?></strong></div>
						<div style="color:#333;padding-top:3px; padding-left: 20px; font-size: .95em;">&nbsp;<?=$CONF_LOC?>
						<br/>&nbsp;<?=$CONF_DAYS?> </div>
						</div>
						
						<br/>
					
					
				 
					</td>
					<td  style="text-align:right; vertical-align:top; white-space:nowrap;"> 
					      <div class="welcomebox">
				                	<div style="font-size: 1.2em; padding-bottom: 5px;"><a href="http://sakaiproject.org"><strong>sakaiproject.org</strong> </a></div>
								<?php if ($User->pk > 0) { ?>
										<div style="font-size:.95em; " >Welcome,&nbsp;<?= $User->firstname."&nbsp;".$User->lastname ?>:  &nbsp; &nbsp;
										  	<a  href="<?= $ACCOUNTS_URL ?>/<?= $ACCOUNTS_PAGE ?>">My Account</a>&nbsp; - &nbsp;
										  	
										  	<a href="<?= $ACCOUNTS_URL ?>/<?= $LOGOUT_PAGE ?>">Logout</a></div>
								  
										<?php   	 
								  				} else { ?>
									      <div class="extralinks_admin">
										  	<a href="<?= $ACCOUNTS_URL ?>/<?= $LOGIN_PAGE."?ref=".$_SERVER['PHP_SELF'] ?>">  >> Login  </a>&nbsp;&nbsp; - &nbsp;
										  	<a href="<?= $ACCOUNTS_URL ?>/createaccount.php">Create Account</a>&nbsp; - &nbsp;
				  							<a href="<?= $ACCOUNTS_URL ?>/forgot_password.php">Forgot Password</a>
				  						 </div> 
										
										<?php  }?>
							</div> 
						</td>
						</tr>
						<tr><td colspan=2>
							<?php   $active_home="";   //initialize menu class
							$active_accounts="";  
							$active_reg=""; 
							$active_prop=""; 
							$active_sched=""; 
							
						switch ($ACTIVE_MENU) {  //set the current menu class to active
							case "HOME" :  $active_home= "class='admin_home' ";   break;
							case "ACCOUNTS" :  $active_accounts= "class='admin_active' ";   break;
							case "REGISTER" :  $active_reg= "class='admin_reg' ";    break;
							case "PROPOSALS": $active_prop= "class='admin_prop' ";   break;
							case "SCHEDULE": $active_sched= "class='admin_sched' ";    break;
							
					}
					  	if ($User->pk > 0) { 
						if ($User->checkPerm("admin_accounts") || $User->checkPerm("admin_insts") ||
						  $User->checkPerm("admin_conference")  || $User->checkPerm("proposals_Dec2006") || $User->checkPerm("registration_Dec2006")){ ?>
							<div id="adminLinks"><br/>
							<div><span><a <?=$active_home ?> href="<?= $ACCOUNTS_URL ?>/index.php">Home</a></span><span class="righttab" >&nbsp;</span></div>
							
							<?php if ($User->checkPerm("admin_accounts") || $User->checkPerm("admin_insts")) { ?>
							<div><span><a <?=$active_accounts?> href="<?= $ACCOUNTS_URL ?>/admin/index.php">Accounts Admin</a></span><span class="righttab">&nbsp;</span></div>
								<?php } ?>
							<?php if ($User->checkPerm("admin_conference") || $User->checkPerm("registration_dec2006") || $User->checkPerm("admin_accounts")) { ?>
							<div><span><a <?=$active_reg?> href="<?= $CONFADMIN_URL ?>/admin/registration_admin.php">Registration Admin</a></span><span class="righttab">&nbsp;</span></div>
							<?php }   if ($User->checkPerm("admin_conference") || $User->checkPerm("proposals_dec2006") || $User->checkPerm("admin_accounts")) { ?>
					
							<div><span><a <?=$active_prop?> href="<?= $CONFADMIN_URL ?>/admin/proposals_admin.php">Proposals Admin</a></span><span class="righttab">&nbsp;</span></div>
								<?php }    ?> 
							<?php if ($User->checkPerm("admin_accounts") || $User->checkPerm("admin_insts")) { ?>
							<div><span><a <?=$active_sched?> href="<?= $CONFADMIN_URL ?>/admin/schedule_admin.php">Schedule Admin</a></span><span class="righttab">&nbsp;</span></div>
								 <?php } ?>
							</div>
							<?php } 
								 }     ?>
						</td></tr>
						</table><div id="accounts_bottom"><?= $EXTRA_LINKS ?></div>
						
						
			<?php if ($EXTRA_MESSAGE) { ?>	<div><?= $EXTRA_MESSAGE ?></div>  <?php }  ?>
		</div>
	  </td>
	</tr>
	</table>