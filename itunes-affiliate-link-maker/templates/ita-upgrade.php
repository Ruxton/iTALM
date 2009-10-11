<div class="wrap">
<h2>iTunes Affiliate Link Maker UPGRADE</h2>
<div class="error" ><p><strong>PLEASE ENSURE YOU BACKUP YOUR DATABASE AND INSTALLATION BEFORE PROCEEDING</strong></p></div>
<div class="updated" ><p>We're going to update the following links to work with the new partner workflow.</p></div>

<?php
	if(sizeof($updates) > 0)
	{
	?><table class="ita-results" id="ita-results-body" width="100%"><?php
		$i = 0;
		foreach($updates as $id => $link) {
		?>
				<tr>
						<td width="70%"<?=( $i == 0 ? ' class="odd"' : '' )?>><a href="<?=$link['url']?>"><?= $link['name'] ?></a></td>
						<td width="30%"<?=( $i == 0 ? ' class="odd"' : '' )?>><?= date("F j, Y, g:i a O", time() ) ?></td>
				</tr>
		<?php
				$i == 0 ? $i = 1 : $i = 0;
		}
	?></table>
	<p><a class="button" href="<?=admin_url('options-general.php?page=itunes-affiliate-link-maker/ita.class.admin.php&italm=upgrade&proceed='.$tokenval)?>">Procced with upgrade</a></p>
	<?php
	}
	else
	{
		?><p>Nothing to upgrade<p>
		<p><a class="button" href="<?=admin_url('options-general.php?page=itunes-affiliate-link-maker/ita.class.admin.php')?>">Return to settings</a></p><?php
	}
?>
</div>
