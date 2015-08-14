<?php 
?>
<div >


	<form method="post" name="xyz_smap_logs_form">
		<fieldset
			style="width: 99%; border: 1px solid #F7F7F7; padding: 10px 0px;">
			


<div style="text-align: left;padding-left: 7px;"><h3>Auto Publish Logs</h3></div>
	<span>Last five logs</span>
		   <table class="widefat" style="width: 99%; margin: 0 auto; border-bottom:none;">
				<thead>
					<tr class="xyz_smap_log_tr">
						<th scope="col" width="1%">&nbsp;</th>
						<th scope="col" width="12%">Post Id</th>
						<th scope="col" width="18%">Published On</th>
						<th scope="col" width="15%">Status</th>
					</tr>
					</thead>
					<?php 
					$post_tw_logsmain = get_option('xyz_twap_post_logs' );
					$post_tw_logsmain_array = array();
					foreach ($post_tw_logsmain as $logkey => $logval)
					{
						$post_tw_logsmain_array[]=$logval;
					}
					
					if($post_tw_logsmain=='')
					{
						?>
						<tr><td colspan="4" style="padding: 5px;">No logs Found</td></tr>
						<?php
					}
					
					if(is_array($post_tw_logsmain_array))
					{
						for($i=4;$i>=0;$i--)
						{
							if($post_tw_logsmain_array[$i]!='')
							{
								$post_tw_logs=$post_tw_logsmain_array[$i];
								$postid=$post_tw_logs['postid'];
								$publishtime=$post_tw_logs['publishtime'];
								if($publishtime!="")
									$publishtime=xyz_twap_local_date_time('Y/m/d g:i:s A',$publishtime);
								$status=$post_tw_logs['status'];
		
								?>
								<tr>	
									<td>&nbsp;</td>
									<td  style="vertical-align: middle !important;">
									<?php echo get_the_title($postid);	?>
									</td>
									
									<td style="vertical-align: middle !important;">
									<?php echo $publishtime;?>
									</td>
									
									<td style="vertical-align: middle !important;">
									<?php
									
									
									if($status=="1")
									echo "<span style=\"color:green\">Success</span>";
									else if($status=="0")
									echo '';
									else
									{
										$arrval=unserialize($status);
										foreach ($arrval as $a=>$b)
										echo "<span style=\"color:red\">".$a." : ".$b."</span><br>";
									}
									?>
									</td>
								</tr>
								<?php  
							}
						}
					}
					?>
				
           </table>
			
		</fieldset>

	</form>

</div>
				