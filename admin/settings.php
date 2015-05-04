<?php

global $current_user;
$auth_varble=0;
get_currentuserinfo();
$imgpath= plugins_url()."/twitter-auto-publish/admin/images/";
$heimg=$imgpath."support.png";

$tms1="";
$tms2="";
$tms3="";
$tms4="";
$tms5="";
$tms6="";

$terf=0;
if(isset($_POST['twit']))
{

	$tappid=$_POST['xyz_twap_twconsumer_id'];
	$tappsecret=$_POST['xyz_twap_twconsumer_secret'];
	$twid=$_POST['xyz_twap_tw_id'];
	$taccess_token=$_POST['xyz_twap_current_twappln_token'];
	$taccess_token_secret=$_POST['xyz_twap_twaccestok_secret'];
	$tposting_permission=$_POST['xyz_twap_twpost_permission'];
	$tposting_image_permission=$_POST['xyz_twap_twpost_image_permission'];
	$tmessagetopost=$_POST['xyz_twap_twmessage'];
	if($tappid=="" && $tposting_permission==1)
	{
		$terf=1;
		$tms1="Please fill api key.";

	}
	elseif($tappsecret=="" && $tposting_permission==1)
	{
		$tms2="Please fill api secret.";
		$terf=1;
	}
	elseif($twid=="" && $tposting_permission==1)
	{
		$tms3="Please fill twitter username.";
		$terf=1;
	}
	elseif($taccess_token=="" && $tposting_permission==1)
	{
		$tms4="Please fill twitter access token.";
		$terf=1;
	}
	elseif($taccess_token_secret=="" && $tposting_permission==1)
	{
		$tms5="Please fill twitter access token secret.";
		$terf=1;
	}
	elseif($tmessagetopost=="" && $tposting_permission==1)
	{
		$tms6="Please fill mssage format for posting.";
		$terf=1;
	}
	else
	{
		$terf=0;
		if($tmessagetopost=="")
		{
			$tmessagetopost="{POST_TITLE}-{PERMALINK}";
		}

		update_option('xyz_twap_twconsumer_id',$tappid);
		update_option('xyz_twap_twconsumer_secret',$tappsecret);
		update_option('xyz_twap_tw_id',$twid);
		update_option('xyz_twap_current_twappln_token',$taccess_token);
		update_option('xyz_twap_twaccestok_secret',$taccess_token_secret);
		update_option('xyz_twap_twmessage',$tmessagetopost);
		update_option('xyz_twap_twpost_permission',$tposting_permission);
		update_option('xyz_twap_twpost_image_permission',$tposting_image_permission);
		
	}
}



if(isset($_POST['twit']) && $terf==0)
{
	?>

<div class="system_notice_area_style1" id="system_notice_area">
	Settings updated successfully. &nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php }
if(isset($_POST['twit']) && $terf==1)
{
	?>
<div class="system_notice_area_style0" id="system_notice_area">
	<?php 
	if(isset($_POST['twit']))
	{
		echo $tms1;echo $tms2;echo $tms3;echo $tms4;echo $tms5;echo $tms6;
	}
	?>
	&nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php } ?>
<script type="text/javascript">
function detdisplay(id)
{
	document.getElementById(id).style.display='';
}
function dethide(id)
{
	document.getElementById(id).style.display='none';
}


</script>

<div style="width: 100%">

	<h2>
		 <img	src="<?php echo plugins_url()?>/twitter-auto-publish/admin/images/twitter-logo.png" height="16px"> Twitter Settings
	</h2>
	
