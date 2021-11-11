<?php

function success($message,$data){
    return response()->json([
        "status"=>"success",
        "message"=>$message,
        "data"=>$data,
    ]);
}
function fail($message){
    return response()->json([
        "status"=>"fail",
        "message"=>$message,
    ]);
}