<h3>Редактирование страницы "<?=$fields['title'];?>"</h3>
<div class="span8">
	<div class="well">
	<?=Url::getFlash('error');?>
	  <form action='<?=$_SERVER['REQUEST_URI'];?>' method="POST" class="form-horizontal form-sorting">
	    <div class="control-group">
	      <label class="control-label" for="inputTitle">Название</label>
	      <div class="controls">
	        <input type="text" name="title" id="inputTitle" class="input-xlarge" value="<?=isset($fields['title']) ? $fields['title'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputInMenuTitle">Название в меню</label>
	      <div class="controls">
	        <input type="text" name="title_in_menu" id="inputInMenuTitle" class="input-xlarge" value="<?=isset($fields['title_in_menu']) ? $fields['title_in_menu'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputUrl">Адрес</label>
	      <div class="controls">
	        <input type="text" name="url" id="inputUrl" class="input-xlarge" value="<?=isset($fields['url']) ? $fields['url'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputCategory" class="input-xlarge">Родитель</label>
	      <div class="controls">
	        <select id="inputCategory" name="id_parent" class="input-medium">
	        	<option value="0">Без родителя</option>
	        	<?printOptionTree($three, $fields['id_parent']);?>
	        </select>
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="replace">Текст</label>
	      <div class="controls">
	        <textarea id="replace" name="content" rows="6" class="input-xlarge"><?=isset($fields['content']) ? $fields['content'] : null;?></textarea>
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputMenu" class="input-xlarge">Меню</label>
	      <div class="controls">
	      	<?if(!empty($menu)):?>
	        <select id="inputMenu" name="id_menu" class="input-medium">
	        	<?foreach($menu as $item):?>
	        	<option <?=$item['id_menu'] == $fields['id_menu'] ? 'selected' : null;?> value="<?=$item['id_menu'];?>"><?=$item['title'];?></option>
	        	<?endforeach;?>
	        </select>
	        <?endif;?>
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputTpl" class="input-xlarge">Шаблон</label>
	      <div class="controls">
	      	<select name="id_tpl" id="inputTpl">
	      		<option value="0">Отсутствует</option>
	      		<?foreach($tpl as $file):?>
	      		<option <?=$file['id_tpl'] == $fields['id_tpl'] ? 'selected' : null;?> value="<?=$file['id_tpl'];?>"><?=$file['name'];?></option>
	      		<?endforeach;?>
	      	</select>
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputSeoTitle" class="input-xlarge">SEO заголовок</label>
	      <div class="controls">
	        <input type="text" name="metaTitle" id="inputSeoTitle" class="input-xlarge" value="<?=isset($fields['metaTitle']) ? $fields['metaTitle'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputSeoKey" class="input-xlarge">SEO ключ.слова</label>
	      <div class="controls">
	        <input type="text" name="metaKeywords" id="inputSeoKey" class="input-xlarge" value="<?=isset($fields['metaKeywords']) ? $fields['metaKeywords'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputSeoDesc" class="input-xlarge">SEO описание</label>
	      <div class="controls">
	        <input type="text" name="metaDescription" id="inputSeoDesc" class="input-xlarge" value="<?=isset($fields['metaDescription']) ? $fields['metaDescription'] : null;?>">
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="inputIsShow" class="input-xlarge">Показывать?</label>
	      <div class="controls">
	        <input type="checkbox" name="is_show" id="inputIsShow" class="input-xlarge" <?=isset($fields['is_show']) ? 'checked' : null;?> value="1">
	      </div>
	    </div>
	    <div class="control-group">
	      <div class="controls">
	        <button type="submit" class="btn btn-primary">Обновить страницу</button>
	      </div>
	    </div>
	  </form>
	</div>
</div>