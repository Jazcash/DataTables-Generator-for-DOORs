<?php
require_once("libs/JSON.php");
$count = -1;
$items = array();
$tempArray = array();
$file = fopen("input/data.txt", "r") or exit("Unable to open file!");
while(!feof($file)) {
	$line = fgets($file);
	if (!strstr($line,"\t") && $line !== "\r\n" && $count !== -1) { //Item Title
		if (isTableItem($tempArray)){
			array_push($items, $tempArray);
			$count++;
		}
		$tempArray = array();
		$tempArray["Title"] = $line;
	} elseif($line !== "\r\n" && $count !== -1) { //Item Property & Value
		$keyValPair = explode(":",$line);
		$property = str_replace(array("\t", " "),"", $keyValPair[0]);
		$value = str_replace("  ","", $keyValPair[1]);
		if (preg_match('/Title|CSCI|Browsertitle|ValidityVariantVersion|SUZdocnumber|R&Ddocnumber|DMSTNFpdfID|DMSSUZpdfID/', $property) == 1) {
			if ($property == "ValidityVariantVersion"){ //This separates pairs of variant+version
				$variantsAndVersions = explode(", ",$value);
				$tempArray[$property] = $variantsAndVersions;
			} else {
				$tempArray[$property] = $value;
			}
		}
	} elseif ($count == -1) { //First Item (Title)
		$tempArray["Title"] = $line;
		$count++;
	}
}
function isTableItem($item) {
	if ($item["Browsertitle"] == "" || $item["Browsertitle"] == "\r\n") {
		return false;
	} else {
		return true;
	}
}
$items = array("Items"=>$items);
fclose($file);
$json = prettyPrint(json_encode($items));
$File = "output/data.json";
$Handle = fopen($File, 'w');
fwrite($Handle, $json); 
print $count." items written to data.json\n";
fclose($Handle); 
?>