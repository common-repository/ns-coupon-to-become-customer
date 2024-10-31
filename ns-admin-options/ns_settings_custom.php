<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php // PUT YOUR settings_fields name and your input // ?>
<div class="genRowNssdc">
		

	<!-- checked="checked" -->
	<?php
		$ns_privacy_policy = get_option('ns-ctbc-enable-privacy-policy');
		$ns_coupon_name = get_option('ns-ctbc-coupon-name');
		$ns_popup_title = get_option('ns-ctbc-popup-title');
		$ns_popup_subtitle = get_option('ns-ctbc-popup-subtitle');
		$ns_popup_privacy_policy = get_option('ns-ctbc-popup-privacy-policy');

		$checked = '';
		if($ns_privacy_policy == 'on'){
			$checked = 'checked="checked"';
		}
		
	?>
	<div class="ns-ctbc-section-container">
		
		<label><?php _e('Coupon Name', $ns_text_domain) ?></label>
		<input type="text" name="ns-ctbc-coupon-name" id="ns-ctbc-coupon-name" class="ns-ctbc-input" value="<?php echo $ns_coupon_name; ?>"><br>
		
		<label><?php _e('PopUp Title', $ns_text_domain) ?></label>
		<input type="text" name="ns-ctbc-popup-title" id="ns-ctbc-popup-title" class="ns-ctbc-input" value="<?php echo $ns_popup_title; ?>"><br>

		<label><?php _e('PopUp Subtitle', $ns_text_domain) ?></label>
		<input type="text" name="ns-ctbc-popup-subtitle" id="ns-ctbc-popup-subtitle" class="ns-ctbc-input" value="<?php echo $ns_popup_subtitle; ?>"><br>
	

		<div class="ns-enable-privacy-div">
			
			<label class="ns-ctbc-container"><input class="ns-ctbc-checkbox" type="checkbox" name="ns-ctbc-enable-privacy-policy" id="ns-ctbc-checkbox" <?php echo $checked; ?>><span class="ns-ctbc-checkmark"></span></label>
			<label><?php _e('Enable Privacy Policy', $ns_text_domain) ?></label>
			<br><br>
			<div id="ns-show-if-checked" <?php if(get_option('ns-ctbc-enable-privacy-policy')!='on') echo 'style="display: none";';?>>
				<label><?php _e('URL Privacy Policy', $ns_text_domain) ?></label>
				<input type="text" name="ns-ctbc-popup-privacy-policy" id="ns-ctbc-popup-privacy-policy" class="ns-ctbc-input" value="<?php echo $ns_popup_privacy_policy; ?>"><br>
			</div>
		</div>
	</div>

</div>

<?php settings_fields('ns_ctbc_options_group'); ?>
