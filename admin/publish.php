<?php 

add_action('publish_post', 'xyz_twap_link_publish');
add_action('publish_page', 'xyz_twap_link_publish');



$xyz_twap_include_customposttypes=get_option('xyz_twap_include_customposttypes');
$carr=explode(',', $xyz_twap_include_customposttypes);
foreach ($carr  as $cstyps ) {
	add_action('publish_'.$cstyps, 'xyz_twap_link_publish');

}

function xyz_twap_link_publish($post_ID) {
	
	if(isset($_POST['xyz_twap_hidden_meta']) && $_POST['xyz_twap_hidden_meta']==1)
		return ;
	
	$get_post_meta=get_post_meta($post_ID,"xyz_twap",true);
	if($get_post_meta!=1)
		add_post_meta($post_ID, "xyz_twap", "1");
	else 
		return;
	global $current_user;
	get_currentuserinfo();
	$af=get_option('xyz_twap_af');
	
	
/////////////twitter//////////
	$tappid=get_option('xyz_twap_twconsumer_id');
	$tappsecret=get_option('xyz_twap_twconsumer_secret');
	$twid=get_option('xyz_twap_tw_id');
	$taccess_token=get_option('xyz_twap_current_twappln_token');
	$taccess_token_secret=get_option('xyz_twap_twaccestok_secret');
	$messagetopost=get_option('xyz_twap_twmessage');
	if(isset($_POST['xyz_twap_twmessage']))
		$messagetopost=$_POST['xyz_twap_twmessage'];

	$post_twitter_permission=get_option('xyz_twap_twpost_permission');
	if(isset($_POST['xyz_twap_twpost_permission']))
		$post_twitter_permission=$_POST['xyz_twap_twpost_permission'];

	$post_twitter_image_permission=get_option('xyz_twap_twpost_image_permission');
	if(isset($_POST['xyz_twap_twpost_image_permission']))
		$post_twitter_image_permission=$_POST['xyz_twap_twpost_image_permission'];

	
	$postpp= get_post($post_ID);global $wpdb;
	$entries0 = $wpdb->get_results( 'SELECT user_nicename FROM '.$wpdb->prefix.'users WHERE ID='.$postpp->post_author);
	foreach( $entries0 as $entry ) {			
		$user_nicename=$entry->user_nicename;}
	
	if ($postpp->post_status == 'publish')
	{
		$posttype=$postpp->post_type;
		$ln_publish_status=array();
		
		if ($posttype=="page")
		{

			$xyz_twap_include_pages=get_option('xyz_twap_include_pages');
			if($xyz_twap_include_pages==0)
				return;
		}
			
		if($posttype=="post")
		{
			$xyz_twap_include_categories=get_option('xyz_twap_include_categories');
			if($xyz_twap_include_categories!="All")
			{
				$carr1=explode(',', $xyz_twap_include_categories);
					
				$defaults = array('fields' => 'ids');
				$carr2=wp_get_post_categories( $post_ID, $defaults );
				$retflag=1;
				foreach ($carr2 as $key=>$catg_ids)
				{
					if(in_array($catg_ids, $carr1))
						$retflag=0;
				}
					
					
				if($retflag==1)
					return;
			}
		}


		$pluginName = 'bitly/bitly.php';
		
		if (is_plugin_active($pluginName)) {
			remove_all_filters('post_link');
		}
		$link = get_permalink($postpp->ID);



		$content = $postpp->post_content;apply_filters('the_content', $content);

		$excerpt = $postpp->post_excerpt;apply_filters('the_excerpt', $excerpt);
		if($excerpt=="")
		{
			if($content!="")
			{
				$content1=$content;
				$content1=strip_tags($content1);
				$content1=strip_shortcodes($content1);
				
				$excerpt=implode(' ', array_slice(explode(' ', $content1), 0, 50));
			}
		}
		else
		{
			$excerpt=strip_tags($excerpt);
			$excerpt=strip_shortcodes($excerpt);
		}
		$description = $content;
		
		$description_org=$description;
		$attachmenturl=xyz_twap_getimage($post_ID, $postpp->post_content);
		if($attachmenturl!="")
			$image_found=1;
		else
			$image_found=0;
		

		$name = html_entity_decode(get_the_title($postpp->ID), ENT_QUOTES, get_bloginfo('charset'));
		$caption = html_entity_decode(get_bloginfo('title'), ENT_QUOTES, get_bloginfo('charset'));
		apply_filters('the_title', $name);

		$name=strip_tags($name);
		$name=strip_shortcodes($name);
		
		$description=strip_tags($description);		
		$description=strip_shortcodes($description);

		$description=str_replace("&nbsp;","",$description);
	
		$excerpt=str_replace("&nbsp;","",$excerpt);


		if($taccess_token!="" && $taccess_token_secret!="" && $tappid!="" && $tappsecret!="" && $post_twitter_permission==1)
		{
			
			////image up start///

			$img_status="";
			if($post_twitter_image_permission==1)
			{
				
				
				$img=array();
				if($attachmenturl!="")
					$img = wp_remote_get($attachmenturl);
					
				if(is_array($img))
				{
					if (isset($img['body'])&& trim($img['body'])!='')
					{
						$image_found = 1;
							if (($img['headers']['content-length']) && trim($img['headers']['content-length'])!='')
							{
								$img_size=$img['headers']['content-length']/(1024*1024);
								if($img_size>3){$image_found=0;$img_status="Image skipped(greater than 3MB)";}
							}
							
						$img = $img['body'];
					
					}
					else
						$image_found = 0;
				}
					
			}
			///Twitter upload image end/////
				
			$messagetopost=str_replace("&nbsp;","",$messagetopost);
			
			preg_match_all("/{(.+?)}/i",$messagetopost,$matches);
			$matches1=$matches[1];$substring="";$islink=0;$issubstr=0;
			$len=118;
			if($image_found==1)
				$len=$len-24;

			foreach ($matches1 as $key=>$val)
			{
				$val="{".$val."}";
				if($val=="{POST_TITLE}")
				{$replace=$name;}
				if($val=="{POST_CONTENT}")
				{$replace=$description;}
				if($val=="{PERMALINK}")
				{
					$replace="{PERMALINK}";$islink=1;
				}
				if($val=="{POST_EXCERPT}")
				{$replace=$excerpt;}
				if($val=="{BLOG_TITLE}")
					$replace=$caption;
					
				if($val=="{USER_NICENAME}")
						$replace=$user_nicename;



				$append=mb_substr($messagetopost, 0,mb_strpos($messagetopost, $val));

				if(mb_strlen($append)<($len-mb_strlen($substring)))
				{
					$substring.=$append;
				}
				else if($issubstr==0)
				{
					$avl=$len-mb_strlen($substring)-4;
					if($avl>0)
						$substring.=mb_substr($append, 0,$avl)."...";
						
					$issubstr=1;

				}



				if($replace=="{PERMALINK}")
				{
					$chkstr=mb_substr($substring,0,-1);
					if($chkstr!=" ")
					{$substring.=" ".$replace;$len=$len+12;}
					else
					{$substring.=$replace;$len=$len+11;}
				}
				else
				{
						
					if(mb_strlen($replace)<($len-mb_strlen($substring)))
					{
						$substring.=$replace;
					}
					else if($issubstr==0)
					{
							
						$avl=$len-mb_strlen($substring)-4;
						if($avl>0)
							$substring.=mb_substr($replace, 0,$avl)."...";
							
						$issubstr=1;

					}


				}
				$messagetopost=mb_substr($messagetopost, mb_strpos($messagetopost, $val)+strlen($val));
					
			}

			if($islink==1)
				$substring=str_replace('{PERMALINK}', $link, $substring);
				
				
			$twobj = new TWAPTwitterOAuth(array( 'consumer_key' => $tappid, 'consumer_secret' => $tappsecret, 'user_token' => $taccess_token, 'user_secret' => $taccess_token_secret,'curl_ssl_verifypeer'   => false));
				
			if($image_found==1 && $post_twitter_image_permission==1)
			{
				$resultfrtw = $twobj -> request('POST', 'https://api.twitter.com/1.1/statuses/update_with_media.json', array( 'media[]' => $img, 'status' => $substring), true, true);
				
				if($resultfrtw!=200){
					if($twobj->response['response']!="")
						$tw_publish_status["statuses/update_with_media"]=print_r($twobj->response['response'], true);
					else
						$tw_publish_status["statuses/update_with_media"]=$resultfrtw;
				}
				
			}
			else
			{
				$resultfrtw = $twobj->request('POST', $twobj->url('1.1/statuses/update'), array('status' =>$substring));
				
				if($resultfrtw!=200){
					if($twobj->response['response']!="")
						$tw_publish_status["statuses/update"]=print_r($twobj->response['response'], true);
					else
						$tw_publish_status["statuses/update"]=$resultfrtw;
				}
				else if($img_status!="")
					$tw_publish_status["statuses/update_with_media"]=$img_status;
			}
			if(count($tw_publish_status)>0)
				$tw_publish_status_insert=serialize($tw_publish_status);
			else
				$tw_publish_status_insert=1;
			
			$time=time();
			$post_tw_options=array(
					'postid'	=>	$post_ID,
					'acc_type'	=>	"Twitter",
					'publishtime'	=>	$time,
					'status'	=>	$tw_publish_status_insert
			);
			update_option('xyz_twap_post_logs', $post_tw_options);
		}
		
	}
	

}

?>