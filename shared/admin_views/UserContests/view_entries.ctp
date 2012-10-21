<div class='index'>
	<div class='form'>
		<?php 
		
			echo $this->Form->create("UserContestEntry",array("url"=>$this->request->here));
			echo $this->Form->input("foreign_key",array("options"=>$postFilter,"label"=>"Filter by post","empty"=>true));
			echo $this->Form->end("Filter");
			
		?>
	</div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<table cellspacing='0'>
		<tr>
			<th>ID</th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("User.first_name"); ?></th>
			<th><?php echo $this->Paginator->sort("winner"); ?></th>
			<th><?php echo $this->Paginator->sort("winning_rank"); ?></th>
			<th>Linked-Model</th>
			<th>-</th>
		</tr>	
		<?php foreach($data as $d): ?>
		<tr>
			<td><?php echo $d['UserContestEntry']['id']; ?></td>
			
			<td><?php echo $this->Time->niceShort($d['UserContestEntry']['created']); ?></td>
			<td><?php echo $this->Time->niceShort($d['UserContestEntry']['modified']); ?></td>
			<td><a href='/users/edit/<?php echo $d['User']['id']; ?>' target='_blank'><?php echo $d['User']['first_name']; ?> <?php echo $d['User']['last_name']; ?></a>
				<a href='http://facebook.com/profile.php?id=<?php echo $d['User']['facebook_account_num']; ?>' target='_blank'>(FACEBOOK)</a>

			</td>
			<td>
				<?php 
				
					switch($d['UserContestEntry']['winner']) {
				
						case 1:
							echo "<span style='color:green'>YES</span>";
							break;
						default:
							echo "<span style='color:Red;'>NO</span>";
						break;
											
					}
				?>
			</td>
			<td>
			<?php echo $d['UserContestEntry']['winning_rank']; ?>
			</td>
			<td>
				<?php echo $d['Dailyop']['name']; ?> - <?php echo $d['Dailyop']['sub_title']; ?>
			</td>
			<td class='actions'>
				<?php if($d['UserContestEntry']['winner']): ?>
					<a href='/user_contests/mark_entry/type:loser/user_contest_entry_id:<?php echo $d['UserContestEntry']['id']; ?>/user_contest_id:<?php echo $d['UserContestEntry']['user_contest_id']; ?>'>Mark As LOSER!</a>
				<?php else: ?>
					<a href='/user_contests/mark_entry/type:winner/user_contest_entry_id:<?php echo $d['UserContestEntry']['id']; ?>/user_contest_id:<?php echo $d['UserContestEntry']['user_contest_id']; ?>'>Mark As WINNER!</a>
				<?php endif; ?>
				<a href='/user_contests/edit_entry/<?php echo $d['UserContestEntry']['id']; ?>/<?php echo base64_encode($this->request->here); ?>'>Edit</a>
			</td>
		</tr>	
		<?php endforeach;?>
	</table>
</div>
<?php 

pr($data);

?>
