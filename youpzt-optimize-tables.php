<h2 class="nav-tab-wrapper" class="clearfix">
	<a href="<?php echo get_optmenupage_url('switch');?>" class="nav-tab">加速开关</a>
	<a href="<?php echo get_optmenupage_url('tables');?>" class="nav-tab nav-tab-active">数据库优化</a>
	<a href="<?php echo get_optmenupage_url('setting');?>" class="nav-tab">功能设置</a>
</h2>
<div class="wrap">
	
<?php

global $wpdb;
### Get MYSQL Version
$sqlversion = $wpdb->get_var("SELECT VERSION() AS version"); 

function wp_clean_up($type){
	global $wpdb;
	switch($type){
		case "revision":
			$wcu_sql = "DELETE FROM $wpdb->posts WHERE post_type = 'revision'";
			break;
		case "draft":
			$wcu_sql = "DELETE FROM $wpdb->posts WHERE post_status = 'draft'";
			break;
		case "autodraft":
			$wcu_sql = "DELETE FROM $wpdb->posts WHERE post_status = 'auto-draft'";
			break;
		case "moderated":
			$wcu_sql = "DELETE FROM $wpdb->comments WHERE comment_approved = '0'";
			break;
		case "spam":
			$wcu_sql = "DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'";
			break;
		case "trash":
			$wcu_sql = "DELETE FROM $wpdb->comments WHERE comment_approved = 'trash'";
			break;
		case "postmeta":
			$wcu_sql = "DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL";
			//$wcu_sql = "DELETE FROM $wpdb->postmeta WHERE NOT EXISTS ( SELECT * FROM $wpdb->posts WHERE $wpdb->postmeta.post_id = $wpdb->posts.ID )";
			break;
		case "commentmeta":
			$wcu_sql = "DELETE FROM $wpdb->commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM $wpdb->comments)";
			break;
		case "usermeta":
			$wcu_sql = "DELETE FROM $wpdb->usermeta WHERE user_id NOT IN (SELECT ID FROM $wpdb->users)";
			break;
		case "relationships":
			$wcu_sql = "DELETE FROM $wpdb->term_relationships WHERE term_taxonomy_id=1 AND object_id NOT IN (SELECT id FROM $wpdb->posts)";
			break;
		case "feed":
			$wcu_sql = "DELETE FROM $wpdb->options WHERE option_name LIKE '_site_transient_browser_%' OR option_name LIKE '_site_transient_timeout_browser_%' OR option_name LIKE '_transient_feed_%' OR option_name LIKE '_transient_timeout_feed_%'";
			break;
	}

	$wpdb->query($wcu_sql);
}

function wp_clean_up_count($type){
	global $wpdb;
	switch($type){
		case "revision":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'revision'";
			break;
		case "draft":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'draft'";
			break;
		case "autodraft":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'auto-draft'";
			break;
		case "moderated":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '0'";
			break;
		case "spam":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 'spam'";
			break;
		case "trash":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 'trash'";
			break;
		case "postmeta":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL";
			//$wcu_sql = "SELECT COUNT(*) FROM $wpdb->postmeta WHERE NOT EXISTS ( SELECT * FROM $wpdb->posts WHERE $wpdb->postmeta.post_id = $wpdb->posts.ID )";
			break;
		case "commentmeta":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id NOT IN (SELECT comment_ID FROM $wpdb->comments)";
			break;
		case "usermeta":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->usermeta WHERE user_id NOT IN (SELECT ID FROM $wpdb->users)";
			break;
		case "relationships":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id=1 AND object_id NOT IN (SELECT id FROM $wpdb->posts)";
			break;
		case "feed":
			$wcu_sql = "SELECT COUNT(*) FROM $wpdb->options WHERE option_name LIKE '_site_transient_browser_%' OR option_name LIKE '_site_transient_timeout_browser_%' OR option_name LIKE '_transient_feed_%' OR option_name LIKE '_transient_timeout_feed_%'";
			break;
	}
	$count = $wpdb->get_var($wcu_sql);
	return $count;
}

