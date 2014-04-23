<?php
function top_rated_products()
{
	if( isset($_POST['btn-update']) )
	{
		$trp = $_POST['trp'];
		update_option("trp",$trp);
	}
	if( isset($_POST['btn-reset']) )
	{
		delete_option("trp");
	}
	$trp = get_option("trp",trp_default());
	
	?>
	<h1>Top Rated Products Plugin</h1>
	<p>Version 1.0 | <a href="admin.php?page=top-rated-products" >Options</a> <?php /*?>| <a href="admin.php?page=top-rated-products-faq" >FAQ</a> | <a href="admin.php?page=top-rated-products-tutorial" >Tutorial</a></p><?php */?>
	<hr/>
	<form method="post" >
	<table width="400px" height="250px" >
		<tr><th width="75%" ></th><th width=25%" ></th></tr>
		<tr>
			<td colspan="2" valign="top" align="left" >
				<label for="trp-no-follow"><input type="checkbox" name="trp[no-follow]" id="trp-no-follow" value="yes" <?php echo $trp['no-follow']=='yes'?'checked="checked"':'';?> > No Follow Affiliate Links</label><br/>
			</td>
		</tr>
		<tr>
			<td colspan="2" valign="top" align="left" >
				<label for="trp-new-window"><input type="checkbox" name="trp[new-window]" id="trp-new-window" value="yes"  <?php echo $trp['new-window']=='yes'?'checked="checked"':'';?> > Open links in new window?</label>
			</td>
		</tr>
		<tr>
			<td  valign="top" align="left">
				Buy Button URL<br/><input type="text" name="trp[buy-button-url]"  size="40" value="<?php echo $trp['buy-button-url'];?>" >
			</td>
			<td align="left" valign="top" >
				<img src="<?php echo $trp['buy-button-url'];?>" style="max-height:50px"  />
			</td>
		</tr>
		<tr>
			<td  valign="top" align="left">
				Read More Button URL<br/><input type="text"  name="trp[read-more-button-url]" size="40" value="<?php echo $trp['read-more-button-url'];?>" >
			</td>
			<td align="left" valign="top" >
				<img src="<?php echo $trp['read-more-button-url'];?>" style="max-height:50px" />
			</td>
		</tr>
		<tr>
			<td colspan="2" align="left" valign="top" >
			<input type="submit" class="reset-button button-secondary" name="btn-reset" value="Reset" /> &nbsp;&nbsp; 
			<input type="submit" class="reset-button button-secondary" name="btn-update" value="Update Optins" />
			</td>
		</tr>
	</table>
	</form>	
	
	<?php
}
?>