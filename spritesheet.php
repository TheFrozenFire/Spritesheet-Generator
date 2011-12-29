<?php
class spritesheet {
 public $imagick;
 
 public function __construct($paths) {
  $this->imagick = new Imagick($paths);
 }

 public function outputImage($return = false, $stack = false, $format = "png", $mime = "image/png") {
  $sheet = $this->imagick->appendImages($stack);
  if($return = false) {
   $sheet->setImageFormat($format);
   header("Content-type: {$mime}");
   echo $sheet->getImageBlob();
  } else return $sheet;
 }

 public function outputCSS($return = false, $stack = false, $spritesheet = "sprites.png") {
  $css = "";
  
  $this->imagick->setFirstIterator();
  $offset = 0;
  $iterator = 1;
  do {
   $name = pathinfo($this->imagick->getImageFilename(), PATHINFO_FILENAME);
   $name = str_replace(".", "-", $name);
   if(!is_string($name)) {
    $name = "sprite-{$iterator}";
    $iterator++;
   }

   $width = $this->imagick->getImageWidth();
   $height = $this->imagick->getImageHeight();
   if(!$stack) {
    $x = $offset;
    $offset += $width;
    $y = 0;
   } else {
    $y = $offset;
    $offset += $height;
    $x = 0;
   }
   
   $css .= <<<CSS
.{$name} {
 background: url('{$spritesheet}') no-repeat {$x} {$y};
 width: {$width}px;
 height: {$height}px;
}

CSS;
  } while($this->imagick->hasNextImage() && $this->imagick->nextImage());

  if($return) return $css; else echo $css;
 }

 protected function sortImages() {
  $this->imagick->setFirstIterator();
  $images = array();
  do {
   $images[$this->imagick->current()] = $this->imagick->getImageHeight();
  } while($this->imagick->hasNextImage() && $this->imagick->nextImage());

  $this->imagick = new Imagick();
  arsort($images);
  foreach($images as $image => $height) $this->imagick->addImage($image);
 }
}
?>
