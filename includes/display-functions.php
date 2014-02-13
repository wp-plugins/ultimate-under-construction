<?php

/* display functions for outputting data */

add_filter('get_header', 'uuc_add_content');

function uuc_add_content() {

	global $uuc_options;

	?>
	<script language="JavaScript">
	TargetDate = "<?php echo $uuc_options['cdmonth'], '/', $uuc_options['cdday'], '/', $uuc_options['cdyear']; ?>";
	CountActive = true;
	CountStepper = -1;
	LeadingZero = true;
	DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds ";
	FinishMessage = "It is finally here!";
	</script>
	<?php

	if(!is_admin() && !is_user_logged_in() && $uuc_options['enable'] == true && $uuc_options['holdingpage_type'] == "htmlblock"){
		
		$html .= '<div class="uuc-holdingpage">';
		if(isset($uuc_options['html_block'])) {
			$html .= $uuc_options['html_block'];
		}
		$html .= '</div>';
		echo $html; exit;
	}
	elseif(!is_admin() && !is_user_logged_in() && $uuc_options['enable'] == true){
		
		if (isset($uuc_options['background_style']) && $uuc_options['background_style'] == "solidcolor") {
			if (isset($uuc_options['background_color'])) {?>
				<style type="text/css">
					body { background-color: <?php echo $uuc_options['background_color']; ?> }
					.uuc-holdingpage { text-align: center; padding-top: 250px; }
				</style>
			<?php }
		} else if (isset($uuc_options['background_style']) && $uuc_options['background_style'] == "patterned") {
			if (!isset($uuc_options['background_styling'])) {?>
				<style type="text/css">
					body { background: url(<?php echo plugin_dir_url(__FILE__) . '/images/oldmaths.png' ?>); }
					.uuc-holdingpage { text-align: center; padding-top: 250px; }
				</style>
			<?php } elseif (isset($uuc_options['background_styling'])) {
				if ($uuc_options['background_styling'] == "darkbind") {?>	
				<style type="text/css">
					body { background: url(<?php echo plugin_dir_url(__FILE__) . 'images/' . $uuc_options['background_styling'].'.png' ?>); }
					.uuc-holdingpage { text-align: center; color: #909090; padding-top: 250px; }
				</style>
				<?php } else { ?>			
				<style type="text/css">
					body { background: url(<?php echo plugin_dir_url(__FILE__) . 'images/' . $uuc_options['background_styling'].'.png' ?>); }
					.uuc-holdingpage { text-align: center; padding-top: 250px; }
				</style>
				<?php }
			}
		}

		$html .= '<div class="uuc-holdingpage">';
		$html .= '<h1>' . $uuc_options['website_name'] . '</h1>';
		if(isset($uuc_options['holding_message'])) {
			$html .= '<h2>' . $uuc_options['holding_message'] . '</h2>';
		}
		if(isset($uuc_options['cdmonth'])) {
		$html .= '<h3>' . '<script src="http://www.morrowmedia.co.uk/scripts/countdown.js" language="JavaScript" type="text/JavaScript"></script>' . ' ' . $uuc_options['cdtext'] . '<h3>';
		}
		$html .= '</div>';
		echo $html; 
		?> 
		<span id="countdown"></span>
		<?php exit;
	}
}