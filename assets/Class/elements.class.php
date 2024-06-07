<?php

namespace Elements;

class Element
{
    public function button($class, $id, $name)
    {
        return '<div class="col-sm-4 ' . $class . '" id="' . $id . '"><div class="card card-body text-center bg-primary"><h4 class="card-title text-light">' . $name . '</h4></div></div>';
    }

    public function addbutton($target, $name)
    {
        return '<div class="col-sm-4" data-bs-toggle="modal" data-bs-target="#' . $target . '"> <div class="card card-body text-center bg-success"> <h4 class="card-title text-light"><i class="bx bx-plus-circle"></i> ' . $name . '</h4> </div> </div>';
    }

    public function form($form,$input){
        return '<form id="'.$form.'" method="post"><input type="hidden" name="'.$input.'" id="'.$input.'" value="'.@$_POST[$input].'"></form>';
    }
}