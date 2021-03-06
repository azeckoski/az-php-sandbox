<?php
// $Header: /cvsroot/phpldapadmin/phpldapadmin/lib/export_functions.php,v 1.32.2.8 2005/12/10 12:04:37 wurley Exp $

/**
 * Fuctions and classes for exporting ldap entries to others formats
 * (LDIF,DSML,..)
 * An example is provided at the bottom of this file if you want implement yours. *
 * @package phpLDAPadmin
 * @author The phpLDAPadmin development team
 * @see export.php and export_form.php
 */
/**
 */

# registry for the exporters
$exporters = array();

$exporters[] = array(
	'output_type'=>'ldif',
	'desc' => 'LDIF',
	'extension' => 'ldif'
);

$exporters[] = array(
	'output_type'=>'dsml',
	'desc' => 'DSML V.1',
	'extension' => 'xml'
);

$exporters[] = array(
	'output_type'=>'vcard',
	'desc' => 'VCARD 2.1',
	'extension' => 'vcf'
);

$exporters[] = array(
	'output_type'=>'csv',
	'desc' => _('CSV (Spreadsheet)'),
	'extension' => 'csv'
);

/**
 * This class encapsulate informations about the ldap server
 * from which the export is done.
 * The following info are provided within this class:
 *
 * $ldapserver: the object of the server.
 * $base_dn: if the source of the export is the ldap server,
 *	it indicates the base dn of the search.
 * $query_filter: if the source of the export is the ldap server,
 *	it indicates the query filter for the search.
 * $scope: if the source of the export is the ldap server,
 *	it indicates the scope of the search.
 *
 * @package phpLDAPadmin
 */
class LdapExportInfo {
	var $ldapserver;
	var $base_dn;
	var $query_filter;
	var $scope;

	/**
	 * Create a new LdapExportInfo object
	 *
	 * @param int $server_id the server id
	 * @param String $base_dn the base_dn for the search in a ldap server
	 * @param String $query_filter the query filter for the search
	 * @param String $scope the scope of the search in a ldap server
	 */

	function LdapExportInfo($server_id,$base_dn=null,$query_filter=null,$scope=null) {
		global $ldapservers;

		$this->ldapserver = $ldapservers->Instance($server_id);
		$this->ldapserver->base_dn = $base_dn;
		$this->ldapserver->query_filter = $query_filter;
		$this->ldapserver->scope = $scope;
	}
}


/**
 * This class represents the base class of all exporters
 * It can be subclassed directly if your intend is to write
 * a source exporter(ie. it will act only as a decoree
 * which will be wrapped by an another exporter.)
 * If you consider writting an exporter for filtering data
 * or directly display entries, please consider subclass
 * the PlaExporter
 *
 * @see PlaExporter
 * @package phpLDAPadmin
 */
class PlaAbstractExporter {
	/**
	 * Return the number of entries
	 * @return int the number of entries to be exported
	 */
	function pla_num_entries() {}

	/**
	 * Return the results
	 * @return array if there is some more entries to be processed
	 */
	function pla_results() {}

	/**
	 * Return a PlaLdapInfo Object
	 * @return LdapInfo Object with info from the ldap serveur
	 */
	function pla_get_ldap_info() {}
} # end PlaAbstractExporter

/**
 * PlaExporter acts a wrapper around another exporter.
 * In other words, it will act as a decorator for another decorator
 *
 * @package phpLDAPadmin
 */
class PlaExporter extends PlaAbstractExporter {
	# Default CRLN
	var $br = "\n";
	# The wrapped $exporter
	var $exporter;

	var $compress = false;

	/**
	 * Constructor
	 * @param source $source the decoree for this exporter
	 */
	function PlaExporter($source) {
		$this->exporter = $source;
	}

	/**
	 * Return the number of entries
	 * @return int the number of entries to be exported
	 */
	function pla_num_entries() {
		return $this->exporter->pla_num_entries();
	}

	/**
	 * Return the results
	 * @return array if there is some more entries to be processed
	 */
	function pla_results() {
		return $this->exporter->pla_results();
	}

	/**
	 * Return a PlaLdapInfo Object
	 * @return LdapInfo Object with info from the ldap serveur
	 */
	function pla_get_ldap_info() {
		return $this->exporter->pla_get_ldap_info();
	}