<table class="widefat" style="width: 99%;background-color: #FFFBCC">
<tr>
<td id="bottomBorderNone">
	<div>
		<b>Note :</b> You have to create a Twitter application before filling in following fields. 	
		<br><b><a href="https://dev.twitter.com/apps/new" target="_blank">Click here</a></b> to create new application. Specify the website for the application as :	<span style="color: red;"><?php echo  (is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST']; ?>		 </span> 
		 <br>In the twitter application, navigate to	<b>Settings > Application Type > Access</b>. Select <b>Read and Write</b> option. 
		 <br>After updating access, navigate to <b>Details > Your access token</b> in the application and	click <b>Create my access token</b> button.
		<br>For detailed step by step instructions <b><a href="http://docs.xyzscripts.com/wordpress-plugins/twitter-auto-publish/creating-twitter-application/" target="_blank">Click here</a></b>.

	</div>
</td>
</tr>
</table>


	<form method="post">
		<input type="hidden" value="config">



			<div style="font-weight: bold;padding: 3px;">All fields given below are mandatory</div> 
			<table class="widefat xyz_twap_widefat_table" style="width: 99%">
				<tr valign="top">
					<td width="50%">API key
					</td>
					<td><input id="xyz_twap_twconsumer_id"
						name="xyz_twap_twconsumer_id" type="text"
						value="<?php if($tms1=="") {echo esc_html(get_option('xyz_twap_twconsumer_id'));}?>" />
						<a href="http://docs.xyzscripts.com/wordpress-plugins/social-media-auto-publish/creating-twitter-application" target="_blank">How can I create a Twitter Application?</a>
					</td>
				</tr>

				<tr valign="top">
					<td>API secret
					</td>
					<td><input id="xyz_twap_twconsumer_secret"
						name="xyz_twap_twconsumer_secret" type="text"
						value="<?php if($tms2=="") { echo esc_html(get_option('xyz_twap_twconsumer_secret')); }?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Twitter username
					</td>
					<td><input id="xyz_twap_tw_id" class="al2tw_text"
						name="xyz_twap_tw_id" type="text"
						value="<?php if($tms3=="") {echo esc_html(get_option('xyz_twap_tw_id'));}?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Access token
					</td>
					<td><input id="xyz_twap_current_twappln_token" class="al2tw_text"
						name="xyz_twap_current_twappln_token" type="text"
						value="<?php if($tms4=="") {echo esc_html(get_option('xyz_twap_current_twappln_token'));}?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Access	token secret
					</td>
					<td><input id="xyz_twap_twaccestok_secret" class="al2tw_text"
						name="xyz_twap_twaccestok_secret" type="text"
						value="<?php if($tms5=="") {echo esc_html(get_option('xyz_twap_twaccestok_secret'));}?>" />
					</td>
				</tr>
				<tr valign="top">
					<td>Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay('xyz_tw')" onmouseout="dethide('xyz_tw')">
						<div id="xyz_tw" class="informationdiv"
							style="display: none; font-weight: normal;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.<br />{USER_NICENAME} - Insert the nicename
							of the author.
						</div></td>
	<td>
	<select name="xyz_twap_info" id="xyz_twap_info" onchange="xyz_twap_info_insert(this)">
		<option value ="0" selected="selected">--Select--</option>
		<option value ="1">{POST_TITLE}  </option>
		<option value ="2">{PERMALINK} </option>
		<option value ="3">{POST_EXCERPT}  </option>
		<option value ="4">{POST_CONTENT}   </option>
		<option value ="5">{BLOG_TITLE}   </option>
		<option value ="6">{USER_NICENAME}   </option>
		</select> </td></tr><tr><td>&nbsp;</td><td>
		<textarea id="xyz_twap_twmessage"  name="xyz_twap_twmessage" style="height:80px !important;" ><?php if($tms6=="") {
								echo esc_textarea(get_option('xyz_twap_twmessage'));}?></textarea>
	</td></tr>
						
				
				<tr valign="top">
					<td>Attach image to twitter post
					</td>
					<td><select id="xyz_twap_twpost_image_permission"
						name="xyz_twap_twpost_image_permission">
							<option value="0"
							<?php  if(get_option('xyz_twap_twpost_image_permission')==0) echo 'selected';?>>
								No</option>
							<option value="1"
							<?php  if(get_option('xyz_twap_twpost_image_permission')==1) echo 'selected';?>>Yes</option>
					</select>
					</td>
				</tr>
				
				<tr valign="top">
					<td>Enable auto publish	posts to my twitter account
					</td>
					<td><select id="xyz_twap_twpost_permission"
						name="xyz_twap_twpost_permission">
							<option value="0"
							<?php  if(get_option('xyz_twap_twpost_permission')==0) echo 'selected';?>>
								No</option>
							<option value="1"
							<?php  if(get_option('xyz_twap_twpost_permission')==1) echo 'selected';?>>Yes</option>
					</select>
					</td>
				</tr>

				


				<tr>
			<td   id="bottomBorderNone"></td>
					<td   id="bottomBorderNone"><div style="height: 50px;">
							<input type="submit" class="submit_twap_new"
								style=" margin-top: 10px; "
								name="twit" value="Save" /></div>
					</td>
				</tr>
			</table>

	</form>

<?php 

	if(isset($_POST['bsettngs']))
	{

		$xyz_twap_include_pages=$_POST['xyz_twap_include_pages'];
		$xyz_twap_include_posts=$_POST['xyz_twap_include_posts'];

		if($_POST['xyz_twap_cat_all']=="All")
			$twap_category_ids=$_POST['xyz_twap_cat_all'];//redio btn name
		else
			$twap_category_ids=$_POST['xyz_twap_sel_cat'];//dropdown

		$xyz_customtypes="";
		
        if(isset($_POST['post_types']))
		$xyz_customtypes=$_POST['post_types'];

        $xyz_twap_peer_verification=$_POST['xyz_twap_peer_verification'];
        $xyz_twap_premium_version_ads=$_POST['xyz_twap_premium_version_ads'];
        $xyz_twap_default_selection_edit=$_POST['xyz_twap_default_selection_edit'];
        
		$twap_customtype_ids="";

		if($xyz_customtypes!="")
		{
			for($i=0;$i<count($xyz_customtypes);$i++)
			{
				$twap_customtype_ids.=$xyz_customtypes[$i].",";
			}

		}
		$twap_customtype_ids=rtrim($twap_customtype_ids,',');


		update_option('xyz_twap_include_pages',$xyz_twap_include_pages);
		update_option('xyz_twap_include_posts',$xyz_twap_include_posts);
		if($xyz_twap_include_posts==0)
			update_option('xyz_twap_include_categories',"All");
		else
			update_option('xyz_twap_include_categories',$twap_category_ids);
		update_option('xyz_twap_include_customposttypes',$twap_customtype_ids);
		update_option('xyz_twap_peer_verification',$xyz_twap_peer_verification);
		update_option('xyz_twap_premium_version_ads',$xyz_twap_premium_version_ads);
		update_option('xyz_twap_default_selection_edit',$xyz_twap_default_selection_edit);
	}

	$xyz_credit_link=get_option('xyz_credit_link');
	$xyz_twap_include_pages=get_option('xyz_twap_include_pages');
	$xyz_twap_include_posts=get_option('xyz_twap_include_posts');
	$xyz_twap_include_categories=get_option('xyz_twap_include_categories');
	$xyz_twap_include_customposttypes=get_option('xyz_twap_include_customposttypes');
	$xyz_twap_peer_verification=esc_html(get_option('xyz_twap_peer_verification'));
	$xyz_twap_premium_version_ads=esc_html(get_option('xyz_twap_premium_version_ads'));
	$xyz_twap_default_selection_edit=esc_html(get_option('xyz_twap_default_selection_edit'));
	?>
		<h2>Basic Settings</h2>


		<form method="post">

			<table class="widefat xyz_twap_widefat_table" style="width: 99%">

				<tr valign="top">

					<td  colspan="1" width="50%">Publish wordpress `pages` to twitter
					</td>
					<td><select name="xyz_twap_include_pages">

							<option value="1"
							<?php if($xyz_twap_include_pages=='1') echo 'selected'; ?>>Yes</option>

							<option value="0"
							<?php if($xyz_twap_include_pages!='1') echo 'selected'; ?>>No</option>
					</select>
					</td>
				</tr>
				
				<tr valign="top">

					<td  colspan="1">Publish wordpress `posts` to twitter
					</td>
					<td><select name="xyz_twap_include_posts" onchange="xyz_twap_show_postCategory(this.value);">

							<option value="1"
							<?php if($xyz_twap_include_posts=='1') echo 'selected'; ?>>Yes</option>

							<option value="0"
							<?php if($xyz_twap_include_posts!='1') echo 'selected'; ?>>No</option>
					</select>
					</td>
				</tr>
				
				<tr valign="top" id="selPostCat">

					<td  colspan="1">Select post categories for auto publish
					</td>
					<td><input type="hidden"
						value="<?php echo $xyz_twap_include_categories;?>"
						name="xyz_twap_sel_cat" id="xyz_twap_sel_cat"> <input type="radio"
						name="xyz_twap_cat_all" id="xyz_twap_cat_all" value="All"
						onchange="rd_cat_chn(1,-1)"
						<?php if($xyz_twap_include_categories=="All") echo "checked"?>>All<font
						style="padding-left: 10px;"></font><input type="radio"
						name="xyz_twap_cat_all" id="xyz_twap_cat_all" value=""
						onchange="rd_cat_chn(1,1)"
						<?php if($xyz_twap_include_categories!="All") echo "checked"?>>Specific

						<span id="cat_dropdown_span"><br /> <br /> <?php 


						$args = array(
								'show_option_all'    => '',
								'show_option_none'   => '',
								'orderby'            => 'name',
								'order'              => 'ASC',
								'show_last_update'   => 0,
								'show_count'         => 0,
								'hide_empty'         => 0,
								'child_of'           => 0,
								'exclude'            => '',
								'echo'               => 0,
								'selected'           => '1 3',
								'hierarchical'       => 1,
								'id'                 => 'xyz_twap_catlist',
								'class'              => 'postform',
								'depth'              => 0,
								'tab_index'          => 0,
								'taxonomy'           => 'category',
								'hide_if_empty'      => false );

						if(count(get_categories($args))>0)
						{
							$args['name']='xyz_twap_catlist';
							echo str_replace( "<select", "<select multiple onClick=setcat(this) style='width:200px;height:auto !important;border:1px solid #cccccc;'", wp_dropdown_categories($args));
						}
						else
							echo "NIL";

						?><br /> <br /> </span>
					</td>
				</tr>


				<tr valign="top">

					<td  colspan="1">Select wordpress custom post types for auto publish</td>
					<td><?php 

					$args=array(
							'public'   => true,
							'_builtin' => false
					);
					$output = 'names'; // names or objects, note names is the default
					$operator = 'and'; // 'and' or 'or'
					$post_types=get_post_types($args,$output,$operator);

					$ar1=explode(",",$xyz_twap_include_customposttypes);
					$cnt=count($post_types);
					foreach ($post_types  as $post_type ) {

						echo '<input type="checkbox" name="post_types[]" value="'.$post_type.'" ';
						if(in_array($post_type, $ar1))
						{
							echo 'checked="checked"/>';
						}
						else
							echo '/>';

						echo $post_type.'<br/>';

					}
					if($cnt==0)
						echo 'NA';
					?>
					</td>
				</tr>
				<tr valign="top">

					<td scope="row" colspan="1" width="50%">Default selection of auto publish while editing posts/pages	
					</td><td><select name="xyz_twap_default_selection_edit" >
					
					<option value ="1" <?php if($xyz_twap_default_selection_edit=='1') echo 'selected'; ?> >Yes </option>
					
					<option value ="0" <?php if($xyz_twap_default_selection_edit=='0') echo 'selected'; ?> >No </option>
					</select> 
					</td>
				</tr>

				<tr valign="top">
				
				<td scope="row" colspan="1" width="50%">SSL peer verification	</td><td><select name="xyz_twap_peer_verification" >
				
				<option value ="1" <?php if($xyz_twap_peer_verification=='1') echo 'selected'; ?> >Enable </option>
				
				<option value ="0" <?php if($xyz_twap_peer_verification=='0') echo 'selected'; ?> >Disable </option>
				</select> 
				</td></tr>
				

				<tr valign="top">

					<td  colspan="1">Enable credit link to author
					</td>
					<td><select name="xyz_credit_link" id="xyz_twap_credit_link">

							<option value="twap"
							<?php if($xyz_credit_link=='twap') echo 'selected'; ?>>Yes</option>

							<option
								value="<?php echo $xyz_credit_link!='twap'?$xyz_credit_link:0;?>"
								<?php if($xyz_credit_link!='twap') echo 'selected'; ?>>No</option>
					</select>
					</td>
				</tr>

				
				

				<tr valign="top">

					<td  colspan="1">Enable premium version ads
					</td>
					<td><select name="xyz_twap_premium_version_ads" id="xyz_twap_premium_version_ads">

							<option value="1"
							<?php if($xyz_twap_premium_version_ads=='1') echo 'selected'; ?>>Yes</option>

							<option
								value="0"
								<?php if($xyz_twap_premium_version_ads=='0') echo 'selected'; ?>>No</option>
					</select>
					</td>
				</tr>

				
				<tr>

					<td id="bottomBorderNone">
							

					</td>

					
<td id="bottomBorderNone"><div style="height: 50px;">
<input type="submit" class="submit_twap_new" style="margin-top: 10px;"	value=" Update Settings" name="bsettngs" /></div></td>
				</tr>


			</table>
		</form>
		
		
</div>		

	<script type="text/javascript">
	//drpdisplay();
var catval='<?php echo $xyz_twap_include_categories; ?>';
var custtypeval='<?php echo $xyz_twap_include_customposttypes; ?>';
var get_opt_cats='<?php echo get_option('xyz_twap_include_posts');?>';
jQuery(document).ready(function() {
	  if(catval=="All")
		  jQuery("#cat_dropdown_span").hide();
	  else
		  jQuery("#cat_dropdown_span").show();

	  if(get_opt_cats==0)
		  jQuery('#selPostCat').hide();
	  else
		  jQuery('#selPostCat').show();
			  
	}); 
	
function setcat(obj)
{
var sel_str="";
for(k=0;k<obj.options.length;k++)
{
if(obj.options[k].selected)
sel_str+=obj.options[k].value+",";
}


var l = sel_str.length; 
var lastChar = sel_str.substring(l-1, l); 
if (lastChar == ",") { 
	sel_str = sel_str.substring(0, l-1);
}

document.getElementById('xyz_twap_sel_cat').value=sel_str;

}

var d1='<?php echo $xyz_twap_include_categories;?>';
splitText = d1.split(",");
jQuery.each(splitText, function(k,v) {
jQuery("#xyz_twap_catlist").children("option[value="+v+"]").attr("selected","selected");
});

function rd_cat_chn(val,act)
{
	if(val==1)
	{
		if(act==-1)
		  jQuery("#cat_dropdown_span").hide();
		else
		  jQuery("#cat_dropdown_span").show();
	}
	
}

function xyz_twap_info_insert(inf){
	
    var e = document.getElementById("xyz_twap_info");
    var ins_opt = e.options[e.selectedIndex].text;
    if(ins_opt=="0")
    	ins_opt="";
    var str=jQuery("textarea#xyz_twap_twmessage").val()+ins_opt;
    jQuery("textarea#xyz_twap_twmessage").val(str);
    jQuery('#xyz_twap_info :eq(0)').prop('selected', true);
    jQuery("textarea#xyz_twap_twmessage").focus();

}
function xyz_twap_show_postCategory(val)
{
	if(val==0)
		jQuery('#selPostCat').hide();
	else
		jQuery('#selPostCat').show();
}
</script>
	<?php 
?>