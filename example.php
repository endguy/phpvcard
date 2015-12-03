<?php

// Create vCard object
include("src/phpvcard.php");

$vcard = new phpvcard;

// Set vCard values

// Name
$vcard->setValue("firstName", "");			// First Name
$vcard->setValue("additionalName", "");		// Middle/Additional Name
$vcard->setValue("lastName", "");			// Last/Surname
$vcard->setValue("title", "");				// Title - eg "Dr" , "Mr" , "Mrs"
$vcard->setValue("suffix", "");				// Suffix - eg "Jr."+

// Company
$vcard->setValue("organisation", "");		// Organisation or Company
$vcard->setValue("jobtitle", "");			// Job Title / Position

// Phone/Fax
$vcard->setValue("tel_work", "");			// Phone - Business
$vcard->setValue("tel_home", "");			// Phone - Home
$vcard->setValue("tel_cell", "");			// Phone - Cell/Mobile
$vcard->setValue("tel_car", "");			// Phone - Car
$vcard->setValue("tel_isdn", "");			// Phone - ISDN/VOIP
$vcard->setValue("fax_work", "");			// Fax - Work
$vcard->setValue("fax_home", "");			// Fax - Home

// Address
$vcard->setValue("street_work", "");		// Address - work - Street
$vcard->setValue("city_work", "");			// Address - work - City
$vcard->setValue("postal_work", "");		// Address - work - Postal/Zip Code
$vcard->setValue("country_work", "");		// Address - work - Country
$vcard->setValue("street_home", "");		// Address - home - Street
$vcard->setValue("city_home", "");			// Address - home - City
$vcard->setValue("postal_home", "");		// Address - home - Postal/Zip Code
$vcard->setValue("country_home", "");		// Address - home - Country

// Email/Website
$vcard->setValue("url_work", "");			// Website URL - Work
$vcard->setValue("url_home", "");			// Website URL - Home
$vcard->setValue("email_1", "");			// Email Address 1
$vcard->setValue("email_2", "");			// Email Address 2
$vcard->setValue("email_3", "");			// Email Address 3

// Image
$vcard->copyPicture("");					// Image - URL (will be base64 encoded) - Width AND Height MUST be less than 185x185
$vcard->setValue("picture", "");			// Image - base64 string (NOT RECOMMENDED)

// Other
$vcard->setValue("note", "");				// Additional Information

// Output vCard to file
$vcard->getCard();

// Output vCard as varDump
// $vcard->Dump();

die();

?>