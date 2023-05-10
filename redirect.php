<?php

$redirect = [
    '/ornek' => 'ornek',
  
    ];
    
    
    if(isset($_SERVER['SCRIPT_URL']) && isset($redirect[$_SERVER['SCRIPT_URL']])){
        
        
        header('Location: https://linktreclicksus.com/'.$redirect[$_SERVER['SCRIPT_URL']]);
        
        
    }