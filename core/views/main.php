<? RUI::seoMeta($data); ?>
<div <?=RUI::frontContent('page', $data)?>>
<?=$breadcrumbs;?>
<h3 <?=RUI::frontField('title', 'input');?>><?=$data['title'];?></h3>
	<div class="well clearfix" <?=RUI::frontField('content', 'ck');?>>
		<?=$data['content'];?>
	</div>
</div>