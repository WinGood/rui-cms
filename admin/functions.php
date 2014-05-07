<?php
// Второстепенные функции админки
function printOptionTree($three, $idPage = null, $shift = 0)
{
	if(!empty($three))
	{
		foreach($three as $section)
		{
			?><option value="<?=$section['id_page']?>"
			<? if($idPage == $section['id_page'])
				echo 'selected'; ?>
			>
			<? for($i = 0; $i < $shift; $i++)echo '-';?>
			<?=$section['title']?></option><?
			printOptionTree($section['children'], $idPage, $shift + 1); 
		}
	}
}