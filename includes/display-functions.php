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

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

	<?php
	echo '<script src="' . plugin_dir_url(__FILE__) . 'js/base.js"></script>';
	echo '<script src="' . plugin_dir_url(__FILE__) . 'js/flipclock.js"></script>';
	echo '<script src="' . plugin_dir_url(__FILE__) . 'js/dailycounter.js"></script>';
	echo '<link rel="stylesheet" href="' . plugin_dir_url(__FILE__) . 'css/flipclock.css">';
	$html = '';
	?> 

	<script type="text/javascript">
		var clock;

		$(document).ready(function() {

			// Grab the current date
			var currentDate = new Date();
			var utccurrentDate = new Date(currentDate.getTime() + currentDate.getTimezoneOffset() * 60000);

			// Set some date in the future. In this case, it's always Jan 1
			var selecteddate  = new Date('<?php echo $uuc_options['cdyear'], ', ', $uuc_options['cdmonth'], ', ', $uuc_options['cdday']; ?>');

			// Calculate the difference in seconds between the future and current date
			var diff = selecteddate.getTime() / 1000 - utccurrentDate.getTime() / 1000;

			// Instantiate a coutdown FlipClock
			clock = $('.clock').FlipClock(diff, {
				clockFace: 'DailyCounter',
				countdown: true
			});
		});	
	</script>	
	<?php

	if(isset($uuc_options['cdday'])){
		$entereddate = ($uuc_options['cdyear'] . "-" . $uuc_options['cdmonth'] . "-" . $uuc_options['cdday'] . " " . "00:00:00");
		$cddates = strtotime($entereddate);
	}

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

		if($uuc_options['cdenable'] == true){

			if($uuc_options['cd_style'] == "flipclock"){
				$html .= '<div class="cddiv"><div class="clock" style="margin:2em;"></div></div>';
			}
			elseif($uuc_options['cd_style'] == "textclock"){
				if($cddates > time()){
					$htmlpart = '<h3>' . '<script src="' . plugin_dir_url(__FILE__) . 'js/countdown.js" language="JavaScript" type="text/JavaScript"></script>';
					$htmlpart .= ' ' . $uuc_options['cdtext'] . '</h3>';
				}
				else{
					$htmlpart = '<h3>' . '<script src="' . plugin_dir_url(__FILE__) . 'js/countdown.js" language="JavaScript" type="text/JavaScript"></script>'; 
					$htmlpart .= '</h3>';
				}
			}
			$html .= $htmlpart;
		}
		$html .= '</div>';
		echo $html; 
		?>
		<?php exit;
	}
}