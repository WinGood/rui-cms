<?php
class Models_Gallery extends Models_Base
{
	public function __construct()
	{
		parent::__construct('gallery', 'id_gallery');
	}

	public function addImage($idGallery, $idImage)
	{
		return DB::getInstance()->insert('gallery_images', array(
			'id_gallery' => $idGallery, 
			'id_image'   => $idImage
		));
	}

	public function getImages($idGallery)
	{
		return DB::getInstance()->select("
			SELECT * FROM gallery_images
			LEFT JOIN images using(id_image)
			WHERE id_gallery = $idGallery
			");
	}

	public function deleteGallery($id)
	{
		$where = "id_gallery = $id";
		DB::getInstance()->delete('gallery_images', $where);
		return DB::getInstance()->delete('gallery', $where);
	}
}