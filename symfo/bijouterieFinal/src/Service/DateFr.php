<?php

namespace App\Service;


class DateFr
{

    public function moisFr($leMois)
    {


        switch($leMois)
        {

            case 1 :
            $leMois = "Janvier";
            break;

            case 2 :
            $leMois = "Février";
            break;

            case 3 :
            $leMois = "Mars";
            break;                

            case 4 :
            $leMois = "Avril";
            break;   

            case 5 :
            $leMois = "Mai";
            break;
    
            case 6 :
            $leMois = "Juin";
            break;
    
            case 7 :
            $leMois = "Juillet";
            break;                
    
            case 8 :
            $leMois = "Août";
            break;    

            case 9 :
            $leMois = "Septembre";
            break;

            case 10 :
            $leMois = "Octobre";
            break;

            case 11 :
            $leMois = "Novembre";
            break;                

            case 12 :
            $leMois = "Décembre";
            break;    

            default;


        }

        return $leMois;

    }

}