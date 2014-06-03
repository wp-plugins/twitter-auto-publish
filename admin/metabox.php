<?php 


add_action( 'add_meta_boxes', 'xyz_twap_add_custom_box' );
function xyz_twap_add_custom_box()
{
	$posttype="";
	if(isset($_GET['post_type']))
	$posttype=$_GET['post_type'];
	
if(isset($_GET['action']) && $_GET['action']=="edit")
	{
		$postid=$_GET['post'];
		
		$postpp= get_post($postid);
		if($postpp->post_status=="publish")
			add_meta_box("xyz_twap1", ' ', 'xyz_twap_addpostmetatags1') ;
		
		$get_post_meta=get_post_meta($postid,"xyz_twap",true);
		if($get_post_meta==1)
			return ;
		global $wpdb;
		$table='posts';
		$accountCount = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.$table.' WHERE id="'.$postid.'" and post_status!="draft" LIMIT 0,1' ) ;
		if($accountCount>0)
		return ;
	}

	if($posttype=="")
		$posttype="post";

	if ($posttype=="page")
	{

		$xyz_twap_include_pages=get_option('xyz_twap_include_pages');
		if($xyz_twap_include_pages==0)
			return;
	}
	else if($posttype!="post")
	{

		$xyz_twap_include_customposttypes=get_option('xyz_twap_include_customposttypes');


		$carr=explode(',', $xyz_twap_include_customposttypes);
		if(!in_array($posttype,$carr))
			return;

	}
	
	if(get_option('xyz_twap_twconsumer_id')!="" && get_option('xyz_twap_twconsumer_secret')!="" && get_option('xyz_twap_tw_id')!="" && get_option('xyz_twap_current_twappln_token')!="" && get_option('xyz_twap_twaccestok_secret')!="")
	add_meta_box( "xyz_twap", '<strong>Twitter Auto Publish - Post Options</strong>', 'xyz_twap_addpostmetatags') ;
}
function xyz_twap_addpostmetatags1()
{
?>
<input type="hidden" name="xyz_twap_hidden_meta" value="1" >
	<script type="text/javascript">
		jQuery('#xyz_twap1').hide();
		</script>
<?php 
}
function xyz_twap_addpostmetatags()
{
	$imgpath= plugins_url()."/twitter-auto-publish/admin/images/";
	$heimg=$imgpath."support.png";
	?>
<script>
function displaycheck_twap()
{
var tcheckid=document.getElementById("xyz_twap_twpost_permission").value;
if(tcheckid==1)
{

	document.getElementById("twmf_twap").style.display='';
	document.getElementById("twmftarea_twap").style.display='';
	document.getElementById("twai_twap").style.display='';	
}
else
{
	
	document.getElementById("twmf_twap").style.display='none';
	document.getElementById("twmftarea_twap").style.display='none';
	document.getElementById("twai_twap").style.display='none';		
}


}


</script>
<script type="text/javascript">
function detdisplay_twap(id)
{
	document.getElementById(id).style.display='';
}
function dethide_twap(id)
{
	document.getElementById(id).style.display='none';
}


</script>
<table class="xyz_twap_metalist_table">
	<tr ><td colspan="2" >

<table class="xyz_twap_meta_acclist_table"><!-- TW META -->


<tr>
		<td colspan="2" class="xyz_twap_pleft15 xyz_twap_meta_acclist_table_td"><strong>Twitter</strong>
		</td>
</tr>

<tr><td colspan="2" valign="top">&nbsp;</td></tr>

	<tr valign="top">
		<td class="xyz_twap_pleft15" width="60%">Enable auto publish	posts to my twitter account
		</td>
		<td width="40%"><select id="xyz_twap_twpost_permission" name="xyz_twap_twpost_permission"
			onchange="displaycheck_twap()">
				<option value="0"
				<?php  if(get_option('xyz_twap_twpost_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_twap_twpost_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="twai_twap">
		<td class="xyz_twap_pleft15">Attach image to twitter post
		</td>
		<td><select id="xyz_twap_twpost_image_permission" name="xyz_twap_twpost_image_permission"
			onchange="displaycheck_twap()">
				<option value="0"
				<?php  if(get_option('xyz_twap_twpost_image_permission')==0) echo 'selected';?>>
					No</option>
				<option value="1"
				<?php  if(get_option('xyz_twap_twpost_image_permission')==1) echo 'selected';?>>Yes</option>
		</select>
		</td>
	</tr>
	
	<tr valign="top" id="twmf_twap">
		<td class="xyz_twap_pleft15">Message format for posting <img src="<?php echo $heimg?>"
						onmouseover="detdisplay_twap('xyz_twap')" onmouseout="dethide_twap('xyz_twap')">
						<div id="xyz_twap" class="informationdiv"
							style="display: none; font-weight: normal;">
							{POST_TITLE} - Insert the title of your post.<br />{PERMALINK} -
							Insert the URL where your post is displayed.<br />{POST_EXCERPT}
							- Insert the excerpt of your post.<br />{POST_CONTENT} - Insert
							the description of your post.<br />{BLOG_TITLE} - Insert the name
							of your blog.<br />{USER_NICENAME} - Insert the nicename
							of the author.
						</div>
		</td>
	<td>
	<select name="xyz_twap_info" id="xyz_twap_info" onchange="xyz_twap_info_insert(this)">
		<option value ="0" selected="selected">--Select--</option>
		<option value ="1">{POST_TITLE}  </option>
		<option value ="2">{PERMALINK} </option>
		<option value ="3">{POST_EXCERPT}  </option>
		<option value ="4">{POST_CONTENT}   </option>
		<option value ="5">{BLOG_TITLE}   </option>
		<option value ="6">{USER_NICENAME}   </option>
		</select> </td></tr>
		
		<tr id="twmftarea_twap"><td>&nbsp;</td><td>
		<textarea id="xyz_twap_twmessage"  name="xyz_twap_twmessage" style="height:80px !important;" ><?php echo esc_textarea(get_option('xyz_twap_twmessage'));?></textarea>
	</td></tr>
	
	</table>
	
	</td></tr>
	
	
</table>
<script type="text/javascript">
	displaycheck_twap();

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
	</script>
<?php 
}
?>