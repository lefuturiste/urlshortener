<?php
namespace App;
class Time{
    public static function now($type = "SQL_DATETIME"){
        switch ($type){
            case "SQL_DATETIME":
                return date('Y-m-d H:i:s');
                break;
        }
    }

    public static function format($subject, $type = "NORMAL", $whole = false){
        $date = new \DateTime($subject);
        switch ($type){
            case "NORMAL":
                $temp = $date->format('j')." ".self::getMonth($date->format('n'), $whole, true)." ".$date->format('Y');
                break;
        }
        return $temp;
    }

    public static function getDay($id, $whole = false, $maj = false)
    {
        if ($whole == true){
            $days = [
                "1" => "lun",
                "2" => "mar",
                "3" => "mer",
                "4" => "jeu",
                "5" => "ven",
                "6" => "sam",
                "7" => "dim",
            ];
        }
        else{
            $days = [
                "1" => "lundi",
                "2" => "mardi",
                "3" => "mercredi",
                "4" => "jeudi",
                "5" => "vendredi",
                "6" => "samedi",
                "7" => "dimanche",
            ];
        }

        if ($maj == true) {
            return ucfirst($days[$id]);
        }
        else {
            return $days[$id];
        }
    }

    public static function getMonth($id, $whole = false, $maj = false)
    {
        if ($whole == true){
            $month = [
                "1" => "janv.",
                "2" => "fev.",
                "3" => "mars.",
                "4" => "avr.",
                "5" => "mai.",
                "6" => "juin.",
                "7" => "juil.",
                "8" => "août.",
                "9" => "sept.",
                "10" => "oct.",
                "11" => "nov.",
                "12" => "déc."
            ];
        }
        else{
            $month = [
                "1" => "janvier",
                "2" => "fevrier",
                "3" => "mars",
                "4" => "avril",
                "5" => "mai",
                "6" => "juin",
                "7" => "juillet",
                "8" => "août",
                "9" => "septembre",
                "10" => "octobre",
                "11" => "novembre",
                "12" => "décembre"
            ];
        }

        if ($maj == true) {
            return ucfirst($month[$id]);
        }
        else {
            return $month[$id];
        }
    }

    /*public function getAll(){
        $r = [];
        $date = '2011-04-19';
        $y = date('Y', $date);
        $m = date('m', $date);
        $d = date('d', $date);
        $w = str_replace('0', '7', date('w', $date));
        $r['']
    }*/
}

