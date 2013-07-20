<?php if (!empty($shipmethods)) : ?>
	<form action="?page=checkout-shipmethods&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected shipping methods?', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
            	<a class="button" href="?page=<?php echo $this -> sections -> shipmethods; ?>&method=order"><?php _e('Order Shipping Methods', $this -> plugin_name); ?></a>
			</div>
			<div class="alignleft actions">
				<select name="action">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
                    <option value="activate"><?php _e('Activate', $this -> plugin_name); ?></option>
                    <option value="deactivate"><?php _e('Deactivate', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete Selected', $this -> plugin_name); ?></option>
				</select>
				<input type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" class="button" />
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
		
		<table class="widefat">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" /></th>
					<th><?php _e('Name', $this -> plugin_name); ?></th>
					<th><?php _e('Fixed Price', $this -> plugin_name); ?></th>
                    <th><?php _e('Status', $this -> plugin_name); ?></th>
					<th><?php _e('Date', $this -> plugin_name); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" id="checkboxall" /></th>
					<th><?php _e('Name', $this -> plugin_name); ?></th>
					<th><?php _e('Fixed Price', $this -> plugin_name); ?></th>
                    <th><?php _e('Status', $this -> plugin_name); ?></th>
					<th><?php _e('Date', $this -> plugin_name); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php $class = ''; ?>
				<?php foreach ($shipmethods as $shipmethod) : ?>
				
					<?php
					
					if (!empty($shipmethod -> api)) {
						$api_options = maybe_unserialize($shipmethod -> api_options);
					}
					
					?>
				
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th class="check-column"><input type="checkbox" name="Shipmethod[checklist][]" value="<?php echo $shipmethod -> id; ?>" id="checklist<?php echo $shipmethod -> id; ?>" /></th>
						<td>
							<strong><?php echo $wpcoHtml -> link($shipmethod -> name, $this -> url . '&amp;method=save&amp;id=' . $shipmethod -> id, array('class' => "row-title", 'title' => $shipmethod -> name)); ?></strong>
							<div class="row-actions">
								<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=checkout-shipmethods&amp;method=save&amp;id=' . $shipmethod -> id); ?> |</span>
								
								<?php if (!empty($shipmethod -> api)) : ?>
									<?php if (false && $shipmethod -> api == "fedex") : ?>
										<span class="edit"><a href=""><?php _e('Test', $this -> plugin_name); ?></a> |</span>
									<?php endif; ?>
								<?php endif; ?>
								
								<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), '?page=checkout-shipmethods&amp;method=delete&amp;id=' . $shipmethod -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to remove this shipping method?', $this -> plugin_name) . "')) { return false; }")); ?></span>
							</div>
						</td>
						<td>
							<label for="checklist<?php echo $shipmethod -> id; ?>">
								<?php if (empty($shipmethod -> fixed) || $shipmethod -> fixed == "0.00") : ?>
	                            	<?php if (empty($shipmethod -> api)) : ?>
										<span style="color:green;"><?php _e('Free', $this -> plugin_name); ?></span>
	                                <?php else : ?>
	                                	<img src="<?php echo $wpcoHtml -> shipapi_image($shipmethod -> api); ?>" alt="<?php echo $shipmethod -> api; ?>" />
	                                <?php endif; ?>
								<?php else : ?>
									<?php echo $wpcoHtml -> currency_price($shipmethod -> fixed); ?>
								<?php endif; ?>
							</label>
						</td>
                        <td>
                        	<label for="checklist<?php echo $shipmethod -> id; ?>">
	                        	<?php if (!empty($shipmethod -> status) && $shipmethod -> status == "active") : ?>
	                            	<span style="color:green;"><?php _e('Active', $this -> plugin_name); ?></span>
	                            <?php else : ?>
	                            	<span style="color:red;"><?php _e('Inactive', $this -> plugin_name); ?></span>
	                            <?php endif; ?>
	                        </label>
                        </td>
						<td><abbr title="<?php echo $shipmethod -> modified; ?>"><?php echo date("Y-m-d", strtotime($shipmethod -> modified)); ?></abbr></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="tablenav">
			<select class="widefat" style="width:auto;" name="perpage" onchange="change_perpage(this.value);">
                <option value="">- <?php _e('Per Page', $this -> plugin_name); ?> -</option>
                <?php $p = 5; ?>
                <?php while ($p < 100) : ?>
                    <option <?php echo (isset($_COOKIE[$this -> pre . 'shipmethodsperpage']) && $_COOKIE[$this -> pre . 'shipmethodsperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('shipping methods', $this -> plugin_name); ?></option>
                    <?php $p += 5; ?>
                <?php endwhile; ?>
            </select>
            
            <script type="text/javascript">
            function change_perpage(perpage) {
                if (perpage != "") {
                    document.cookie = "<?php echo $this -> pre; ?>shipmethodsperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";
                    window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                }
            }
            </script>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods were found', $this -> plugin_name); ?></p>
<?php endif; ?>