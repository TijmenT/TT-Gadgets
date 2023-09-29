<?php

function customFilter($data, $minLength, $maxLength, $dataType, $spacing, $specialChars, $lowerCase){
    if(strlen($data) < $minLength){
        return "Too short";
    }
    if(strlen($data) > $maxLength){
        return "Too long";
    }
    if($dataType == "int"){
        if(!is_numeric($data)){
            return "Not a number";
        }
    }
    if($dataType == "str"){
        if(!is_string($data)){
            return "Not a string";
        }
    }
    if($spacing == false){
        $data = str_replace(' ', '', $data);
    }
    if($lowerCase == true){
        $data = strtolower($data);
    }
    if($specialChars == false){
        $blacklistedChars = [
            "[",
            "]",
            ";",
            ":",
            "TRUNCATE",
            "DROP",
            "ALTER",
            "alter",
            "drop",
            "truncate",
            "'",
            '"',
            "=",
            ")",
            "(",
            "{",
            "}",

        ];
        foreach($blacklistedChars as $char){
            if(strpos($data, $char) !== false){
                return "Blacklisted Char found";
            }
        }
    }
    return $data;
}

echo customFilter("RANDOM", 1, 10, "str", false, false, true);

?>
