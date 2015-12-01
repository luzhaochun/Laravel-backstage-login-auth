<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Backstage;

class ErrorController extends \App\Http\Controllers\Backstage\Controller{
    
    public function errorPage(){
        return view('backstage.error');
    }
    
    public function unauthorizPage(){
        return view('backstage.unauthorize');
    }
    
}
