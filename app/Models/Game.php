<?php

namespace App\Models;

use Core\Model;

class Game extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }

    private function random()
    {
        $result = [];
        $gen = rand(1111, 9999);

        return str_split($gen);

    }

    private function myNum($num)
    {
        return str_split($num);

    }

    public function match($mynum)
    {
        $cow = 0;
        $bull = 0;
        $result = [];
        $entry = $this->mynum($mynum);
        $engine = $this->random();


        for ($i = 0; $i < count($entry); $i++) {
            if ($this->myNum($mynum)[$i] == $engine[$i]) {
                $cow++;
            } else {
                if (in_array($entry[$i], $engine)) {
                    $bull++;
                }
            }
        }

        $result['cow'] = $cow;
        $result['bull'] = $bull;
        $result['entry'] = implode($entry);
        $result['engine'] = implode($engine);

        return $result;

    }
}