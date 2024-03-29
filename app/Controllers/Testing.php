<?php

namespace App\Controllers;

class Testing extends BaseController
{
    // list all resources
    public function index()//: string
    {
        echo "Desde Testing Controller, metodo index()";
    }   
    // list a single resource
    public function show($arg1)//: string
    {
        echo "Desde Testing Controller, metodo show($arg1)";
        echo "<br><a href='/dashboard/pelicula'>Get Back</a>";
    }   
    // render form to create new resource
    public function new()//: string
    {
        echo "Desde Testing Controller, metodo new()";
    }   
    // render form to edit a resource
    public function edit($arg1)//: string
    {
        echo "Desde Testing Controller, metodo edit($arg1)";
    }   
}