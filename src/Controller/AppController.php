<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
     // Méthode permettant de receptionner l'adresse envoyé par le front
    public function getInitialAdress() : String
    {
        
        // Vérifier si le formulaire est soumis 
        if ( isset( $_GET['adress']) ) {
            // Retourner l'adresse récupéré en get 
            return $_GET['adress']; 
        } else {
            return "27 Bd de Stalingrad, 44041 Nantes";
        }
    }

}