	/**
	 * Helper method to check if the attribute value should be base 64 encoded.
	 * @param String $str the string to check.
	 * @return bool true if the string is safe ascii, false otherwise.
	 */
	function is_safe_ascii($str) {
		for ($i=0;$i<strlen($str);$i++)
			if (ord($str{$i}) < 32 || ord($str{$i}) > 127)
				return false;
		return true;
	}

	/**
	 * Abstract method use to export data.
	 * Must be implemented in a sub-class if you write an exporter
	 * which export data.
	 * Leave it empty if you write a sub-class which do only some filtering.
	 */
	function export() {}

	/**
	 * Set the carriage return /linefeed for the export
	 * @param String $br the CRLF to be set
	 */
	function setOutputFormat($br){
		$this->br = $br;
	}

	/**
	 * Display the header for the export
	 */
	function displayExportInfoHeader($type,$ldapserver) {
		$output = '';

		$output .= sprintf("version: 1%s%s",$this->br,$this->br);
		$output .= sprintf('# '.$type."%s",$ldapserver->base_dn,$this->br);
		$output .= sprintf('# '._('Generated by phpLDAPadmin ( http://phpldapadmin.sourceforge.net/ ) on %s')."%s",date('F j, Y g:i a'),$this->br);
		$output .= sprintf("# %s: %s (%s)%s",_('Server'),$ldapserver->name,$ldapserver->host,$this->br);
		$output .= sprintf("# %s: %s%s",_('Search Scope'),$ldapserver->scope,$this->br);
		$output .= sprintf("# %s: %s%s",_('Search Filter'),$ldapserver->query_filter,$this->br);
		$output .= sprintf("# %s: %s%s",_('Total Entries'),$this->pla_num_entries(),$this->br);
		$output .= $this->br;

		return $output;
	}

	function compress($boolean) {
		$this->compress = $boolean;
	}

	function isCompressed() {
		return $this->compress;
	}
} # end PlaExporter

/**
 * Export data from a ldap server
 * @extends PlaAbstractExporter
 * @package phpLDAPadmin
 */
class PlaLdapExporter extends PlaAbstractExporter {
	var $scope;
	var $base_dn;
	var $server_id;
	var $queryFilter;
	var $attributes;
	var $ldap_info;
	var $results;
	var $num_entries;

	/**
	 * Create a PlaLdapExporter object.
	 * @param int $server_id the server id
	 * @param String $queryFilter the queryFilter for the export
	 * @param String $base_dn the base_dn for the data to export
	 * @param String $scope the scope for export
	 */
	function PlaLdapExporter($server_id,$queryFilter,$base_dn,$scope,$attributes) {
		global $config;

		$this->scope = $scope;
		$this->base_dn = $base_dn;
		$this->server_id = $server_id;
		$this->queryFilter = $queryFilter;
		$this->attributes = $attributes;

		# infos for the server
		$this->ldap_info = new LdapExportInfo($server_id,$base_dn,$queryFilter,$scope);

		# get the data to be exported
		$this->results = $this->ldap_info->ldapserver->search(null,$this->base_dn,$this->queryFilter,$this->attributes,
			$this->scope,true,$config->GetValue('deref','export'));

		# if no result, there is a something wrong
		if (! $this->results && $this->ldap_info->ldapserver->errno())
			pla_error(_('Encountered an error while performing search.'),$this->ldap_info->ldapserver->error(),
				$this->ldap_info->ldapserver->errno());

		usort($this->results,'pla_compare_dns');
		$this->num_entries = count($this->results);
	} # End constructor

	/**
	 * Return the results
	 * @return array if there is some more entries to be processed
	 */
	function pla_results() {
		return $this->results;
	}

	/**
	 * Return a PlaLdapInfo Object
	 * @return LdapInfo Object with info from the ldap serveur
	 */
	function pla_get_ldap_info() {
		return $this->ldap_info->ldapserver;
	}

	/**
	 * Return the number of entries
	 * @return int the number of entries to be exported
	 */
	function pla_num_entries() {
		return $this->num_entries;
	}
} # End PlaLdapExporter

/**
 * Export entries to ldif format
 * @extends PlaExporter
 * @package phpLDAPadmin
 */
