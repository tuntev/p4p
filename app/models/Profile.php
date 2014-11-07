<?php
/**
 * Created by PhpStorm.
 * User: tunte
 * Date: 11/7/14
 * Time: 1:50 PM
 */
class Profile extends Eloquent {

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('User');
    }

}