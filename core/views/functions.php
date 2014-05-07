<?php
// Вспомогательные фу-ции, используются в views
function printNavWidgets($title, $three, $parent = false)
{
	if(!empty($three))
	{
		if(!$parent) echo '<ul class="nav nav-list">'; else echo '<ul>';
		if(!$parent) echo '<li class="nav-header">' . $title . '<li>';
		foreach($three as $k => $v)
		{
			$url = Url::baseUrl("$v[full_url]");
			$isActive = Url::isActive($v['full_url']) ? 'class="active"' : null;

			echo "<li $isActive>"."<a href=\"$url\">{$v['title_in_menu']}</a>";

			printNavWidgets($title, $v['children'], true); 
			echo '</li>';
		}
		if(!$parent) echo '</ul>'; else echo '</ul>';
	}
}