class PlaLdifExporter extends PlaExporter {
	# variable to keep the count of the entries
	var $counter = 0;

	# the maximum length of the ldif line
	var $MAX_LDIF_LINE_LENGTH = 76;

	/**
	 * Create a PlaLdifExporter object
	 * @param PlaAbstractExporter $exporter the source exporter
	 */
	function PlaLdifExporter($exporter) {
		$this->exporter = $exporter;
	}

	/**
	 * Export entries to ldif format
	 */
	function export() {
		$ldapserver = $this->pla_get_ldap_info();
		$output = $this->displayExportInfoHeader(_('LDIF Export for: %s'),$ldapserver);

		# Sift through the entries.
		foreach ($this->pla_results() as $dn => $dndetails) {
			$this->counter++;
			if (isset($dndetails['dn'])) {
				$dn = $dndetails['dn'];
				unset($dndetails['dn']);
			}

			$title_string = sprintf('# %s %s: %s%s',_('Entry'),$this->counter,$dn,$this->br);
			if (strlen($title_string) > $this->MAX_LDIF_LINE_LENGTH-3)
				$title_string = substr($title_string,0,$this->MAX_LDIF_LINE_LENGTH-3).'...'.$this->br;

			# display dn
			if ($this->is_safe_ascii($dn))
				$output .= $this->multi_lines_display(sprintf('dn: %s',$dn));
			else
				$output .= $this->multi_lines_display(sprintf('dn:: %s',base64_encode($dn)));

			# display the attributes
			foreach ($dndetails as $key => $attr) {
				if (! is_array($attr))
					$attr = array($attr);

				foreach ($attr as $value) {
					if (! $this->is_safe_ascii($value) || $ldapserver->isAttrBinary($key)) {
						$output .= $this->multi_lines_display(sprintf('%s:: %s',$key,base64_encode($value)));

					} else {
						$output .= $this->multi_lines_display(sprintf('%s: %s',$key,$value));
					}
				}
			} # end foreach

			$output .= $this->br;
		}

		if ($this->compress)
			echo gzencode($output);
		else
			echo $output;
	}

	/**
	 * Helper method to wrap ldif lines
	 * @param String $str the line to be wrapped if needed.
	 */
	function multi_lines_display($str) {
		$length_string = strlen($str);
		$max_length = $this->MAX_LDIF_LINE_LENGTH;

		$output = '';
		while ($length_string > $max_length) {
			$output .= substr($str,0,$max_length).$this->br.' ';
			$str = substr($str,$max_length,$length_string);
			$length_string = strlen($str);

			/* need to do minus one to align on the right
			   the first line with the possible following lines
			   as these will have an extra space. */
			$max_length = $this->MAX_LDIF_LINE_LENGTH-1;
		}
		$output .= $str.$this->br;

		return $output;
	}
}

/**
 * Export entries to DSML v.1
 * @extends PlaExporter
 * @package phpLDAPadmin
 */
class PlaDsmlExporter extends PlaExporter {
	var $counter = 0;

	/**
	 * Create a PlaDsmlExporter object
	 * @param PlaAbstractExporter $exporter the decoree exporter
	 */
	function PlaDsmlExporter($exporter) {
		$this->exporter = $exporter;
	}

