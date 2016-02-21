<h2 class="nav-tab-wrapper" class="clearfix">
	<a href="<?php echo get_optmenupage_url('switch');?>" class="nav-tab">加速开关</a>
	<a href="<?php echo get_optmenupage_url('tables');?>" class="nav-tab">数据库优化</a>
	<a href="<?php echo get_optmenupage_url('setting');?>" class="nav-tab nav-tab-active">功能设置</a>
</h2>
	
<div class="wrap">
<?php
	if ( isset($_REQUEST['settings-updated']) ) echo '<div id="message" class="updated fade"><p><strong> 选项保存成功！</strong></p></div>';

	?>
	<h2><?php _e('设置', 'optimize_switch'); ?></h2>
	<form id="switch-options-form" method="post" action="options.php" name="switch-options-form">
			<?php settings_fields( 'youpzt-optimize-settings-group' ); ?>
			<?php 			
				$youpzt_optimize_setting =get_option('optimize_setting');		
			?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('启用工具栏链接', 'optimize_setting'); ?> <span class="info"><abbr title="启用此选项将在工具栏(页面顶部)添加 “网站优化工具” 链接 (默认不启用). 更新设置后需要刷新页面生效." rel="tooltip">说明</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_setting[enable-optimize-bar]" class='tgl tgl-ios' id="optimize_setting[enable-optimize-bar]" type='checkbox' <?php if(@$youpzt_optimize_setting['enable-optimize-bar']==true){echo 'checked';};?>>
						<label class='tgl-btn' for="optimize_setting[enable-optimize-bar]"></label>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('卸载插件同时删除配置数据', 'optimize_setting'); ?> <span class="info"><abbr title="默认是此卸载插件保留数据。" rel="tooltip">说明</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_setting[del-optimizer-options]" class='tgl tgl-ios' id="optimize_setting[del-optimizer-options]" type='checkbox' <?php if(@$youpzt_optimize_setting['del-optimizer-options']==true){echo 'checked';};?>>
						<label class='tgl-btn' for="optimize_setting[del-optimizer-options]"></label>
						</p>
					</fieldset>
				</td>
			</tr>
		
		</table> 
		<p class="submit">
			<input type="submit" value="<?php _e('保存选项', 'optimize_switch'); ?>" name="update-options" class="button-primary" />
		</p>
	</form>
</div>
