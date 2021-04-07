<?php

  /**
   *  This class will handle $_POST data and sanitize it.
   */
  class Validate
  {

    private $formData;
    private $booleanArray;

    public function __construct($POST){
      $this->formData = $POST;
    }

    public function cleanData(){
      foreach ($this->formData as $key => $value) {
        $this->formData[$key] = filter_var(trim($value), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $this->booleanArray[$key] = empty($formData[$key]);
      }
    }

    public function getBoolArray(){
      return $this->booleanArray;
    }

    public function getCleanedData(){
      return $this->formData;
    }

    public function getFormVar($key){
      return $this->formData[$key];
    }

    public function getValidationMessage(){

      $message = "";
      if (in_array(true, $this->booleanArray)) {
        $message = "ERROR: The following fields were found empty: ";
        foreach ($this->booleanArray as $key => $value) {
          if ($value) {
            $message .= "\\n" . ucfirst($key);
          }
        }
        $message .= "\\n\\nForm Rejected";
      }

      return $message;

    }

    public function debugData(){
      echo "<h2> Cleaned Form Data </h2>";
      echo "<pre>";
      echo print_r($this->formData);
      echo "</pre>";
      echo "<h2> Boolean Array </h2>";
      echo "<pre>";
      echo print_r($this->booleanArray);
      echo "</pre>";
    }

  }


 ?>
