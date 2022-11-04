<?php

namespace App\Entity;

class SearchFilter{

      private ?string $metier = null;
      private ?string $codePostal = null;

      public function getMetier(){
            return $this->metier; 
      }
      
      public function setMetier($metier){
            return $this->metier = $metier;
      }

      public function getCodePostal(){
            return $this->codePostal;
      }

      public function setCodePostal($codePostal){
            return $this->codePostal = $codePostal;
      }
}