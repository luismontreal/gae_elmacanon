<?php
class Helpers {

static public function xmlToArray(SimpleXMLElement $xml, $options = array()) {
	    $defaults = array(
		'namespaceSeparator' => ':',//you may want this to be something other than a colon
		'attributePrefix' => '@',   //to distinguish between attributes and nodes with the same name
		'alwaysArray' => array(),   //array of xml tag names which should always become arrays
		'autoArray' => true,        //only create arrays for tags which appear more than once
		'textContent' => '$',       //key used for the text content of elements
		'autoText' => true,         //skip textContent key if node has no attributes or child nodes
		'keySearch' => false,       //optional search and replace on tag and attribute names
		'keyReplace' => false       //replace values for above search values (as passed to str_replace())
	    );
	    $options = array_merge($defaults, $options);
	    $namespaces = $xml->getDocNamespaces();
	    $namespaces[''] = null; //add base (empty) namespace
	 
	    //get attributes from all namespaces
	    $attributesArray = array();
	    foreach ($namespaces as $prefix => $namespace) {
		foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
		    //replace characters in attribute name
		    if ($options['keySearch']) $attributeName =
		            str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
		    $attributeKey = $options['attributePrefix']
		            . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
		            . $attributeName;
		    $attributesArray[$attributeKey] = (string)$attribute;
		}
	    }
	 
	    //get child nodes from all namespaces
	    $tagsArray = array();
	    foreach ($namespaces as $prefix => $namespace) {
		foreach ($xml->children($namespace) as $childXml) {
		    //recurse into child nodes
		    $childArray = self::xmlToArray($childXml, $options);
		    list($childTagName, $childProperties) = each($childArray);
	 
		    //replace characters in tag name
		    if ($options['keySearch']) $childTagName =
		            str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
		    //add namespace prefix, if any
		    if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
	 
		    if (!isset($tagsArray[$childTagName])) {
		        //only entry with this key
		        //test if tags of this type should always be arrays, no matter the element count
		        $tagsArray[$childTagName] =
		                in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
		                ? array($childProperties) : $childProperties;
		    } elseif (
		        is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
		        === range(0, count($tagsArray[$childTagName]) - 1)
		    ) {
		        //key already exists and is integer indexed array
		        $tagsArray[$childTagName][] = $childProperties;
		    } else {
		        //key exists so convert to integer indexed array with previous value in position 0
		        $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
		    }
		}
	    }
	 
	    //get text content of node
	    $textContentArray = array();
	    $plainText = trim((string)$xml);
	    if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
	 
	    //stick it all together
	    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
		    ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
	 
	    //return node as array
	    return array(
		$xml->getName() => $propertiesArray
	    );
	}
        
        static public function slugify($text) { 
          // replace non letter or digits by -
          $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

          // trim
          $text = trim($text, '-');

          // transliterate
          $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

          // lowercase
          $text = strtolower($text);

          // remove unwanted characters
          $text = preg_replace('~[^-\w]+~', '', $text);

          if (empty($text))
          {
            return 'n-a';
          }

          return $text;
        }
	
	static public function sanitize_output($buffer) {

	    $search = array(
		'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
		'/[^\S ]+\</s',  // strip whitespaces before tags, except space
		'/(\s)+/s'       // shorten multiple whitespace sequences
	    );

	    $replace = array(
		'>',
		'<',
		'\\1'
	    );

	    $buffer = preg_replace($search, $replace, $buffer);

	    return $buffer;
	}
	
	static public function isXML($xml){
	    libxml_use_internal_errors(true);

	    $doc = new DOMDocument('1.0', 'utf-8');
	    $doc->loadXML($xml);

	    $errors = libxml_get_errors();

	    if(empty($errors)){
		return true;
	    }

	    $error = $errors[0];
	    if($error->level < 3){
		return true;
	    }

	    $explodedxml = explode("r", $xml);
	    $badxml = $explodedxml[($error->line)-1];

	    $message = $error->message . ' at line ' . $error->line . '. Bad XML: ' . htmlentities($badxml);
	    return $message;
	}
}
?>
