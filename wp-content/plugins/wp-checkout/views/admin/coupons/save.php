<div class="wrap">
	<h2><?php _e('Save a Coupon', $this -> plugin_name); ?></h2>
	
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post">
		<?php echo $wpcoForm -> hidden('Coupon.id'); ?>
	
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Coupon.title"><?php _e('Title', $this -> plugin_name); ?></label></th>
					<td><?php echo $wpcoForm -> text('Coupon.title'); ?></td>
				</tr>
				<tr>
					<th><label for="Coupon.code"><?php _e('Code', $this -> plugin_name); ?></label></th>
					<td>
						<span id="couponcodecol"><?php $this -> render('coupons/save-code'); ?></span>
						<span id="couponcodelink"><a href="javascript:wpco_gencouponcode();" title="<?php _e('Generate a Coupon Code', $this -> plugin_name); ?>"><?php _e('Generate Code', $this -> plugin_name); ?></a></span>
						<span id="couponcodeloading" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" /> <?php _e('Generating...', $this -> plugin_name); ?></span>
						<span class="howto"><?php _e('code entered by users to apply coupon', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><?php _e('Discount Type', $this -> plugin_name); ?></th>
					<td>
						<?php $types = array('fixed' => __('Fixed Amount', $this -> plugin_name), 'percentage' => __('Percentage', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Coupon.discount_type', $types, array('separator' => false, 'onclick' => "cp_signs(this.value);")); ?>
						
						<script type="text/javascript">
						function cp_signs(type) {						
							jQuery("[id$=sign]").hide();
							jQuery("#" + type + "_sign").show();
						}
						</script>
					</td>
				</tr>
				<tr>
					<th><label for="Coupon.discount"><?php _e('Discount Value', $this -> plugin_name); ?></label></th>
					<td>
						<span id="fixed_sign" style="display:<?php echo ($wpcoHtml -> field_value('Coupon.discount_type') == "fixed") ? 'inline' : 'none'; ?>;"><?php echo $wpcoHtml -> currency(); ?></span>
						<span id="percentage_sign" style="display:<?php echo ($wpcoHtml -> field_value('Coupon.discount_type') == "percentage") ? 'inline' : 'none'; ?>;">&#37;</span>
						<?php echo $wpcoForm -> text('Coupon.discount', array('width' => '45px')); ?>
					</td>
				</tr>
				<tr>
					<th><label for="expiry"><?php _e('Expiry Date', $this -> plugin_name); ?></label></th>
					<td>
						<?php /*<?php echo $wpcoForm -> text('Coupon.expiry', array('width' => '85px')); ?>*/ ?>
                        <input type="text" id="expiry" class="widefat" style="width:85px;" name="Coupon[expiry]" value="<?php echo esc_attr(stripslashes($wpcoHtml -> field_value('Coupon.expiry'))); ?>" />
                        <?php echo $wpcoHtml -> field_error('Coupon.expiry'); ?>
						<small>format : <b>YYYY-MM-DD</b></small>
						<span class="howto"><?php _e('leave blank for no expiration.', $this -> plugin_name); ?></span>
                        
                        <script type="text/javascript">
						jQuery(document).ready(function(e) {
                            jQuery('#expiry').datepicker({dateFormat: 'yy-mm-dd'});
                        });
						</script>
					</td>
				</tr>
				<tr>
					<th><label for="Coupon.maxuse"><?php _e('Max Use Count', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoForm -> text('Coupon.maxuse', array('width' => '45px')); ?>
						<span class="howto"><?php _e('leave blank or set to 0 for unlimited usage', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><?php _e('Active', $this -> plugin_name); ?></th>
					<td>
						<?php $active = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Coupon.active', $active, array('separator' => false, 'default' => "Y")); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Coupon', $this -> plugin_name)); ?>
		</p>
	</form>
</div>