	/**
	 * Export the entries to DSML
	 */
	function export() {
		$ldapserver = $this->pla_get_ldap_info();

		# not very elegant, but do the job for the moment as we have just 4 level
		$directory_entries_indent = '  ';
		$entry_indent= '    ';
		$attr_indent = '      ';
		$attr_value_indent = '        ';

		# print declaration
		$output = '<?xml version="1.0"?>'.$this->br;

		# print root element
		$output .= '<dsml>'.$this->br;

		# print info related to this export
		$output .= '<!--'.$this->br;
		$output .= $this->displayExportInfoHeader(_('DSLM Export for: %s'),$ldapserver);
		$output .= '-->'.$this->br;
		$output .= $this->br;

		$output .= $directory_entries_indent.'<directory-entries>'.$this->br;

		# Sift through the entries.
		foreach ($this->pla_results() as $dn => $dndetails) {
			$this->counter++;
			unset($dndetails['dn']);

			# display dn
			$output .= sprintf($entry_indent.'<entry dn="%s">'."%s",htmlspecialchars($dn),$this->br);

			# echo the objectclass attributes first
			if (isset($dndetails['objectClass'])) {
				$output .= $attr_indent.'<objectClass>'.$this->br;

				foreach ($dndetails['objectClass'] as $ocValue) {
					$output .= sprintf($attr_value_indent.'<oc-value>%s</oc-value>'."%s",$ocValue,$this->br);
				}

				$output .= $attr_indent.'</objectClass>'.$this->br;
				unset($dndetails['objectClass']);
			}

			$binary_mode = 0;

			# display the attributes
			foreach ($dndetails as $key => $attr) {
				if (! is_array($attr))
					$attr = array($attr);

				$output .= sprintf($attr_indent.'<attr name="%s">'."%s",$key,$this->br);

				# if the attribute is binary, set the flag $binary_mode to true
				$binary_mode = $ldapserver->isAttrBinary($key) ? 1 : 0;

				foreach ($attr as $value) {
					$output .= sprintf($attr_value_indent.'<value>%s</value>'."%s",
						($binary_mode ? base64_encode($value) : htmlspecialchars($value)),$this->br);
				}

				$output .= $attr_indent.'</attr>'.$this->br;
			} # end foreach
			$output .= $entry_indent.'</entry>'.$this->br;
		}

		$output .= $directory_entries_indent.'</directory-entries>'.$this->br;
		$output .= '</dsml>'.$this->br;

		if ($this->compress)
			echo gzencode($output);
		else
			echo $output;
	}
}

/**
 * @package phpLDAPadmin
 */
class PlaVcardExporter extends PlaExporter {
	# mappping one to one attribute
	var $vcardMapping = array('cn' => 'FN',
		'title' => 'TITLE',
		'homePhone' => 'TEL;HOME',
		'mobile' => 'TEL;CELL',
		'mail' => 'EMAIL;Internet',
		'labeledURI' =>'URL',
		'o' => 'ORG',
		'audio' => 'SOUND',
		'facsmileTelephoneNumber' =>'TEL;WORK;HOME;VOICE;FAX',
		'jpegPhoto' => 'PHOTO;ENCODING=BASE64',
		'businessCategory' => 'ROLE',
		'description' => 'NOTE'
		);

	var $deliveryAddress = array('postOfficeBox',
		'street',
		'l',
		'st',
		'postalCode',
		'c');

	function PlaVcardExporter($exporter){
		$this->exporter = $exporter;
	}

	/**
	 * When doing an exporter, the method export need to be overriden.
	 * A basic implementation is provided here. Customize to your need
	 **/
	function export() {
		# Sift through the entries.
		foreach ($this->pla_results() as $dn => $dndetails) {
			unset($dndetails['dn']);

			# check the attributes needed for the delivery address field
			$addr = 'ADR:';
			foreach ($this->deliveryAddress as $attr_name) {
				if (isset($dndetails[$attr_name])) {
					$addr .= $dndetails[$attr_name];
					unset($dndetails[$attr_name]);
				}
				$addr .= ';';
			}

			$output = 'BEGIN:VCARD'.$this->br;

			# loop for the attributes
			foreach ($dndetails as $key => $attr) {
				if (! is_array($attr))
					$attr = array($attr);

				/* if an attribute of the ldap entry exist
				   in the mapping array for vcard */
				if (isset($this->vcardMapping[$key])) {

					/* case of organisation. Need to append the
					   possible ou attribute*/
					if (strcasecmp($key ,'o') == 0) {
						$output .= sprintf('%s:%s',$this->vcardMapping[$key],$attr[0]);

						if (isset($entry['ou']))
							foreach ($entry['ou'] as $ou_value) {
								$output .= sprintf(';%s',$ou_value);
							}

					# the attribute is binary. (to do : need to fold the line)
					} elseif (strcasecmp($key,'audio') == 0 || strcasecmp($key,'jpegPhoto') == 0) {
						$output .= $this->vcardMapping[$key].':'.$this->br;
						$output .= ' '.base64_encode($attr[0]);

					} else {
						$output .= $this->vcardMapping[$key].':'.$attr[0];
					}

					$output .= $this->br;
				}
			}

			$output .= sprintf('UID:%s'."%s",$dn,$this->br);
			$output .= 'VERSION:2.1'.$this->br;
			$output .= $addr.$this->br;
			$output .= 'END:VCARD'.$this->br;
		} # end while

		if ($this->compress)
			echo gzencode($output);
		else
			echo $output;
	}
}

