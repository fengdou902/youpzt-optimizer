<h2 class="nav-tab-wrapper" class="clearfix">
	<a href="<?php echo get_optmenupage_url('switch');?>" class="nav-tab nav-tab-active">加速开关</a>
	<a href="<?php echo get_optmenupage_url('tables');?>" class="nav-tab">数据库优化</a>
	<a href="<?php echo get_optmenupage_url('setting');?>" class="nav-tab">功能设置</a>
</h2>
	
<div class="wrap">
	<?php
		if ( isset($_REQUEST['settings-updated']) ) echo '<div id="message" class="updated fade"><p><strong> 选项保存成功！</strong></p></div>';
		if( 'reset' == isset($_REQUEST['reset']) ) {
			delete_option('optimize_options');
			echo '<div id="message" class="updated fade"><p><strong>设置重设</strong></p></div>';
		}
	?>
	<h2><?php _e('开关加速', 'optimize_switch'); ?><span class="info"><abbr title="进行下面优化开关设置，可对网站性能大幅度提升。以下开启，只表示当前选项的按钮开关" rel="tooltip">说明</abbr></span></h2>
	<form id="switch-options-form" method="post" action="options.php" name="switch-options-form">
			<?php settings_fields( 'youpzt-optimize-options-group' ); ?>
			<?php 
				$youpzt_optimize_options =get_option('optimize_options');		
			?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row" class="plyid"><?php _e('更换Gravatar镜像', 'optimize_switch'); ?> <span class="info"><abbr title="建议开启加速" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_options[gravatar-replace]" value="1" id="optimize_options[gravatar-replace]" type='radio' <?php if($youpzt_optimize_options['gravatar-replace']==1){echo 'checked';};?>>
						<label for="optimize_options[gravatar-replace]">原有</label>
						<input name="optimize_options[gravatar-replace]" value="2" id="optimize_options[gravatar-replace]" type='radio' <?php if($youpzt_optimize_options['gravatar-replace']==2){echo 'checked';};?>>
						<label for="optimize_options[gravatar-replace]">SSL</label>
						<input name="optimize_options[gravatar-replace]" value="3" id="optimize_options[gravatar-replace]" type='radio' <?php if($youpzt_optimize_options['gravatar-replace']==3){echo 'checked';};?>>
						<label for="optimize_options[gravatar-replace]">多说</label>
						<input name="optimize_options[gravatar-replace]" value="4" id="optimize_options[gravatar-replace]" type='radio' <?php if($youpzt_optimize_options['gravatar-replace']==4){echo 'checked';};?>>
						<label for="optimize_options[gravatar-replace]">CN</label>
						<input name="optimize_options[gravatar-replace]" value="5" id="optimize_options[gravatar-replace]" type='radio' <?php if($youpzt_optimize_options['gravatar-replace']==5){echo 'checked';};?>>
						<label for="optimize_options[gravatar-replace]">v2ex</label>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('禁用 Emoji 表情', 'optimize_switch'); ?> <span class="info"><abbr title="4.2版本后，Emoji 表情api服务在国内是无法正常访问的，这就导致了网站加载缓慢" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_options[no-emoji]" class='tgl tgl-skewed' id="optimize_options[no-emoji]" type='checkbox' <?php if($youpzt_optimize_options['no-emoji']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[no-emoji]"></label>
						</p>
					</fieldset>
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><?php _e('替换谷歌[google]字体镜像', 'optimize_switch'); ?> <span class="info"><abbr title="提供的不同谷歌字体镜像选择" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_options[google-font]" value="1" id="optimize_options[google-font]" type='radio' <?php if($youpzt_optimize_options['google-font']==1){echo 'checked';};?>><label for="optimize_options[google-font]">禁用</label>
						<input name="optimize_options[google-font]" value="2" id="optimize_options[google-font]" type='radio' <?php if($youpzt_optimize_options['google-font']==2){echo 'checked';};?>><label for="optimize_options[google-font]">360</label>
						<input name="optimize_options[google-font]" value="3" id="optimize_options[google-font]" type='radio' <?php if($youpzt_optimize_options['google-font']==3){echo 'checked';};?>><label for="optimize_options[google-font]">中科大</label>
						<input name="optimize_options[google-font]" value="4" id="optimize_options[google-font]" type='radio' <?php if($youpzt_optimize_options['google-font']==4){echo 'checked';};?>><label for="optimize_options[google-font]">微锐</label>
						</p>
					</fieldset>
				</td>
				<!--<td>
					<fieldset>
						<p>
						<input name="optimize_options[google-font]" class='tgl tgl-skewed' id="optimize_options[google-font]" type='checkbox' <?php //if($youpzt_optimize_options['google-font']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[google-font]"></label>
						</p>
					</fieldset>
				</td>-->
			</tr>			
			<tr valign="top">
				<th scope="row"><?php _e('移除网站头部的 WP版本', 'optimize_switch'); ?> <span class="info"><abbr title="这是隐性显示的WordPress版本信息，可以被黑客利用，攻击特定版本的WordPress漏洞。强烈建议移除" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_options[wp-generator]" class='tgl tgl-skewed' id="optimize_options[wp-generator]" type='checkbox' <?php if($youpzt_optimize_options['wp-generator']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[wp-generator]"></label>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('关闭开放接口XML-RPC', 'optimize_switch'); ?> <span class="info"><abbr title="如果用不到离线编辑工具（如：微软Live Writer编辑器），可以关闭。" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_options[edit_kaifang]" class='tgl tgl-skewed' id="optimize_options[edit_kaifang]" type='checkbox' <?php if($youpzt_optimize_options['edit_kaifang']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[edit_kaifang]"></label>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('移除文章和评论feed', 'optimize_switch'); ?> <span class="info"><abbr title="文章和评论feed。若不开放RSS订阅，可以移除。" rel="tooltip">说明</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_options[feed_links]" class='tgl tgl-skewed' id="optimize_options[feed_links]" type='checkbox' <?php if($youpzt_optimize_options['feed_links']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[feed_links]"></label>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('移除网站头部分类等feed', 'optimize_switch'); ?> <span class="info"><abbr title="分类等feed，可以移除。" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_options[feed_links_extra]" class='tgl tgl-skewed' id="optimize_options[feed_links_extra]" type='checkbox' <?php if($youpzt_optimize_options['feed_links_extra']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[feed_links_extra]"></label>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('移除文章meta信息', 'optimize_switch'); ?> <span class="info"><abbr title="前后文、第一篇文章和主页链接全放在meta中，于SEO帮助不大，反使得头部信息巨大，可以移除。" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_options[index_link]" class='tgl tgl-skewed' id="optimize_options[index_link]" type='checkbox' <?php if($youpzt_optimize_options['index_link']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[index_link]"></label>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('移除菜单的多余css选择器', 'optimize_switch'); ?> <span class="info"><abbr title="菜单选择器包括ID和class选择器，拥有很多选择器代码，如果没有相关选择器的css样式，建议移除。" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p>
						<input name="optimize_options[css_attributes]" class='tgl tgl-skewed' id="optimize_options[css_attributes]" type='checkbox' <?php if($youpzt_optimize_options['css_attributes']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[css_attributes]"></label>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('关闭Trackbacks功能', 'optimize_switch'); ?><span class="info"><abbr title="关闭Trackbacks功能，有效防止垃圾留言！但无法获取谁引用我们的博客" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[trackbacks]" class='tgl tgl-skewed' id="optimize_options[trackbacks]" type='checkbox' <?php if($youpzt_optimize_options['trackbacks']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[trackbacks]"></label></p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('启用文章特色图像功能', 'optimize_switch'); ?><span class="info"><abbr title="WordPress默认关闭特色图像功能，可开启此项，可作文章缩略图展示" rel="tooltip">说明</abbr></span></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[thumbnails]" class='tgl tgl-skewed' id="optimize_options[thumbnails]" type='checkbox' <?php if($youpzt_optimize_options['thumbnails']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[thumbnails]"></label></p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('开启后台链接Links栏目', 'optimize_switch'); ?><span class="info"><abbr title="新版本WP后台链接栏目是默认关闭的，可通过此项开启" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[open_links]" class='tgl tgl-skewed' id="optimize_options[open_links]" type='checkbox' <?php if($youpzt_optimize_options['open_links']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[open_links]"></label></p>
					</fieldset>
				</td>
			</tr>
						<tr valign="top">
				<th scope="row"><?php _e('彻底禁止WordPress缩略图', 'optimize_switch'); ?><span class="info"><abbr title="使用第三方七牛或又拍云自带缩略图，可关闭wordpress的缩略图裁剪功能，减小资源占用" rel="tooltip">说明</abbr></span></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[close_thumb_size]" class='tgl tgl-skewed' id="optimize_options[close_thumb_size]" type='checkbox' <?php if($youpzt_optimize_options['close_thumb_size']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[close_thumb_size]"></label></p>
					</fieldset>
				</td>
			</tr>
			<!--<tr valign="top">
				<th scope="row"><?php //_e('主题预览', 'optimize_switch'); ?></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[themes-preview]" class='tgl tgl-ios' id="optimize_options[themes-preview]" type='checkbox' <?php //if($youpzt_optimize_options['themes-preview']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[themes-preview]"></label></p>
					</fieldset>
				</td>
			</tr>-->
			<tr valign="top">
				<th scope="row"><?php _e('禁止检查WP系统版本更新', 'optimize_switch'); ?><span class="info"><abbr title="禁止wordpresss的版本检查更新来提高后台打开速度。" rel="tooltip">说明</abbr></span></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[core-update]" class='tgl tgl-skewed' id="optimize_options[core-update]" type='checkbox' <?php if($youpzt_optimize_options['core-update']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[core-update]"></label></p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('禁止检查插件的更新。', 'optimize_switch'); ?><span class="info"><abbr title="禁止wordpresss的插件检查更新来提高后台打开速度。" rel="tooltip">说明</abbr></span></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[plugins-update]" class='tgl tgl-skewed' id="optimize_options[plugins-update]" type='checkbox' <?php if($youpzt_optimize_options['plugins-update']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[plugins-update]"></label></p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('禁止检查主题的更新。', 'optimize_switch'); ?><span class="info"><abbr title="禁止wordpresss的主题检查更新来提高后台打开速度。" rel="tooltip">说明</abbr></span></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[themes-update]" class='tgl tgl-skewed' id="optimize_options[themes-update]" type='checkbox' <?php if($youpzt_optimize_options['themes-update']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[themes-update]"></label></p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('禁用文章修订版本', 'optimize_switch'); ?><span class="info"><abbr title="建议开启加速" rel="tooltip">建议开启</abbr></span></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[revisions]" class='tgl tgl-skewed' id="optimize_options[revisions]" type='checkbox' <?php if($youpzt_optimize_options['revisions']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[revisions]"></label></p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Browse Happy', 'optimize_switch'); ?></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[browse-happy]" class='tgl tgl-skewed' id="optimize_options[browse-happy]" type='checkbox' <?php if($youpzt_optimize_options['browse-happy']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[browse-happy]"></label>
						</p>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('关闭自动保存草稿', 'optimize_switch'); ?></th>
				<td>
					<fieldset>
						<p><input name="optimize_options[autosave]" class='tgl tgl-skewed' id="optimize_options[autosave]" type='checkbox' <?php if($youpzt_optimize_options['autosave']==true){echo 'checked';};?>>
						<label class='tgl-btn' data-tg-off="关闭" data-tg-on="开启" for="optimize_options[autosave]"></label>
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
