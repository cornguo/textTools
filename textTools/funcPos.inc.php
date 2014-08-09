<?php
require_once("funcBigram.inc.php");
require_once("funcNormText.inc.php");

function stripPOS($POSText)
{
	if(is_array($POSText))
	{
		$output = "";
		foreach($POSText['text'] as $tokN => $token)
		{
			$output .= $token;
			if(isset($POSText['text'][$tokN+1]) && (
				($POSText['tag'][$tokN] == "FW" || $POSText['tag'][$tokN] == "Neu") &&
				($POSText['tag'][$tokN+1] == "FW" || $POSText['tag'][$tokN+1] == "Neu")
			)) $output .= " ";
		}
		return $output;
	}
	else
	{
		$patternPOS = array('/\(FW\) ([a-z0-9])/U', '/\([a-zA-Z0-9_]+\) ?/');
		$replacePOS = array(' $1', '');
		return preg_replace($patternPOS, $replacePOS, $POSText);
	}
}

function getBIOPosArr($POSArr, $normText = true)
{
	$outArr = array('text' => array(), 'tag' => array(), 'pos2idx' => array());
	$charN = 0;
	foreach($POSArr['text'] as $tokN => $tokData)
	{
		$sCharList = array();
		preg_match_all("/(.)/u", $tokData, $sCharList);
		$tokTag = $POSArr['tag'][$tokN];

		foreach($sCharList[0] as $sN => $sChar)
		{
			if($normText == true) $outArr['text'][$charN] = normText($sChar);
			else $outArr['text'][$charN] = $sChar;
//echo "text: [{$sChar}], norm: [{$outArr['text'][$charN]}], {$tokTag}\n";
			if($sN == 0) $outArr['tag'][$charN] = "B-{$tokTag}";
			else $outArr['tag'][$charN] = "I-{$tokTag}";
			$charN ++;
		}
	}
	$pos = 0;
	foreach($outArr['text'] as $oN => $oD)
	{
		$outArr['pos2idx'][$pos] = $oN;
		$pos += strlen($oD);
	}
	return $outArr;
}

function POS2Array($text)
{
// INTERNAL USE ONLY, USE getPOSArray
	$output = array();
	$match = "";
	$text = trim($text);
	$text = preg_replace('/^\(/', ' (', $text);
	$text = preg_replace('/\) \(/u', ')  (', $text);
	$cnt = preg_match_all('/(.*)\(([a-zA-Z0-9_]+)?\) /Uu', $text . " ", $match);

	if($cnt == 0)
	{
//		echo "POS2Array:: ERR: [{$text}]\n";
		return null;
	}

//	$output = array('cnt' => $cnt, 'text' => $match[1], 'tag' => $match[2]);
	$output = array('text' => $match[1], 'tag' => $match[2], 'plain' => stripPOS($text));

	return $output;
}

function POSArray2Text($posArr)
{
	$output = "";
	if(!isset($posArr['text']))
	{
		foreach($posArr as $sentData)
		{
			foreach($sentData['text'] as $segN => $segT) $output .= "{$segT}({$sentData['tag'][$segN]}) ";
			$output = rtrim($output) . "\n";
		}
	}
	else
	{
		foreach($posArr['text'] as $segN => $segT) $output .= "{$segT}({$posArr['tag'][$segN]}) ";
	}
	return trim($output);
}

function segArr2Text($segArr)
{
	$output = "Line[{$segArr['line']}],Token[{$segArr['start']}-{$segArr['end']}],";
	for($loop = 0; $loop < count($segArr['tokens']['text']); $loop++)
	{
		$output .= "{$segArr['tokens']['text'][$loop]}({$segArr['tokens']['tag'][$loop]})";
		if($loop+1 < count($segArr['tokens']['text'])) $output .= " ";
	}
	$output .= ",{$segArr['punc']['text']} ({$segArr['punc']['tag']})";
	return $output;
}

function getPOSArray($text)
{
	$output = array();

	if(!is_array($text) && strstr($text, "\n")) $text = explode("\n", trim($text));
	if(is_array($text)) foreach($text as $n => $line) $output[$n] = POS2Array($line);
	else $output[0] = POS2Array($text);

	foreach($output as $oCheck)
	{
		if($oCheck == null)
		{
//print_r($output);
			return null;
		}
	}

	return $output;
}

function findInPOSArr($focus, $POSArr, $exactly = true)
{
	$allMatch = array();
	$match = array('start' => -1, 'end' => -1, 'text' => "", 'exactly' => false);
// echo "match [$focus] in " . stripPOS($POSArr);
// echo "\n";

	for($tokenN = 0; $tokenN < count($POSArr['text']); $tokenN++)
	{
		$token = $POSArr['text'][$tokenN];
		while(strstr($focus, $token) !== false)
		{
			if($match['start'] == -1) $match['start'] = $tokenN;
			$match['text'] .= $token;
			$tokenN++;
			if($tokenN < count($POSArr['text'])) $token = $POSArr['text'][$tokenN];
			else break;
		}
		if($match['start'] != -1)
		{
			$match['end'] = $tokenN-1;
			if($focus == $match['text']) $match['exactly'] = true;
// print_r($match);
			if($exactly == true)
			{
				if($match['exactly'] == true) $allMatch[] = $match;
			} else $allMatch[] = $match;
			$match = array('start' => -1, 'end' => -1, 'text' => "", 'exactly' => false);
		}
	}

//	echo "focus: {$focus}, line: ". stripPOS($line) . "\n";
//	print_r($allMatch);
	return $allMatch;
}

?>
