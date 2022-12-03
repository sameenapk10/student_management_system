<?php

use Carbon\Carbon;

//function getPermissionsArray(){
//    if (session()->get('user-permissions'))
//        return session()->get('user-permissions');
//    if (auth()->check()){
//        session()->put('user-permissions', auth()->user()->getPermissionNames());
//        return session()->get('user-permissions');
//    }
//}

function get_extension($file) {
    $tmp = explode(".", $file);
    $extension = end($tmp);
    return $extension ? $extension : false;
}

function deleteFromArray($items, $array){
    if (gettype($items) == 'array'){
        foreach ($items as $item)
            if (($key = array_search($item, $array)) !== false) unset($array[$key]);
    } else {
        $item = $items;
        if (($key = array_search($item, $array)) !== false) unset($array[$key]);
    }
    return $array;
}
function logInFile($content, $label = '', $filename = NULL, $extra = array()){
    $filename = $filename ? $filename .= '.log' : date('Y-m-d').'.log';
    \Storage::prepend(
        'performance/'.$filename,
        Carbon::now()->format('Y-m-d H:i:s')
        .' '.json_encode($label, true)
        .' '.json_encode($content, true)
        .' '.json_encode($extra, true)
    );
}
function arrayToString($array): string {
    return "['".implode("', '", $array)."']";
}
function pageTitle():string{
    return config('app.name').
        ((request()->path() == '/') ? '':' | '. titleCase(request()->path()));
}
function titleCase(string $string): string {
    $string = str_replace('.', ' ', $string);
    $string = str_replace('-', ' ', $string);
    $string = str_replace('_', ' ', $string);
    return  Str::title($string);
}

function varDump($variable): void {
    // read backtrace
    $bt   = debug_backtrace();
    // read file
    $file = file($bt[0]['file']);
    // select exact print_var_name($varname) line
    $src  = $file[$bt[0]['line']-1];
    // search pattern
    $pat = '#(.*)'.__FUNCTION__.' *?\( *?(.*) *?\)(.*)#i';
    // extract $varname from match no 2
    $varName  = preg_replace($pat, '$2', $src);
    $varName = ltrim(trim($varName), '$');
    // print to browser
    match (gettype($variable)) {
        'array' => dump($varName, $variable),
        default => dump($varName.': '.$variable)
    };
}
function dumpOrIgnoreVar($variable): void {
    if (request()->wantsJson()) return;
    // read backtrace
    $bt   = debug_backtrace();
    // read file
    $file = file($bt[0]['file']);
    // select exact print_var_name($varname) line
    $src  = $file[$bt[0]['line']-1];
    // search pattern
    $pat = '#(.*)'.__FUNCTION__.' *?\( *?(.*) *?\)(.*)#i';
    // extract $varname from match no 2
    $varName  = preg_replace($pat, '$2', $src);
    // print to browser
    dump(ltrim(trim($varName), '$').': '.$variable);
}
function dumpOrIgnore($data): void {
    if (request()->wantsJson()) return;
    dump($data);
}
