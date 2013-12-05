<?php

require_once("libs/JSON.php"); //Iimport functions for PHP array to JSON conversion

$count = -1; //Keeps track of valid items written to JSON
$items = array();
$tempArray = array();

$file = fopen("input/data.txt", "r") or exit("Unable to open file!");
while(!feof($file)) { //Loop through each line in file and convert items to JSON
	$line = fgets($file);

	if (!strstr($line,"\t") && $line !== "\r\n" && $count !== -1) { //Item title
		if (isTableItem($tempArray)){
			array_push($items, $tempArray); //Add valid item to array
			$count++;
		}
		$tempArray = array();
		$tempArray["Title"] = $line;
	} elseif($line !== "\r\n" && $count !== -1) { //Item property & value
		$keyValPair = explode(":",$line); //Separate property from value
		$property = str_replace(array("\t", " "),"", $keyValPair[0]); //remove whitespace
		$value = str_replace("  ","", $keyValPair[1]); //remove whitespace

		if (preg_match('/Title|CSCI|Browsertitle|ValidityVariantVersion|SUZdocnumber|R&Ddocnumber|DMSTNFpdfID|DMSSUZpdfID/', $property) == 1) { //Filter out the properties we want
			if ($property == "ValidityVariantVersion"){ //This separates pairs of variant+version
				$variantsAndVersions = explode(", ",$value); //Separate variant/version pairs from others
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
	if ($item["Browsertitle"] == "" || $item["Browsertitle"] == "\r\n") { //If record has a doctype or isn't a blank line then it's a valid item
		return false;
	} else {
		return true;
	}
}

$items = array("Items"=>$items); //Add all items to array, ready for JSON conversion
fclose($file);

$json = prettyPrint(json_encode($items)); //Format JSON so it looks pretty!

$File = "output/data.json";
$Handle = fopen($File, 'w');
fwrite($Handle, $json); 
print $count." items written to data.json\n";
fclose($Handle);

?>