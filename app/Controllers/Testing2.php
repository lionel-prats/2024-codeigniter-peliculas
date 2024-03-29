<?php

namespace App\Controllers;

class Testing2 extends BaseController
{
    // list all resources
    public function index()//: string
    {
        echo "Desde Testing2 Controller, metodo index()";
    }   
    // list a single resource
    public function show($arg1)//: string
    {
        echo "Desde Testing2 Controller, metodo show($arg1)";
    }   
    // render form to create new resource
    public function new()//: string
    {
        echo "Desde Testing2 Controller, metodo new()";
        echo "<br><a href='/dashboard/pelicula'>Get Back</a>";
    }   
    // render form to edit a resource
    public function edit($arg1)//: string
    {
        echo "Desde Testing2 Controller, metodo edit($arg1)";
    }   
    // render form to edit a resource
    public function remove($arg1)//: string
    {
        echo "Desde Testing2 Controller, metodo remove($arg1)";
    }   
}