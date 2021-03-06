
<?php global $wpdb; ?>
<?php $order_id = $Order -> current_order_id(false); ?>
<?php $order = $wpdb -> get_row("SELECT * FROM " . $wpdb -> prefix . $Order -> table . " WHERE id = '" . $order_id . "'"); ?>
<?php $user -> shipmethod = (empty($user -> shipmethod)) ? $this -> get_option('shippingdefault') : $user -> shipmethod; ?>
<?php $this -> render('steps', array('step' => 'shipping', 'order' => $order), true, 'default'); ?>

<?php if ($this -> get_option('shipping_globalminimum') == "Y") : ?>
	<?php if ($shipping_minimum = $this -> get_option('shipping_minimum')) : ?>
    	<?php if (!empty($shipping_minimum)) : ?>
        	<div class="shippingmessage"><p class="shippingmessage"><?php _e('We have a minimum shipping of', $this -> plugin_name); ?> <strong><?php echo $wpcoHtml -> currency_price($shipping_minimum); ?></strong></p></div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php $weight = $Order -> weight($order_id); ?>
<?php if (!empty($weight)) : ?>
	<div class="shippingmessageholder"><p class="shippingmessage"><?php _e('Your order has a total calculated weight of', $this -> plugin_name); ?> <strong><?php echo $weight; ?><?php echo $this -> get_option('weightm'); ?></strong></p></div>
<?php endif; ?> 

<?php $ordersummarysections = $this -> get_option('ordersummarysections'); ?>
<?php if (!empty($ordersummarysections) && in_array('shipping', $ordersummarysections)) : ?>
	<?php $this -> render('cart-summary', array('order' => $order, 'items' => $items), true, 'default'); ?>
<?php endif; ?>

<?php /*
<div class="<?php echo $this -> pre; ?>ordersummarybox">
	<fieldset class="wpco steps ordersummary">
		<legend><?php _e('Order Summary', $this -> plugin_name); ?></legend>
       	<div class="stepsholder">
            <?php $items_count = $Item -> item_count($order_id, 'items'); ?>
            <?php $units_count = $Item -> item_count($order_id, 'units'); ?>
            <?php $subtotal = $Order -> total($order_id, false, false, true, true, false); ?>
            <?php $discount = $Discount -> total($order_id); ?>
            <?php $tax_total = $Order -> tax_total($order_id); ?>
            <?php $shipping = $Order -> shipping_total($subtotal, $order_id); ?>
            <?php $total_price = $Order -> total($order_id, true, true); ?>
            
            <?php
            
            $st = $subtotal;
            
            if ($globalf = $Order -> globalf_total($order_id)) {
                if (!empty($globalf)) {
                    $st = $subtotal - $globalf;
                }
            }
            
            ?>
            
            <ul>
                <li><?php _e('Total Items', $this -> plugin_name); ?>: <b><?php echo $items_count; ?></b></li>
                <li><?php _e('Total Units', $this -> plugin_name); ?>: <b><?php echo $units_count; ?></b></li>
                <?php if (!empty($items_count) && $items_count != 0) : ?>
                    <?php if ($this -> get_option('shippingcalc') == "Y" || $this -> get_option('enablecoupons') == "Y") : ?>
                        <li><?php _e('Sub Total', $this -> plugin_name); ?>: <b><?php echo $wpcoHtml -> currency_price($st); ?></b></li>
                        <?php if (!empty($globalf)) : ?>
                            <li><?php _e('Order Options', $this -> plugin_name); ?>: <strong><?php echo $wpcoHtml -> currency_price($globalf); ?></strong></li>
                        <?php endif; ?>
                        <?php if ($this -> get_option('shippingcalc') == "Y" && !empty($shipping) && $shipping != 0) : ?>
                            <li><?php _e('Shipping', $this -> plugin_name); ?>: <b><?php echo $wpcoHtml -> currency_price($shipping); ?></b></li>
                        <?php endif; ?>
                        <?php if ($this -> get_option('enablecoupons') && !empty($discount) && $discount != 0) : ?>
                            <li><?php _e('Discount', $this -> plugin_name); ?>: <b><?php echo $wpcoHtml -> currency_price($discount); ?></b></li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($this -> get_option('tax_calculate') == "Y" && !empty($tax_total)) : ?>
                    <li><?php echo $this -> get_option('tax_name'); ?> (<?php echo $wpcoTax -> get_tax_percentage($Order -> do_shipping($order_id)); ?>&#37;): <strong><?php echo $wpcoHtml -> currency_price($tax_total); ?></strong></li>
                <?php endif; ?>
                <li><?php _e('Total Price', $this -> plugin_name); ?>: <b><u><?php echo $wpcoHtml -> currency_price($total_price); ?></u></b></li>
            </ul>
            
            <!-- Coupon Form -->
            <?php $wpcoDb -> model = $Coupon -> model; ?>
            <?php $couponscount = $wpcoDb -> count(); ?>
            <?php if ($this -> get_option('enablecoupons') == "Y" && !empty($couponscount)) : ?>
                <br/>
                <?php $wpcoDb -> model = $Discount -> model; ?>
                <?php $dcount = $wpcoDb -> count(array('order_id' => $order_id)); ?>
                <?php if ($this -> get_option('multicoupon') == "Y" || (empty($dcount) && $this -> get_option('multicoupon') == "N")) : ?>
                    <?php $this -> render('couponform', false, true, 'default'); ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
	</fieldset>
</div>
*/ ?>

