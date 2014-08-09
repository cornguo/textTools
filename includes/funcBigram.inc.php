<?php
function isEngWord($word)
{
    if(preg_match('/[\p{Ll}|\p{Lm}|\p{Lt}|\p{Lu}|\p{N}|\p{Pd}|\.]/ui', $word)) return true;
    else return false;
}

function normEngWord($string)
{
    $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
    $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");
    return str_replace($search, $replace, strtolower($string));
}

function getBigramArray($string)
{
    $outArr = array();
    $arr = getStringArray(preProcess($string));
    if(count($arr) == 1)
    {
//        debug("bigram:: getBigramArray: only one item in array, return as intact");
        if($arr[0] != ',') return $arr;
        else return $outArr;
    }
    for($i = 0; $i < count($arr); $i++)
    {
        if(isEngWord($arr[$i])) $outArr[] = $arr[$i];
        else if(isset($arr[$i+1]) && !isEngWord($arr[$i+1]))
        {
            if($i == 0 && $arr[$i+1] == ',') $outArr[] = $arr[0];
            if($arr[$i] == ',' && ((isset($arr[$i+2]) && $arr[$i+2] == ',') || !isset($arr[$i+2]))) $outArr[] = $arr[$i+1];
            else if($arr[$i] != ',' && $arr[$i+1] != ',') $outArr[] = "{$arr[$i]}{$arr[$i+1]}";
        }
    }
/*    if(DEBUG)
    {
        debug("getBigramArray::");
        echo "<!--\n";
        print_r($outArr);
        echo "-->\n";
    }
*/    return $outArr;
}

function getStringArray($string)
{
    $arr = array();

    while($string != null)
    {
        $garbage = array("_", "[","]","　");
        $string = str_replace($garbage, "", ltrim(rtrim($string)));
        $char = $string[0];
        if(isset($string[1])) $next = $string[1];
        if(isEngWord($char) && isEngWord($next)) // if is english
        {
            preg_match('/([\p{Ll}|\p{Lm}|\p{Lo}|\p{Lt}|\p{Lu}|\p{N}|\.]+)/ui', $string, $match);
            $arr[] = $match[1];
            $string = substr($string, strlen($match[0]));
        }
        else
        {
            $str = mb_substr($string, 0, 1, 'UTF-8');
            if($str != ".") $arr[] = $str;
        //    else if(is_numeric($arr[count($arr)-1])) $arr[count($arr)-1] .= ".";
            $string = mb_substr($string, 1, 9999, 'UTF-8');
        }
    }
/*    if(DEBUG)
    {
        debug("bigram:: getStringArray:");
        echo "<!--\n";
        print_r($arr);
        echo "-->\n";
    }
*/
    return $arr;
}

function preProcess($string, $normalOut = 0)
{
    $string = ltrim(rtrim($string));
    $string = normEngWord(html_entity_decode($string, ENT_QUOTES, 'UTF-8'));
//    $pattern = array("/[\p{C}|\p{M}|\p{N}|\p{P}|\p{S}\p{Z}]+/Uu", "/([a-z]+)/i");
//    $replace = array(",", ",$1,");
    $pattern = array("/([\p{N}]+)\.([\p{N}]+)/Uu", "/([\p{N}]+)/u", "/[\p{C}|\p{M}|\p{P}|\p{S}\p{Z}]+/Uu", "/([a-z]+)/i", "/([\p{N}]+),,DOT,([\p{N}]+)/Uu");
    $replace = array("$1DOT$2", "$1 ", ",", ",$1,", "$1.$2");
    $strip = preg_replace($pattern, $replace, $string);
    $output = preg_replace("/,,+/", ",", urldecode($strip));
    if($normalOut == 1)
    {
        $output = preg_replace("/([0-9a-z]),([0-9a-z])/", "$1 $2", $output);
        $output = str_replace(',', '', $output);
    }
//    debug("bigram:: preProcess: string [$string] is rewritten to [$output]");
    return $output;
}

?>
