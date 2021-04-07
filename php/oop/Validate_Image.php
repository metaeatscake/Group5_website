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

      $result = false;

      if ($this->isImage() &&
        in_array(
          image_type_to_mime_type(exif_imagetype($this->filesArray[$this->imageKey]["tmp_name"])),
          $this->allowedImageTypes
        )
      ) {
        $result = true;
      }

      return $result;

    }

    public function getValidationMessage(){
      $message = "";

      $message = ($this->isImage())? "":"ERROR: This file is not an image.";
      $message = ($this->isValidType())? "":"ERROR: This image file type is not accepted.";

      return $message;
    }

    public function getFileExtension(){
      return pathinfo($this->filesArray[$this->imageKey]["name"], PATHINFO_EXTENSION);
    }

    public function debugData(){
      echo "<h2> Files Array </h2>";
      echo "<pre>";
      print_r($this->filesArray);
      echo "</pre>";
    }


  }


 ?>
