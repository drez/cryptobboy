<?php

namespace Asset;

class Sync
{
    function __construct()
    {
        $Assets = AssetQuery::create()->find();

    }
    
}