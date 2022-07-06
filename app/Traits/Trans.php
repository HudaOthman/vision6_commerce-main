<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait Trans {

    public function getTransNameAttribute()
    {
        $name = json_decode($this->name, true);
        // dump($name);
        if(!$name) {
            $name = '';
        }else {
            $name = $name[App::CurrentLocale()];
        }
        return $name;
    }

    public function getNameEnAttribute()
    {
        if($this->name) {
            return json_decode($this->name, true)['en'];
        }

        return '';
    }

    public function getNameArAttribute()
    {
        if($this->name) {
            return json_decode($this->name, true)['ar'];
        }

        return '';
    }


    // Descriptuion
    public function getTransDescriptionAttribute()
    {
        $description = json_decode($this->description, true);
        // dump($description);
        if(!$description) {
            $description = '';
        }else {
            $description = $description[App::CurrentLocale()];
        }
        return $description;
    }

    public function getDescriptionEnAttribute()
    {
        if($this->description) {
            return json_decode($this->description, true)['en'];
        }

        return '';
    }

    public function getDescriptionArAttribute()
    {
        if($this->description) {
            return json_decode($this->description, true)['ar'];
        }

        return '';
    }

}
