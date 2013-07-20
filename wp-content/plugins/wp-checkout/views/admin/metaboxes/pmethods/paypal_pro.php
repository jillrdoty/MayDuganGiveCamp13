<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="pp_pro_title"><?php _e('Payment Method Name', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="pp_pro_title" value="<?php echo esc_attr(stripslashes($this -> get_option('pp_pro_title'))); ?>" id="pp_pro_title" />
                <span class="howto"><?php _e('The name/title to display to customers on the billing page of checkout.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="pp_pro_api_username"><?php _e('PayPal API Username', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="pp_pro_api_username" value="<?php echo esc_attr(stripslashes($this -> get_option('pp_pro_api_username'))); ?>" id="pp_pro_api_username" />
            </td>
        </tr>
        <tr>
        	<th><label for="pp_pro_api_password"><?php _e('PayPal API Password', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="pp_pro_api_password" value="<?php echo esc_attr(stripslashes($this -> get_option('pp_pro_api_password'))); ?>" id="pp_pro_api_password" />
            </td>
        </tr>
        <tr>
        	<th><label for="pp_pro_api_signature"><?php _e('PayPal API Signature', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="pp_pro_api_signature" value="<?php echo esc_attr(stripslashes($this -> get_option('pp_pro_api_signature'))); ?>" id="pp_pro_api_signature" />
            </td>
        </tr>
        <tr>
        	<th><label for="pp_pro_api_endpoint_T"><?php _e('PayPal Server', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('pp_pro_api_endpoint') == "https://api-3t.sandbox.paypal.com/nvp") ? 'checked="checked"' : ''; ?> type="radio" name="pp_pro_api_endpoint" value="https://api-3t.sandbox.paypal.com/nvp" id="pp_pro_api_endpoint_T" /> <?php _e('Testing/Sandbox', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('pp_pro_api_endpoint') == "https://api-3t.paypal.com/nvp") ? 'checked="checked"' : ''; ?> type="radio" name="pp_pro_api_endpoint" value="https://api-3t.paypal.com/nvp" id="pp_pro_api_endpoint_L" /> <?php _e('Live', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Set to testing/sandbox when using a PayPal sandbox account.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>