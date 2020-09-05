<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ImagePath
{
    public $imageFolder ='img';
    public function getDatePath()
    {
        $year = date('Y');
        $month = date('F');
        $day = date('d');
        return "$year/$month/$day";
    }

    public function nameNoExtension($name)
    {
        $target = explode('.',$name);
        $target = $target[0];
        return $target;

    }


}