function wp_clean_up_optimize(){
	global $wpdb;
	$wcu_sql = 'SHOW TABLE STATUS FROM `'.DB_NAME.'`';
	$result = $wpdb->get_results($wcu_sql);
	foreach($result as $row){
		$wcu_sql = 'OPTIMIZE TABLE '.$row->Name;
		$wpdb->query($wcu_sql);
	}
}

	$wcu_message = '';

	if(isset($_POST['wp_clean_up_revision'])){
		wp_clean_up('revision');
		$wcu_message = __("所有的修订版本已经被删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_draft'])){
		wp_clean_up('draft');
		$wcu_message = __("所有的手动草稿已经被删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_autodraft'])){
		wp_clean_up('autodraft');
		$wcu_message = __("所有的自动草稿已经被删除!","youpzt");
	}
	
	if(isset($_POST['wp_clean_up_moderated'])){
		wp_clean_up('moderated');
		$wcu_message = __("所有的待审评论已经被删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_spam'])){
		wp_clean_up('spam');
		$wcu_message = __("所有的垃圾评论已经被删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_trash'])){
		wp_clean_up('trash');
		$wcu_message = __("所有的回收站评论已经被删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_postmeta'])){
		wp_clean_up('postmeta');
		$wcu_message = __("所有的文章孤立元信息已经删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_commentmeta'])){
		wp_clean_up('commentmeta');
		$wcu_message = __("所有的评论孤立元信息已经删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_usermeta'])){
		wp_clean_up('usermeta');
		$wcu_message = __("所有的用户孤立元信息已经删除!","youpzt");
	}
		if(isset($_POST['wp_clean_up_termmeta'])){
		wp_clean_up('termmeta');
		$wcu_message = __("所有的分类孤立元信息已经删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_relationships'])){
		wp_clean_up('relationships');
		$wcu_message = __("所有的分类关系数据已经删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_feed'])){
		wp_clean_up('feed');
		$wcu_message = __("所有的订阅缓存已经删除!","youpzt");
	}

	if(isset($_POST['wp_clean_up_all'])){
		wp_clean_up('revision');
		wp_clean_up('draft');
		wp_clean_up('autodraft');
		wp_clean_up('moderated');
		wp_clean_up('spam');
		wp_clean_up('trash');
		wp_clean_up('postmeta');
		wp_clean_up('commentmeta');
		wp_clean_up('usermeta');
		wp_clean_up('termmeta');
		wp_clean_up('relationships');
		wp_clean_up('feed');
		$wcu_message = __("已经删除了所有的垃圾数据!","youpzt");
	}

	if(isset($_POST['wp_clean_up_optimize'])){
		wp_clean_up_optimize();
		$wcu_message = __("数据库已经被优化!","youpzt");
	}

	if($wcu_message != ''){
		echo '<div id="message" class="updated fade"><p><strong>' . $wcu_message . '</strong></p></div>';
	}
?>

<!-- Database Information -->
<div class="wrap1">
<div class="oh">
	<div class="fl" style="width:419px;">
	<h2><?php _e('数据库优化', 'optimize_switch'); ?><span class="info"><abbr title="全面开启数据库清理优化" rel="tooltip">说明</abbr></span></h2>
	<table class="widefat" >
	<thead>
		<tr>
			<th scope="col"><?php _e('类型','youpzt'); ?></th>
			<th scope="col"><?php _e('数量','youpzt'); ?></th>
			<th scope="col"><?php _e('操作','youpzt'); ?></th>
		</tr>
	</thead>
	<tbody id="the-list">
		<tr class="alternate">
			<td class="column-name">
				<?php _e('修订版本','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('revision'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_revision" value="revision" />
					<input type="submit" class="<?php if(wp_clean_up_count('revision')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('手动草稿','youpzt'); ?><span class="info"><abbr class="f12 color-red" title="文章编辑手动草稿，不确定的情况下，不要删除" rel="tooltip">建议保留</abbr></span>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('draft'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_draft" value="draft" />
					<input type="submit" class="<?php if(wp_clean_up_count('draft')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr class="alternate">
			<td class="column-name">
				<?php _e('自动草稿','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('autodraft'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_autodraft" value="autodraft" />
					<input type="submit" class="<?php if(wp_clean_up_count('autodraft')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('待审评论','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('moderated'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_moderated" value="moderated" />
					<input type="submit" class="<?php if(wp_clean_up_count('moderated')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr class="alternate">
			<td class="column-name">
				<?php _e('垃圾评论','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('spam'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_spam" value="spam" />
					<input type="submit" class="<?php if(wp_clean_up_count('spam')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('回收站评论','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('trash'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_trash" value="trash" />
					<input type="submit" class="<?php if(wp_clean_up_count('trash')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr class="alternate">
			<td class="column-name">
				<?php _e('孤立的文章元信息','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('postmeta'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_postmeta" value="postmeta" />
					<input type="submit" class="<?php if(wp_clean_up_count('postmeta')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('孤立的评论元信息','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('commentmeta'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_commentmeta" value="commentmeta" />
					<input type="submit" class="<?php if(wp_clean_up_count('commentmeta')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('孤立的用户元信息','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('usermeta'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_usermeta" value="usermeta" />
					<input type="submit" class="<?php if(wp_clean_up_count('usermeta')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('孤立的分类元信息','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('termmeta'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_termmeta" value="termmeta" />
					<input type="submit" class="<?php if(wp_clean_up_count('termmeta')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr class="alternate">
			<td class="column-name">
				<?php _e('孤立的分类关系信息','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('relationships'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_relationships" value="relationships" />
					<input type="submit" class="<?php if(wp_clean_up_count('relationships')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
		<tr>
			<td class="column-name">
				<?php _e('控制板订阅缓存','youpzt'); ?>
			</td>
			<td class="column-name">
				<?php echo wp_clean_up_count('feed'); ?>
			</td>
			<td class="column-name">
				<form action="" method="post">
					<input type="hidden" name="wp_clean_up_feed" value="feed" />
					<input type="submit" class="<?php if(wp_clean_up_count('feed')>0){echo 'button-primary';}else{echo 'button';} ?>" value="<?php _e('删除','youpzt'); ?>" />
				</form>
			</td>
		</tr>
	</tbody>
</table>
<p>
<form action="" method="post">
	<input type="hidden" name="wp_clean_up_all" value="all" />
	<input type="submit" class="button-primary" value="<?php _e('删除所有','youpzt'); ?>" /><span class="info"><abbr title="删除所有会删除所有数据库垃圾，请确认后操作" rel="tooltip">谨慎操作</abbr></span>
</form>
</p>
</div>

		<div class="oh fr" style="width:400px;">
			<h3><?php _e('数据库信息', 'youpzt-dbmanager'); ?></h3>
			<table class="widefat" >
				<thead>
					<tr>
						<th><?php _e('数据库', 'youpzt-dbmanager'); ?></th>
						<th><?php _e('属性值', 'youpzt-dbmanager'); ?></th>
					</tr>
				</thead>
				<tr>
					<td><?php _e('数据库主机', 'youpzt-dbmanager'); ?></td>
					<td><?php echo DB_HOST; ?></td>
				</tr>
				<tr class="alternate">
					<td><?php _e('数据库名称', 'youpzt-dbmanager'); ?></td>
					<td><?php echo DB_NAME; ?></td>
				</tr>
				<tr>
					<td><?php _e('数据库用户名', 'youpzt-dbmanager'); ?></td>
					<td><?php echo DB_USER; ?></td>
				</tr>
				<tr class="alternate">
					<td><?php _e('数据库类型', 'youpzt-dbmanager'); ?></td>
					<td>MYSQL</td>
				</tr>
				<tr>
					<td><?php _e('数据库版本', 'youpzt-dbmanager'); ?></td>
					<td>v<?php echo $sqlversion; ?></td>
				</tr>
			</table>
		</div>

</div>
<hr/>
<div class="wrap_sql_tab">
	<h3><?php _e('数据库表信息', 'youpzt'); ?></h3>
	<br style="clear" />
	<table class="widefat">
		<thead>
			<tr>
				<th><?php _e('序号.', 'youpzt'); ?></th>
				<th><?php _e('数据表', 'youpzt'); ?></th>
				<th><?php _e('记录', 'youpzt'); ?></th>
				<th><?php _e('数据', 'youpzt'); ?></th>
				<th><?php _e('索引', 'youpzt'); ?></th>
				<th><?php _e('开销', 'youpzt'); ?></th>
			</tr>
		</thead>
		<?php
			$no = 0;
			$row_usage = 0;
			$data_usage = 0;
			$index_usage = 0;
			$overhead_usage = 0;
			$tablesstatus = $wpdb->get_results("SHOW TABLE STATUS");
			foreach($tablesstatus as  $tablestatus) {
				if($no%2 == 0) {
					$style = '';
				} else {
					$style = ' class="alternate"';
				}
				$no++;
				echo "<tr$style>\n";
				echo '<td>'.number_format_i18n($no).'</td>'."\n";
				echo "<td>$tablestatus->Name</td>\n";
				echo '<td>'.number_format_i18n($tablestatus->Rows).'</td>'."\n";
				echo '<td>'.format_size($tablestatus->Data_length).'</td>'."\n";
				echo '<td>'.format_size($tablestatus->Index_length).'</td>'."\n";;
				echo '<td>'.format_size($tablestatus->Data_free).'</td>'."\n";
				$row_usage += $tablestatus->Rows;
				$data_usage += $tablestatus->Data_length;
				$index_usage +=  $tablestatus->Index_length;
				$overhead_usage += $tablestatus->Data_free;
				echo '</tr>'."\n";
			}
			echo '<tr class="thead">'."\n";
			echo '<th>'.__('总计:', 'youpzt').'</th>'."\n";
			echo '<th>'.sprintf(_n('%s Table', '%s 数据表', $no, 'youpzt'), number_format_i18n($no)).'</th>'."\n";
			echo '<th>'.sprintf(_n('%s Record', '%s 条记录', $row_usage, 'youpzt'), number_format_i18n($row_usage)).'</th>'."\n";
			echo '<th>'.format_size($data_usage).'</th>'."\n";
			echo '<th>'.format_size($index_usage).'</th>'."\n";
			echo '<th>'.format_size($overhead_usage).'</th>'."\n";
			echo '</tr>';
		?>
	</table>
</div>
<p>
<form action="" method="post">
	<input type="hidden" name="wp_clean_up_optimize" value="optimize" />
	<input type="submit" class="button-primary" value="<?php _e('优化数据库','youpzt'); ?>" />
</form>
</p>
</div>
