<?php

var_dump(libxml_use_internal_errors(true));

$xmlstr = <<< XML
<?xml version='1.0' standalone='yes'?>
    <movies>
        <movie>
            <titles>PHP: Behind the Parser</title>
        </movie>
    </movies>
XML;

$doc = simplexml_load_string($xmlstr);
$xml = explode("\n", $xmlstr);

if (!$doc) {
	$errors = libxml_get_errors();

	foreach ($errors as $error) {
		echo display_xml_error($error, $xml);
	}

	var_dump(libxml_get_last_error());
}


function display_xml_error($error, $xml)
{
	$return  = $xml[$error->line - 1] . "\n";
	$return .= str_repeat('-', $error->column) . "^\n";

	switch ($error->level) {
		case LIBXML_ERR_WARNING:
			$return .= "Warning $error->code: ";
			break;
		case LIBXML_ERR_ERROR:
			$return .= "Error $error->code: ";
			break;
		case LIBXML_ERR_FATAL:
			$return .= "Fatal Error $error->code: ";
			break;
	}

	$return .= trim($error->message) . "\n  Line: $error->line" . "\n  Column: $error->column";

	if ($error->file) {
		$return .= "\n  File: $error->file";
	}

	return "$return\n\n--------------------------------------------\n\n";
}


echo "Done\n";
?>
