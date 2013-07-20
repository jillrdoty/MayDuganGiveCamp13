<?php

$ssl_amount = $Order -> total($order -> id, true, true, true, true, true);
$ssl_salestax = $Order -> tax_total($order -> id);

$virtualmerchant_url = ($this -> get_option('virtualmerchant_demo') == "N") ? 'https://www.myvirtualmerchant.com/VirtualMerchant/process.do' : 'https://demo.myvirtualmerchant.com/VirtualMerchantDemo/process.do';

$ssl_description = "";
if (!empty($items)) {
	$descproductsdone = array();
	$desctitles = array();
	
	foreach ($items as $item) {
		if (empty($descproductsdone) || (!empty($descproductsdone) && !in_array($item -> product -> id, $descproductsdone))) {
			$ssl_description .= apply_filters($this -> pre . '_product_title', $item -> product -> title) . ", ";
			$descproductsdone[] = $item -> product -> id;
		}
	}
}

?>

<form id="virtualmerchant-form" action="<?php echo $virtualmerchant_url; ?>" method="post">
	<input type="hidden" name="ssl_merchant_id" value="<?php echo $this -> get_option('virtualmerchant_accountid'); ?>" />
    <input type="hidden" name="ssl_user_id" value="<?php echo $this -> get_option('virtualmerchant_userid'); ?>" />
    <input type="hidden" name="ssl_pin" value="<?php echo $this -> get_option('virtualmerchant_userpin'); ?>" />
    <input type="hidden" name="ssl_amount" value="<?php echo number_format($ssl_amount, 2, '.', ''); ?>" />
    <input type="hidden" name="ssl_show_form" value="true" />
    <input type="hidden" name="ssl_test_mode" value="<?php echo ($this -> get_option('virtualmerchant_testmode') == "Y") ? 'true' : 'false'; ?>" />
    <input type="hidden" name="ssl_invoice_number" value="<?php echo $order -> id; ?>" />
	<input type="hidden" name="ssl_transaction_type" value="ccsale" />
    <input type="hidden" name="ssl_salestax" value="<?php echo number_format($ssl_salestax, 2, '.', ''); ?>" />
    <input type="hidden" name="ssl_customer_code" value="1111" />
    <input type="hidden" name="ssl_description" value="<?php echo esc_attr(stripslashes(rtrim($ssl_description, ", "))); ?>" />
    
    <input type="hidden" name="ssl_result_format" value="HTML" />
    <input type="hidden" name="ssl_receipt_link_method" value="POST" />
    <input type="hidden" name="ssl_receipt_link_url" value="<?php echo $wpcoHtml -> retainquery($this -> pre . "method=coreturn&type=virtualmerchant&order_id=" . $order -> id, $wpcoHtml -> cart_url()); ?>" />
    <input type="hidden" name="ssl_receipt_link_text" value="<?php _e('Click here to finalize your order', $this -> plugin_name); ?>" />
    
    <!-- Billing Details -->
    <input type="hidden" name="ssl_email" value="<?php echo $order -> bill_email; ?>" />
    <input type="hidden" name="ssl_phone" value="<?php echo esc_attr(stripslashes($order -> bill_phone)); ?>" />
    <input type="hidden" name="ssl_company" value="<?php echo esc_attr(stripslashes($order -> bill_company)); ?>" />
    <input type="hidden" name="ssl_first_name" value="<?php echo esc_attr(stripslashes($order -> bill_fname)); ?>" />
    <input type="hidden" name="ssl_last_name" value="<?php echo esc_attr(stripslashes($order -> bill_lname)); ?>" />
    <input type="hidden" name="ssl_avs_address" value="<?php echo esc_attr(stripslashes($order -> bill_address)); ?>" />
    <input type="hidden" name="ssl_address2" value="<?php echo esc_attr(stripslashes($order -> bill_address2)); ?>" />
    <input type="hidden" name="ssl_city" value="<?php echo esc_attr(stripslashes($order -> bill_city)); ?>" />
    <input type="hidden" name="ssl_state" value="<?php echo esc_attr(stripslashes($order -> bill_state)); ?>" />
    <input type="hidden" name="ssl_avs_zip" value="<?php echo esc_attr(stripslashes($order -> bill_zipcode)); ?>" />
    <input type="hidden" name="ssl_country" value="<?php echo esc_attr(stripslashes($order -> bill_countryname)); ?>" />

	<?php if ($Order -> do_shipping($order -> id)) : ?>    
	    <!-- Shipping Details -->
	    <input type="hidden" name="ssl_ship_to_company" value="<?php echo esc_attr(stripslashes($order -> ship_company)); ?>" />
	   	<input type="hidden" name="ssl_ship_to_first_name" value="<?php echo esc_attr(stripslashes($order -> ship_fname)); ?>" />
	   	<input type="hidden" name="ssl_ship_to_last_name" value="<?php echo esc_attr(stripslashes($order -> ship_lname)); ?>" />
	   	<input type="hidden" name="ssl_ship_to_address1" value="<?php echo esc_attr(stripslashes($order -> ship_address)); ?>" />
	   	<input type="hidden" name="ssl_ship_to_address2" value="<?php echo esc_attr(stripslashes($order -> ship_address2)); ?>" />
	   	<input type="hidden" name="ssl_ship_to_city" value="<?php echo esc_attr(stripslashes($order -> ship_city)); ?>" />   	
	   	<input type="hidden" name="ssl_ship_to_state" value="<?php echo esc_attr(stripslashes($order -> ship_state)); ?>" />
	   	<input type="hidden" name="ssl_ship_to_zip" value="<?php echo esc_attr(stripslashes($order -> ship_zipcode)); ?>" />
	   	<input type="hidden" name="ssl_ship_to_country" value="<?php echo esc_attr(stripslashes($order -> ship_countryname)); ?>" />
	   	<input type="hidden" name="ssl_ship_to_phone" value="<?php echo esc_attr(stripslashes($order -> ship_phone)); ?>" />
	<?php endif; ?>
   	
    <a href="<?php echo $wpcoHtml -> bill_url(); ?>" class="button"><?php _e('&laquo; Back', $this -> plugin_name); ?></a>
	<input type="submit" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
</form>

<script type="text/javascript">
jQuery(document).ready(function() { document.getElementById('virtualmerchant-form').submit(); });
</script>