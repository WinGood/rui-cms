<h3>Редактирование меню "<?=$fields['title'];?>"</h3>
<div class="span8">
	<div class="well">
	<?=Url::getFlash('error');?>
	  <form action='<?=$_SERVER['REQUEST_URI'];?>' method="POST" class="form-horizontal form-menu">
	    <div class="control-group">
	      <label class="control-label" for="inputTitle">Название</label>
	      <div class="controls">
	        <input type="text" name="title" id="inputTitle" class="input-xlarge" value="<?=isset($fields['title']) ? $fields['title'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputCode">Код</label>
	      <div class="controls">
	        <input type="text" name="code" id="inputCode" class="input-xlarge" value="<?=isset($fields['code']) ? $fields['code'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputEl">Элементы</label>
	      <div class="controls">
	      	<div class="clearfix">
	      		<div class="column box-content">
	      			<?if(!empty($fields['widgets'])):?>
	      			<?foreach($fields['widgets'] as $item):?>
	      				<?if(!empty($widgets_list)):?>
	      					<?foreach($widgets_list as $widget):?>
	      					<?if($widget['id_widget'] == $item):?>
	      					<div class="portlet" data-widget-id="<?=$widget['id_widget']?>">
	      						<div class="portlet-header"><?=$widget['name_in_menu']?></div>
	      						<div class="portlet-content"><?=$widget['description']?></div>
	      					</div>
	      					<?endif;?>
	      					<?endforeach;?>
	      				<?endif;?>
	      			<?endforeach;?>
	      			<?endif;?>
	      		</div>	 
	      		<div class="column">
	      			<?if(!empty($widgets_list)):?>
	      			<?foreach($widgets_list as $item):?>
	      			<div class="portlet" data-widget-id="<?=$item['id_widget']?>">
	      				<div class="portlet-header"><?=$item['name_in_menu']?></div>
	      				<div class="portlet-content"><?=$item['description']?></div>
	      			</div>
	      			<?endforeach;?>
	      			<?endif;?>
	      		</div>
	      		<input type="hidden" name="widgets" value="">
	      	</div>
	      </div>
	    </div>
	    <div class="control-group">
	      <div class="controls">
	        <button type="submit" class="btn btn-primary">Обновить меню</button>
	      </div>
	    </div>
	  </form>
	</div>
</div>