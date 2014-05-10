<?php
class Models_Gallery
{
	public function all()
	{
		return DB::select()->from('gallery')->execute();
	}

	public function get($id)
	{
		$res = DB::select()->from('gallery')->where('id_gallery', '=', $id)->execute();
		return $res[0];
	}

	public function add($data)
	{
		return DB::insert('gallery', $data)->execute();
	}

	public function edit($id, $data)
	{
		return DB::update('gallery')->set($data)->where('id_gallery', '=', $id)->execute();
	}

	public function addImage($idGallery, $idImage)
	{
		$data = array(
			'id_gallery' => $idGallery, 
			'id_image'   => $idImage
		);
		return DB::insert('gallery_images', $data)->execute();
	}

	public function getImages($idGallery)
	{
		return DB::select()
				->from('gallery_images')
				->leftJoin('images')->using('id_image')
				->where('id_gallery', '=', $idGallery)
				->execute();
	}

	public function deleteGallery($id)
	{
		DB::delete('gallery_images')->where('id_gallery', '=', $id)->execute();
		return DB::delete('gallery')->where('id_gallery', '=', $id)->execute();
	}
}