/**
 * Export to cvs format
 *
 * @author Glen Ogilvie
 * @package phpLDAPadmin
 */
class PlaCSVExporter extends PlaExporter {
	function PlaCSVExporter($exporter) {
		$this->exporter = $exporter;
	}

	/**
	 * When doing an exporter, the method export need to be overriden.
	 * A basic implementation is provided here. Customize to your need
	 **/
	var $separator = ',';
	var $qualifier = '"';
	var $multivalue_separator = ' | ';
	var $escapeCode = '"';

	function export() {
		$entries = array();
		$headers = array();

		$ldap_info = $this->pla_get_ldap_info();

		$output = '';
		/* go thru and find all the attribute names first.  This is needed, because, otherwise we have
		   no idea as to which search attributes were actually populated with data */
		foreach ($this->pla_results() as $dn => $dndetails) {
			foreach (array_keys($dndetails) as $key) {
				if (!in_array($key,$headers))
					array_push($headers,$key);
			}
			array_push($entries,$dndetails);
		}

		$num_headers = count($headers);

		# print out the headers
		for ($i = 0; $i < $num_headers; $i++) {
			$output .= $this->qualifier.$headers[$i].$this->qualifier;
			if ($i < $num_headers-1)
				$output .= $this->separator;
		}

		array_shift($headers);
		$num_headers--;

		$output .= $this->br;

		# loop on every entry
		foreach ($entries as $index => $entry) {
			$dn = $entry['dn'];
			unset($entry['dn']);
			$output .= $this->qualifier.$this->LdapEscape($dn).$this->qualifier.$this->separator;

			# print the attributes
			for ($j=0; $j < $num_headers; $j++) {
				$attr_name = $headers[$j];
				$output .= $this->qualifier;

				if (key_exists($attr_name,$entry)) {
					$binary_attribute = $ldap_info->isAttrBinary($attr_name) ? 1 : 0;

					if (! is_array($entry[$attr_name]))
						$attr_values = array($entry[$attr_name]);
					else
						$attr_values = $entry[$attr_name];

					$num_attr_values = count($attr_values);

					for ($i=0; $i<$num_attr_values; $i++) {
						if ($binary_attribute)
							$output .= base64_encode($attr_values[$i]);
						else
							$output .= $this->LdapEscape($attr_values[$i]);

						if ($i < $num_attr_values - 1)
							$output .= $this->multivalue_separator;
					}
				} # end if key

				$output .= $this->qualifier;

				if ($j < $num_headers - 1)
					$output .= $this->separator;
			}
			$output .= $this->br;
		}

		if ($this->compress)
			echo gzencode($output);
		else
			echo $output;
	} #end export

	/* function to escape data, where the qualifier happens to also
	   be in the data. */
	function LdapEscape ($var) {
		return str_replace($this->qualifier,$this->escapeCode.$this->qualifier,$var);
	}
}

/**
 * @package phpLDAPadmin
 */
class MyCustomExporter extends PlaExporter {
	function MyCustomExporter($exporter) {
		$this->exporter = $exporter;
	}

	/**
	 * When doing an exporter, the method export need to be overriden.
	 * A basic implementation is provided here. Customize to your need
	 **/
	function export() {

		/* With the method pla->get_ldap_info,
		   you have access to some values related
		   to you ldap server */
		$ldap_info = $this->pla_get_ldap_info();

		/* Just a simple loop. For each entry
		   do your custom export
		   see PlaLdifExporter or PlaDsmlExporter as an example */
		foreach ($this->pla_results() as $dn => $dndetails) {
			unset($dndetails['dn']);

			# loop for the attributes
			foreach ($dndetails as $key => $attr) {
				if (! is_array($attr))
					$attr = array($attr);

				foreach ($attr as $value) {
					/* simple example
					echo "Attribute Name:".$attr;
					echo " - value:".$value;
					echo $this->br;
					*/
				}
			}
		} # end while
	}
}
?>
