<?php
class ImagickPacker {
 protected $imagick;
 
 public function __construct(Imagick $imagick, $clone = true) {
  if($clone) $this->imagick = $imagick->clone(); else $this->imagick = $imagick;
  $this->sortImages();
  $this->packImages($this->boundingBox());
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

 protected function packImages(Imagick $bound) {
  $this->imagick->setFirstIterator();
  do {
   
  } while($this->imagick->hasNextImage() && $this->imagick->nextImage());
 }

 protected function boundingBox() {
  $width = 0;
  $height = 0;
  $this->imagick->setFirstIterator();
  do {
   $width += $this->imagick->getImageWidth();
   $tmpHeight = $this->imagick->getImageHeight();
   if($tmpHeight > $height) $height = $tmpHeight;
  } while($this->imagick->hasNextImage() && $this->imagick->nextImage());
  $result = new Imagick();
  $result->newImage($width, $height, "none");
 }
}
?>
