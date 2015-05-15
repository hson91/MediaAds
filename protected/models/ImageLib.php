<?php
    class ImageLib {
        public $image;
        public $image_type;
        public $image_ext;
        public function load($filename) {
            $image_info = getimagesize($filename);
            $this->image_type = $image_info[2];
            if ($this->image_type == IMAGETYPE_JPEG) {
                $this->image_ext = 'jpg';
                $this->image = imagecreatefromjpeg($filename);
            } elseif ($this->image_type == IMAGETYPE_GIF) {
                $this->image_ext = 'gif';
                $this->image = imagecreatefromgif($filename);
            } elseif ($this->image_type == IMAGETYPE_PNG) {
                $this->image_ext = 'png';
                $this->image = imagecreatefrompng($filename);
            }
        }
        
        public function getColorOnImage($x, $y){
            $rgb = imagecolorat ($this->image, $x, $y );
            $colors = imagecolorsforindex($this->image, $rgb);
            return $colors;
        }
        
        public function getColorOnImageInt($x, $y){
            $rgb = imagecolorat ($this->image, $x, $y );
            return $rgb;
        }
        
        ////////////////////////////////////////IMAGE RESIZE/////////////////////////////////////////////////
        public function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 100, $permissions = null){
            if ($image_type == IMAGETYPE_JPEG) {
                imagejpeg($this->image, $filename, $compression);
            } elseif ($image_type == IMAGETYPE_GIF) {
                imagegif($this->image, $filename, $compression);
            } elseif ($image_type == IMAGETYPE_PNG) {
                imagepng($this->image, $filename, $compression);
            }
            if ($permissions != null) {
                chmod($filename, $permissions);
            }
        }
        
        public function upload($file, $filename){
            move_uploaded_file($file, $filename);
        }
        
        public function output($image_type = IMAGETYPE_JPEG) {
            if ($image_type == IMAGETYPE_JPEG) {
                imagejpeg($this->image);
            } elseif ($image_type == IMAGETYPE_GIF) {
                imagegif($this->image);
            } elseif ($image_type == IMAGETYPE_PNG) {
                imagepng($this->image);
            }
        }
        public function getWidth() {
            return imagesx($this->image);
        }
        public function getHeight() {
            return imagesy($this->image);
        }
        public function resizeToHeight($height) {
            $ratio = $height / $this->getHeight();
            $width = $this->getWidth() * $ratio;
            $this->resize($width, $height);
        }
        public function resizeToWidth($width) {
            $ratio = $width / $this->getWidth();
            $height = $this->getheight() * $ratio;
            $this->resize($width, $height);
        }
        public function scale($scale) {
            $width = $this->getWidth() * $scale / 100;
            $height = $this->getheight() * $scale / 100;
            $this->resize((int)$width, (int)$height);
        }
        public function resize($width, $height) {
            $new_image = imagecreatetruecolor($width, $height);
            imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, 
			$this->getWidth(), $this->getHeight());
            $this->image = $new_image;
        }
        ///////////////////////////////////////////////////////IMAGE PAINT/////////////////////////////////////////////
        public function paintImage($width, $height,$file_name,$image_type = IMAGETYPE_JPEG){
            $images = imagecreate($width,$width);
            if(($this->getWidth()/$width) > ($this->getHeight()/$height)){
                $this->resizeToWidth($width);
            }else{
                $this->resizeToHeight($height);
            }
            $this->save($file_name,$image_type);
        }
        //Cái này cắt hình làm đại diện
        public function getSliceImage($width, $height,$file_name, $image_quality = 100, $image_type = IMAGETYPE_JPEG){
            $dest = imagecreatetruecolor($width, $height);
            if(($this->getWidth()/$width) > ($this->getHeight()/$height)){
                $this->resizeToHeight($height);
                imagecopy($dest, $this->image, 0, 0, ($this->getWidth() - $width)/2,0,$width, $height);
            }else{
                $this->resizeToWidth($width);
                imagecopy($dest, $this->image, 0, 0, 0,($this->getHeight() - $height)/2,$width, $height);
            }
            if ($image_type == IMAGETYPE_JPEG) {
                imagejpeg($dest, $file_name, $image_quality);
            } elseif ($image_type == IMAGETYPE_GIF) {
                imagegif($dest, $file_name, $image_quality);
            } elseif ($image_type == IMAGETYPE_PNG) {
                imagepng($dest, $file_name, $image_quality);
            }
            imagedestroy($dest);
        }
        
        public function getGrayImage($width, $height, $file_name, $image_quality = 100, $image_type = IMAGETYPE_JPEG){
            $dest = imagecreatetruecolor($width, $height);
            if(($this->getWidth()/$width) > ($this->getHeight()/$height)){
                $this->resizeToHeight($height);
                imagecopy($dest, $this->image, 0, 0, ($this->getWidth() - $width)/2,0,$width, $height);
            }else{
                $this->resizeToWidth($width);
                imagecopy($dest, $this->image, 0, 0, 0,($this->getHeight() - $height)/2,$width, $height);
            }
            imagefilter($dest, IMG_FILTER_GRAYSCALE);
            if ($image_type == IMAGETYPE_JPEG) {
                imagejpeg($dest, $file_name, $image_quality);
            } elseif ($image_type == IMAGETYPE_GIF) {
                imagegif($dest, $file_name, $image_quality);
            } elseif ($image_type == IMAGETYPE_PNG) {
                imagepng($dest, $file_name, $image_quality);
            }
        }
        //Cái này thêm vào khoảng trống cho đủ
        public function paintNewImage($width, $height,$file_name,$image_type = IMAGETYPE_JPEG){
            $dest = imagecreatetruecolor($width, $height);
            $colors = $this->getColorOnImage(1,1);
            $color = imagecolorallocate($dest, $colors['red'], $colors['green'], $colors['blue']);
            $color = imagecolorallocate($dest, 255, 255, 255);
            imagefill($dest, 0, 0, $color);
            if(($this->getWidth()/$width) > ($this->getHeight()/$height)){
                $this->resizeToWidth($width);
                imagecopymerge($dest,$this->image,0,($height-$this->getHeight())/2,0,0,$this->getWidth(),$this->getHeight(),100);
            }else{
                $this->resizeToHeight($height);
                imagecopymerge($dest,$this->image,($width-$this->getWidth())/2,0,0,0,$this->getWidth(),$this->getHeight(),100);
            }
            if ($image_type == IMAGETYPE_JPEG) {
                imagejpeg($dest, $file_name,100);
            } elseif ($image_type == IMAGETYPE_GIF) {
                imagegif($dest, $file_name,100);
            } elseif ($image_type == IMAGETYPE_PNG) {
                imagepng($dest, $file_name,100);
            }
            imagedestroy($dest);
        }
        //Cái này cắt 1 phần của hình
        public function cutAPartImage($width, $height, $file_name){
            $dest = imagecreatetruecolor($width, $height);
            imagecopy($dest,$this->image,0,0,($this->getWidth()-$height)/2, ($this->getHeight()-$height)/2,$height,$height);
            imagejpeg($dest, $file_name,100);
            imagedestroy($dest);
        }
        
        public function __destruct() {
            if($this->image){
                imagedestroy($this->image);
            }
        }

    }
?>