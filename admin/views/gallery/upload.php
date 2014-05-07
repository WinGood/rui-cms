<h3>Изображения галереи <a href='<?=Url::baseUrl("admin/gallery/images/$fields[id_gallery]");?>'>"<?=$fields['title'];?>"</a></h3>
<div class="span8">
	<div id="usersettings">
		<div id="drop-files" ondragover="return false">
			<p>Перенесите файлы сюда</p>
			<br>
	        <form id="frm">
	        	<input type="file" id="uploadbtn" multiple>
				<input type="hidden" name="id_gallery" value="<?=$fields['id_gallery']?>">
	        </form>
		</div>
	    <!-- Область предпросмотра -->
		<div id="uploaded-holder"> 
			<div id="dropped-files">
	        	<!-- Кнопки загрузить и удалить, а также количество файлов -->
	        	<div id="upload-button">
	                	<span>0 файлов</span>
						<button type="button" class="upload btn btn-success">Загрузить</button>
						<button type="button" class="delet btn btn-danger">Удалить все</button>
	                    <!-- Прогресс бар загрузки -->
	                	<div id="loading">
							<div id="loading-bar">
								<div class="loading-color"></div>
							</div>
							<div id="loading-content"></div>
						</div>
				</div>  
	        </div>
		</div>
		<div class="clear"></div>
		<!-- Список загруженных файлов -->
		<div id="file-name-holder">
			<ul id="uploaded-files">
				<h4>Загруженные файлы</h4>
			</ul>
		</div>
	</div>
</div>