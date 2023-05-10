<?php

$redirect = [
    '/ornek' => 'ornek2',
  
    ];
    
    
    if(isset($_SERVER['SCRIPT_URL']) && isset($redirect[$_SERVER['SCRIPT_URL']])){
        
        
        header('Location: https://domain.com/'.$redirect[$_SERVER['SCRIPT_URL']]);
        
        
    }
