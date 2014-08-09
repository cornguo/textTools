<?php

function normText($string)
{
$symbols = array("├", "─", "┼", "┴", "┬", "┤", "┌", "┐", "╞",
"═", "╪", "╡", "│", "▕", "└", "┘", "╭", "╮", "╰", "╯",
"╔", "╦", "╗", "╠", "═", "╬", "╣", "╓", "╥", "╖", "╒",
"╤", "╕", "║", "╚", "╩", "╝", "╟", "╫", "╢", "╙", "╨",
"╜", "╞", "╪", "╡", "╘", "╧", "╛", "儭�", "儭�", "儭�", "儭�",
"儭�", "儭�", "儭�", "儭�", "儭�", "儭�", "儭�", "儮�", "∩", "∪", "儮�",
"儮�", "儮�", "儮�", "◎", "⊕", "⊙", "○", "●", "△", "▲", "▽",
"▼", "☆", "★", "◇", "◆", "□", "■", "☎", "☏", "◐", "◑",
"♡", "♥", "♣", "♧", "♠", "♤", "☜", "☞", "♬", "◊", "◁",
"∈", "∋", "♀", "♂", "♩", "♪", "☼", "嚙�", "〒", "嚙�", "嚙�",
"※", "↔", "↕", "♨", "卍", "◈", "禮", "♭", "嚗�", "ˍ", "▁",
"▂", "▃", "▄", "▅", "▆", "▇", "█", "▏", "▎", "▍", "▌",
"▋", "▊", "▉", "◢", "◣", "◥", "◤", "▣", "▤", "▥", "▦",
"▧", "▨", "▩", "▒", "◀",  "≡", "儮�", "瞽", "დ", "˚", "σ",
"-", ",", "\\", "/", "~", "!", "?", "&lt;", "&gt;", "&quot;", "0.0",
"(", ")", "=", "+", "*", ".", "{", "}", ":", ";",
"[", "]", "《", "》", "【", "】", "ˇ", "〃", "㊣", "嚗�", "嚗�",
"`", "_", "〞", "→", "嚗�", "↗", "↙", "嚚�", "〝", "雂", "儮�",
"♫", "^", "穢", "☺", "‧", "  ", "❤", "∴", "儭�", "◦", "簞",
"∽", "×", "†", "₦", "㊚", "嚚�", "嚚�", "XDD", "XD", "嚗�", "〆",
"▪", "▫", "ゞ", "嚗�", "∥", "@", "嚗�", "帤", "℃", "嚗�", "≠",
"儮�", "ˊ", "嚗�", "∮", "嚗�", "嚗�", "嚗�", "嚗�", "『", "』", "「",
"」", "#", "嚗�", "ω", "ˋ", "嚙�", "↖", "儮�", "嚗�", "|", "►",
"‵", "儮�", "'", "嚗�", "嚗�", "嚗�", "゛", "〖", "〗", "“", "€",
"鉈�", "܍", "܍", "′", "嚜�", "˙", "嚗�", "♦", "↘", "▶", "…",
"嚗�", "’", "←", "〥", "嚗�", "嚚�", "嚚�", "☻", "╳", "庤", "儮�",
"•", "™", "‥", "儮�", "”", "„", "゜", "㌔", "儮�", "〉", "〈",
"鄐�", "嚗�", "∼", "≧", "≦", "嚚�", "儮�", "ヾ", "╴", "繩", "ミ",
"ღ", "㆙", "◄", "℉", "儮�", "∕", "〘", "〙", "々", "簣", "‘",
"、", "嚗�", "儮�", "。", "〔", "〕", "0o", "o0", "ー", "░",
"☉", "儮�", "儮�", "鉈�", "$", "☀", "儮�", "靮", "簧", "◘", "∘", "∵",
"Ξ", "㍉", "繚", "儮�", " ", "怷", "簪", "灬", "∞", "・", "嚗�",
"┥", "┝", "鉆�", "菮", "۞", "鉈�", "鈳�", "✖", "㈱", "儮�", "儮�", "嚚�",
"㊛", "–", "儮�", "儮�", "徆", "峏", "≒", "☩", "✱", "嚝�",
"∫", "℅", "ρ", "↓", "↑", "—", "⇔", "鉒�", 
"✞", "❣", "▐", "庰",  "嚚�", "☇", "☈", "㎡", "♁",
"〄", "", "✥", "ゑ", "鉒�", "鉦�", "鉈�", "✿", "儮�", );

//$string = str_replace($symbols, " ", $string);


$fullwidth = array("嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�",
    "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�",
    "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�",
    "嚗�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�",
    "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�",
    "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�", "嚚�",
    "ⓐ", "ⓑ", "ⓒ", "ⓓ", "ⓔ", "ⓕ", "ⓖ", "ⓗ", "ⓘ",
    "ⓙ", "ⓚ", "ⓛ", "ⓜ", "ⓝ", "ⓞ", "ⓟ", "ⓠ", "ⓡ",
    "ⓢ", "ⓣ", "ⓤ", "ⓥ", "ⓦ", "ⓧ", "ⓨ", "ⓩ", "㊣",
    "㊟", "㊕", "㊗", "㊡", "㊝", "①", "②", "③", "④",
    "⑤", "⑥", "⑦", "⑧", "⑨", "⑩", "⑪", "⑫", "⑬",
    "⑭", "⑮", "⑯", "⑰", "⑱", "⑲", "⑳", "⑴", "⑵",
    "⑶", "⑷", "⑸", "⑹", "⑺", "⑻", "⑼", "⑽", "㈠",
    "㈡", "㈢", "㈣", "㈤", "㈥", "㈦", "㈧", "㈨", "㈩",
    "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�", "嚗�",
    "⒜", "⒝", "⒞", "⒟", "⒠", "⒡", "⒢", "⒣", "⒤",
    "⒥", "⒦", "⒧", "⒨", "⒩", "⒪", "⒫", "⒬", "⒭",
    "⒮", "⒯", "⒰", "⒱", "⒲", "⒳", "⒴", "⒵",
    "㊀", "㊁", "㊂", "㊃", "㊄", "㊅", "㊆", "㊇", "㊈", "㊉",
    "Ⅰ", "Ⅱ", "Ⅲ", "Ⅳ", "Ⅴ", "Ⅵ", "Ⅶ", "Ⅷ", "Ⅸ",
    "Ⅹ", "Ⅺ", "Ⅻ", "〡", "〢", "〣", "〤", "〥", "〦",
    "〧", "〨", "〩", "十", "卄", "卅",
    "（", "）", "［", "］", "｛", "｝", "“", "”", "【", "】",
     "－", "＼", "／", "｜", 
    "，", "。", "？", "！", "：", "；",
//    "　", "の", "ㄌ", "ㄍ", "ㄇ", "ㄋ", "", "ㄊ",
//    "㊙", "㆖", 
    );

$halfwidth = array("A", "B", "C", "D", "E", "F", "G",
    "H", "I", "J", "K", "L", "M", "N", "O", "P",
    "Q", "R", "S", "T", "U", "V", "W", "X", "Y",
    "Z", "a", "b", "c", "d", "e", "f", "g", "h",
    "i", "j", "k", "l", "m", "n", "o", "p", "q",
    "r", "s", "t", "u", "v", "w", "x", "y", "z",
    "a", "b", "c", "d", "e", "f", "g", "h", "i",
    "j", "k", "l", "m", "n", "o", "p", "q", "r",
    "s", "t", "u", "v", "w", "x", "y", "z", "甇�",
    "瘜�", "特", "蟡�", "隡�", "優", "1", "2", "3", "4",
    "5", "6", "7", "8", "9", "10", "11", "12", "13",
    "14", "15", "16", "17", "18", "19", "20", "1", "2",
    "3", "4", "5", "6", "7", "8", "9", "10", "銝�",
    "鈭�", "銝�", "四", "鈭�", "六", "銝�", "八", "銋�", "十",
    "1", "2", "3", "4", "5", "6", "7", "8", "9", "0",
    "a", "b", "c", "d", "e", "f", "g", "h", "i",
    "j", "k", "l", "m", "n", "o", "p", "q", "r",
    "s", "t", "u", "v", "w", "x", "y", "z",
    "銝�", "鈭�", "銝�", "四", "鈭�", "六", "銝�", "八", "銋�", "十",
    "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX",
    "X", "XI", "XII", "銝�", "鈭�", "銝�", "四", "鈭�", "六",
    "銝�", "八", "銋�", "十", "鈭�十", "銝�十",
    "(", ")", "[", "]", "{", "}", "\"", "\"", "[", "]",
    "-", "\\", "/", "|",
    ",", ".", "?", "!", ":", ";",
//    " ", "的", "鈭�", "個", "嗎", "呢", "的", "隞�",
//    "蟡�", "銝�", 
    );

$string = str_replace($fullwidth, $halfwidth, $string);
$string = preg_replace("/  +/i", " ", $string);
$string = ltrim(rtrim($string));

$string = preg_replace("/ [^0-9a-z]/u", "", $string);

return $string;
}

?>
