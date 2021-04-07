<?php

  /**
   * This class is for validating images.
   */
  class Validate_Image
  {

    private $filesArray;
    private $imageKey;
    private $allowedImageTypes;

    public function __construct($FilesArray, $imageKey, $allowedImageTypes)
    {
      $this->filesArray = $FilesArray;
      $this->imageKey = $imageKey;
      $this->allowedImageTypes = $allowedImageTypes;
    }

    public function hasFile(){

      switch ($this->filesArray[$this->imageKey]['error']) {
        case '4':
          return false;
          break;

        default:
          return true;
          break;
      }

    }

    public function isImage(){

      $result = true;

      if (exif_imagetype($this->filesArray[$this->imageKey]["tmp_name"]) === false) {
        $result = false;
      }

      return $result;
    }

    public function isValidType(){

      if ($this->isImage()) {
        $imageType = image_type_to_mime_type(exif_imagetype($this->filesArray[$this->imageKey]["tmp_name"]));

        if (in_array($imageType, $this->allowedImageTypes)) {
          return true;
        }
        else {
          return false;
        }
      }
      else{
        return false;
      }

    }

    public function debugData(){
      echo "<pre>";
      print_r($this->filesArray);
      echo "</pre>";
    }


  }


 ?>
