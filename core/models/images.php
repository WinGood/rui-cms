<?php
class Models_Images
{
	public function uploadBase64($name, $value)
	{
		if(!$this->checkType($name)) return false;
		
		$getMime = explode('.', $name);
		$mime = strtolower(end($getMime));
		$filename = mt_rand(0, 10000000) . '.' . $mime;

		while(file_exists(GALLERY_DIR_BIG . $filename))
			$filename = mt_rand(0, 10000000) . '.' . $mime;

		$data = array('path' => $filename);

		$id = DB::insert('images', $data)->execute();

		$this->moveUploadBase64($value, $filename);
		return $id;
	}

	public function delete($id_image)
	{
		$id_image = (int)$id_image;
		$one = $this->get($id_image);

		$this->delete($id_image);
		
		$filename = $one[0]['path'];
		
		if(file_exists(GALLERY_DIR_BIG . $filename))
			unlink(GALLERY_DIR_BIG . $filename);
			
		if(file_exists(GALLERY_DIR_SMALL . $filename))
			unlink(GALLERY_DIR_SMALL . $filename);
			
		return true;
	}
	
	private function checkType($name)
	{
		$getMime = explode('.', $name);
		$mime = strtolower(end($getMime));
		$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
		return in_array($mime, $types);
	}
	
	private function moveUploadBase64($file, $name) 
	{ 
		$data = explode(',', $file);
		
		$encodedData = str_replace(' ','+',$data[1]);
		$decodedData = base64_decode($encodedData);

		if(file_put_contents(GALLERY_DIR_BIG . $name, $decodedData)){
			$this->resize(GALLERY_DIR_BIG . $name, GALLERY_DIR_SMALL . $name, IMG_SMALL_WIDTH);
			return true;
		}
		
		return false;
	}
	
	private function resize($src, $dest, $width, $height = null, $rgb = 0xFFFFFF, $quality = 100)
    {
      if (!file_exists($src)) return false;

      $size = getimagesize($src);

      if ($size === false) return false;

      $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
      $icfunc = "imagecreatefrom" . $format;
      if (!function_exists($icfunc)) return false;
		
      $x_ratio = $width / $size[0];
	  
	  if($height === null)
			$height = $size[1] * $x_ratio;
	  
      $y_ratio = $height / $size[1];

      $ratio       = min($x_ratio, $y_ratio);
      $use_x_ratio = ($x_ratio == $ratio);

      $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
      $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
      $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
      $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

      $isrc = $icfunc($src);
      $idest = imagecreatetruecolor($width, $height);

      imagefill($idest, 0, 0, $rgb);
      imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0,
        $new_width, $new_height, $size[0], $size[1]);

      imagejpeg($idest, $dest, $quality);

      imagedestroy($isrc);
      imagedestroy($idest);

      return true;
    }
}