<form <?php if ($this -> is_plugin_active('euvatex')) : ?>onsubmit="jQuery.Watermark.HideAll();"<?php endif; ?>" action="<?php echo $wpcoHtml -> ship_url(); ?>" method="post" id="<?php echo $this -> pre; ?>shippingform">
	<fieldset class="wpco steps shippinginfo">
		<legend><?php _e('Shipping Information', $this -> plugin_name); ?></legend>
       	<div class="stepsholder">
            <table class="<?php echo $this -> pre; ?>">
                <tbody>
                    <?php $class = ''; ?>
                    <?php $paymentfields = $this -> get_option('paymentfields'); ?>
                    <?php $shippingfields = $paymentfields['shipping']; ?>
                    <?php foreach ($shippingfields as $skey => $shippingfield) : ?>
                        <?php if (!empty($shippingfield['show'])) : ?>
                            <?php if ($skey == "country") : ?>
                                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                    <th><label for="<?php echo $this -> pre; ?><?php echo $skey; ?>"><?php echo $shippingfield['title']; ?> <?php if (!empty($shippingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                    <td>
                                        <?php $countries = $Country -> select($domarkets = true); ?>
                                        <select onchange="jQuery('#<?php echo $this -> pre; ?>shippingform').attr('action', '<?php echo $wpcoHtml -> retainquery('updateshipping=1', $wpcoHtml -> ship_url()); ?>').submit();" id="<?php echo $this -> pre; ?>country" class="<?php echo $this -> pre; ?> widefat" name="<?php echo $this -> pre; ?>shipping[country]" style="width:100%;">
                                            <option value="">- <?php _e('Select Country', $this -> plugin_name); ?> -</option>
                                            <?php foreach ($countries as $id => $title) : ?>
                                                <option <?php echo ((!empty($user -> ship_country) && $user -> ship_country == $id) || (empty($user -> ship_country) && $this -> get_option('defcountry') == $id)) ? 'selected="selected"' : ''; ?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (!empty($errors[$skey])) { $this -> render('error', array('error' => $errors[$skey]), true, 'default'); }; ?>
                                    </td>
                                </tr>
                            <?php elseif ($skey == "state") : ?>
                                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                    <th><label for="<?php echo $this -> pre; ?><?php echo $skey; ?>"><?php echo $shippingfield['title']; ?> <?php if (!empty($shippingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                    <td>                                
                                        <?php echo $wpcoState -> get_states_by_country($user -> ship_country, 'wpcoshipping[state]', "true", "ship", false, $order_id); ?>
                                        <?php if (!empty($errors[$skey])) { $this -> render('error', array('error' => $errors['state']), true, 'default'); }; ?>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                    <th><label for="<?php echo $this -> pre; ?><?php echo $skey; ?>"><?php echo $shippingfield['title']; ?> <?php if (!empty($shippingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                    <td>
                                        <input id="<?php echo $this -> pre; ?><?php echo $skey; ?>" style="width:97%;" class="<?php echo $this -> pre; ?> widefat" type="text" name="<?php echo $this -> pre; ?>shipping[<?php echo $skey; ?>]" value="<?php echo (empty($user -> {'ship_' . $skey})) ? '' : $user -> {'ship_' . $skey}; ?>" />
                                        <?php if (!empty($errors[$skey])) { $this -> render('error', array('error' => $errors[$skey]), true, 'default'); }; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>                
                </tbody>
            </table>
        </div>
	</fieldset>
	
	<?php if ($this -> get_option('shippingcalc') == "Y" && $Order -> do_shipping($order_id)) : ?>
		<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
		<?php if ($shipmethods = $wpcoDb -> find_all(array('status' => "active"), false, array('order', "ASC"))) : ?>	
            <fieldset class="wpco steps shippingmethod">
                <legend><?php _e('Shipping Method', $this -> plugin_name); ?></legend>
   				<div class="stepsholder">
					<?php $weight = $Order -> weight($order_id); ?>
                    <?php if ($this -> get_option('shiptierstype') == "weight" && !empty($weight)) : ?>
                        <small><?php _e('Shipping cost is determined by the total weight of your order', $this -> plugin_name); ?>.</small>
                        <small><?php _e('Your order has a total calculated weight of', $this -> plugin_name); ?> <strong><?php echo $weight; ?><?php echo $this -> get_option('weightm'); ?></strong>.</small><br/><br/>
                    <?php endif; ?> 
                    
                    <!-- is there only one shipping method? -->
                    <?php
                    
                    $onlyoneshipmethod = false;
                    if (count($shipmethods) == 1) {
                        $onlyoneshipmethod = true;
                    }
					
					$shippingmethodsdisplay = $this -> get_option('shippingmethodsdisplay');
                	
                	?>
                    
                    <!-- Multiple shipping methods -->
                    <?php if (empty($onlyoneshipmethod) || $onlyoneshipmethod == false) : ?>
	                    <?php if ($shippingmethodsdisplay == "select") : ?>
	                    	<select onchange="wpco_shipmethodchange(this.value, true);" id="<?php echo $this -> pre; ?>shipmethod" name="<?php echo $this -> pre; ?>shipmethod" style="width:100%;">
	                    <?php endif; ?>
	                    
	                    <?php foreach ($shipmethods as $shipmethod) : ?>                        
	                        <?php $shipmethodprice = $wpcoShipmethod -> price($shipmethod -> id, $order_id); ?>
	                    	<?php if ($shippingmethodsdisplay == "radio") : ?>
	                    		<label><input onclick="wpco_shipmethodchange(this.value, true);" <?php echo ($onlyoneshipmethod == true || (!empty($order -> shipmethod_id) && $order -> shipmethod_id == $shipmethod -> id) || (empty($order -> shipmethod_id) && !empty($user -> shipmethod) && $user -> shipmethod == $shipmethod -> id)) ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>shipmethod" value="<?php echo $shipmethod -> id; ?>" id="<?php echo $this -> pre; ?>shipmethod_<?php echo $shipmethod -> id; ?>" /> <?php echo $shipmethod -> name; ?> <?php if (!empty($shipmethodprice) && $shipmethodprice > 0 && $shipmethodprice != "0.00") : ?>(<?php echo $wpcoHtml -> currency_price($shipmethodprice); ?>)<?php endif; ?></label>
	                        <?php else : ?>
	                        	<option <?php echo ($onlyoneshipmethod == true || (empty($order -> shipmethod_id) && !empty($user -> shipmethod) && $user -> shipmethod == $shipmethod -> id) || (!empty($order -> shipmethod_id) && $order -> shipmethod_id == $shipmethod -> id)) ? 'selected="selected"' : ''; ?> value="<?php echo $shipmethod -> id; ?>"><?php echo $shipmethod -> name; ?> <?php if (!empty($shipmethodprice) && $shipmethodprice != "0.00") : ?>(<?php echo $wpcoHtml -> currency_price($shipmethodprice); ?>)<?php endif; ?></option>
	                        <?php endif; ?>
	                    <?php endforeach; ?>
	                    
	                    <?php if ($shippingmethodsdisplay == "select") : ?>
	                    	</select>
	                    	
	                    	<script type="text/javascript">
	                    	jQuery(document).ready(function() {
	                        	shipmethod_id = jQuery('#<?php echo $this -> pre; ?>shipmethod').val();
	                        	wpco_shipmethodchange(shipmethod_id, false);
	                        });
	                    	</script>
	                    <?php else : ?>
	                    	<script type="text/javascript">
	                    	jQuery(document).ready(function() {
	                    		shipmethod_id = jQuery('input[name="<?php echo $this -> pre; ?>shipmethod"]:checked').val();
	                    		wpco_shipmethodchange(shipmethod_id, false);
	                    	});
	                    	</script>
	                    <?php endif; ?>
	                <!-- Only one shipping method -->
	                <?php else : ?>
	                	<strong><?php echo $shipmethods[0] -> name; ?></strong>
	                	<input type="hidden" name="<?php echo $this -> pre; ?>shipmethod" value="<?php echo $shipmethods[0] -> id; ?>" />
	                	
	                	<script type="text/javascript">
                    	jQuery(document).ready(function() {
                    		shipmethod_id = "<?php echo $shipmethods[0] -> id; ?>";
                    		wpco_shipmethodchange(shipmethod_id, false);
                    	});
                    	</script>
	                <?php endif; ?>
                    
                    <script type="text/javascript">  
                    var shippingquoterequest = false;
                                          
                    function wpco_shipmethodchange(shipmethod_id, scroll) {
                    	if (shippingquoterequest) { shippingquoterequest.abort(); }
                    
                    	if (shipmethod_id != "" && shipmethod_id != undefined && shipmethod_id != "undefined" && shipmethod_id != "0") {
                        	var formvalues = jQuery('#<?php echo $this -> pre; ?>shippingform').serialize();
                        	jQuery('#shippingquote').slideDown('slow');
                        	jQuery('#shippingquoteresults').html('<p><img border="0" style="border:none;" src="<?php echo $this -> url(); ?>/images/loading.gif" /> <?php _e('Calculating a shipping quote, please wait.', $this -> plugin_name); ?></p>');
                        	jQuery('#<?php echo $this -> pre; ?>continuebutton').button('option', 'disabled', true);
                        	
                        	shippingquoterequest = jQuery.post(wpcoajaxurl + 'action=wpcoshipmethodchange', formvalues, function(response) {
                        		jQuery('#shippingquoteresults').html(response);
                        		if (scroll == true) { wpco_scroll(jQuery('#shippingquote')); }
                        		jQuery('#<?php echo $this -> pre; ?>continuebutton').button('option', 'disabled', false);
                        	});
                        }
                    }
                    </script>
                    
                    <p>
                    	<span class="small"><a href="" onclick="wpco_shipmethodchange(shipmethod_id, true); return false;" class="<?php echo $this -> pre; ?>button"><?php _e('Refresh Quote', $this -> plugin_name); ?></a></span>
                    </p>
                    
                    <?php if (!empty($errors['shipmethod'])) { $this -> render('error', array('error' => $errors['shipmethod']), true, 'default'); }; ?>
       			</div>
            </fieldset>
		<?php endif; ?>
	<?php endif; ?>
	
	<fieldset id="shippingquote" style="display:none;" class="wpco steps shippingquote">
		<legend><?php _e('Shipping Quote', $this -> plugin_name); ?></legend>
		<!-- Shipping Quote -->
		<div class="stepsholder" id="shippingquoteresults">
			<!-- results go here -->
		</div>
	</fieldset>
	
	<?php global $user_ID; ?>
    <?php $order_id = $Order -> current_order_id(); ?>
    <?php $this -> render('fields' . DS . 'global', array('order_id' => $order_id, 'globalp' => "ship", 'globalerrors' => $globalerrors), true, 'default'); ?>
    
    <?php do_action($this -> pre . '_shipping_after_global', $order_id, $errors); ?>
	
	<div class="shippingbuttons">
        <input type="button" class="<?php echo $this -> pre; ?>button" onclick="history.go(-1);" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" />
		<input type="submit" id="<?php echo $this -> pre; ?>continuebutton" class="<?php echo $this -> pre; ?>button" name="continue" value="<?php _e('Continue', $this -> plugin_name); ?> &raquo;" />
	</div>
</form>