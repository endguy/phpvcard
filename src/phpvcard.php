<?php

	class phpvcard
	/* vCard Creator */
	{
	
		// declarations
		var $fields = array();
		
		var $allowed = array(
			"firstName",
			"additionalName",
			"lastName",
			"title",
			"suffix",
			"organisation",
			"jobtitle",
			"tel_work",
			"tel_home",
			"tel_cell",
			"tel_car",
			"tel_isdn",
			"fax_work",
			"fax_home",
			"street_work",
			"city_work",
			"postal_work",
			"country_work",
			"street_home",
			"city_home",
			"postal_home",
			"country_home",
			"url_work",
			"url_home",
			"email_1",
			"email_2",
			"email_3",
			"picture",
			"note"
		);
		
		
		
		function setValue($setting, $value)
		/* Enter values */
		{
		
			// Is the setting in the list of allowed settings?
			if(in_array($setting, $this->allowed))
			{
				// Yes, set and setting value
				$this->fields[$setting] = $value;
				return true;
			}
			else
			{
				// No
				return false;
			}
		
		}
		
		
		
		function copyPicture($path)
		/* Photo Import */
		{
			// If the file exists?
			if(is_file($path))
			{
				// Yes, get the image size
				$imgsize = getimagesize($path);
				
				// If the image is not larger than 185x185?
				if($imgsize[0] <= 185 && $imgsize[1] <= 185)
				{
					// Yes, calculate base64 code and set
					$this->fields["picture"] = base64_encode(file_get_contents ($path));
					return true;
				}
				else
				{
					// No, it's too big
					return false;
				}
			}
			else
			{
				// No, file does not exist
				return false;
			}
		}
		
		
		
		function setPicture($value)
		/* Save this picture directly as BASE64 - code, NOT RECOMMENDED */
		{
			$this->fields["picture"] = $value;
			return true;
		}
		
		
		
		function dump()
		/* Dump output */
		{
		
			echo "<pre>";
			print_r($this->fields);
			echo "</pre>";
			return true;
		
		}
		
		
		
		function getCard()
		/* generate vCard */
		{

		    // Set Content type
	    	header('Content-type: text/x-vcard; charset=utf-8');
	    	header('Content-Disposition: attachment; filename="' . $this->fields['firstName'] . '-' . $this->fields['lastName'] . '"vcard.vcf"');
			
			$card  = "BEGIN:VCARD\n";
			$card .= "VERSION:2.1\n";
			
			// Build name
			$name = array();
			$name->lastName = isset($this->fields['lastName']) ? $this->fields['lastName'] . ";" : "";
			$name->firstName = isset($this->fields['firstName']) ? $this->fields['firstName'] . ";" : "";
			$name->additionalName = isset($this->fields['additionalName']) ? $this->fields['additionalName'] . ";" : "";
			$name->title = isset($this->fields['title']) ? $this->fields['title'] . ";" : "";
			$name->suffix = isset($this->fields['suffix']) ? $this->fields['suffix'] . ";" : "";

			// Set name
			$card .= "N:" . $name->lastName . $name->firstName . $name->additionalName . $name->title . $name->suffix . "\n";
			
			// Set company and title, if any
			if(isset($this->fields["organisation"]))
			{
				$card .= "ORG:".$this->fields["organisation"]."\n";
			}
			if(isset($this->fields["jobtitle"]))
			{
				$card .= "TITLE:".$this->fields["jobtitle"]."\n";
			}
			
			
			// Contact telephone and fax numbers
			
				if(isset($this->fields["tel_work"])) { $card .= "TEL;WORK:".$this->fields["tel_work"]."\n"; }	// Business phone
				if(isset($this->fields["tel_home"])) { $card .= "TEL;HOME:".$this->fields["tel_home"]."\n"; } // Home Phone
				if(isset($this->fields["tel_cell"])) { $card .= "TEL;CELL:".$this->fields["tel_cell"]."\n"; } // Mobile phone
				if(isset($this->fields["tel_car"])) { $card .= "TEL;CAR:".$this->fields["tel_car"]."\n"; } // Car phone
				if(isset($this->fields["tel_isdn"])) { $card .= "TEL;ISDN:".$this->fields["tel_isdn"]."\n"; } // ISDN/VOIP
				if(isset($this->fields["fax_work"])) { $card .= "TEL;WORK;FAX:".$this->fields["fax_work"]."\n"; } // Work fax
				if(isset($this->fields["fax_home"])) { $card .= "TEL;HOME;FAX:".$this->fields["fax_home"]."\n"; } // Home fax
			
			
			
			// Contact Addresses
			
				// Work Address
				if(isset($this->fields["street_work"]) && isset($this->fields["city_work"]) && isset($this->fields["postal_work"]) && isset($this->fields["country_work"]))
				{
					$card .= "ADR;WORK;PREF:;;".$this->fields["street_work"].";".$this->fields["city_work"].";;".$this->fields["postal_work"].";".$this->fields["country_work"]."\n";
					$card .= "LABEL;WORK;PREF;ENCODING=QUOTED-PRINTABLE:".$this->fields["street_work"]."=0D=0A=\n";
					$card .= "=0D=0A=\n";
					$card .= $this->fields["postal_work"]." ".$this->fields["city_work"]."\n";
				}
				
				// Home Address
				if(isset($this->fields["street_home"]) && isset($this->fields["city_home"]) && isset($this->fields["postal_home"]) && isset($this->fields["country_home"]))
				{
					$card .= "ADR;HOME;PREF:;;".$this->fields["street_home"].";".$this->fields["city_home"].";;".$this->fields["postal_home"].";".$this->fields["country_home"]."\n";
					$card .= "LABEL;HOME;PREF;ENCODING=QUOTED-PRINTABLE:".$this->fields["street_home"]."=0D=0A=\n";
					$card .= "=0D=0A=\n";
					$card .= $this->fields["postal_home"]." ".$this->fields["city_home"]."\n";
				}
			
			
			
			// URL und E-Mails
			
				if(isset($this->fields["url_work"])) { $card .= "URL;WORK:".$this->fields["url_work"]."\n"; }			// Website URL - Work
				if(isset($this->fields["url_home"])) { $card .= "URL:".$this->fields["url_home"]."\n"; }			// Website URL - Home
				if(isset($this->fields["email_1"])) { $card .= "EMAIL;INTERNET:".$this->fields["email_1"]."\n"; }		// Email Address 1
				if(isset($this->fields["email_2"])) { $card .= "EMAIL;INTERNET:".$this->fields["email_2"]."\n"; }		// Email Address 2
				if(isset($this->fields["email_3"])) { $card .= "EMAIL;INTERNET:".$this->fields["email_3"]."\n"; }		// Email Address 3
			
			
			
			// Add photo, if available
			if(isset($this->fields["picture"]))
			{
				$card .= "PHOTO;TYPE=JPEG;ENCODING=BASE64:";
				$card .= $this->fields["picture"];
				$card .= "\n\n\n";
			}
			
			
			// End vCard
			$card .= "END:VCARD";
			
			// Output card and delete string
			echo $card;
			$card = "";
		
		}
	
	}

?>