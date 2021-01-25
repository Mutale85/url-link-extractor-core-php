function check_all_links($url) {
	$doc = new DOMDocument();
	@$doc->loadHTML(file_get_contents($url));
	$linklist = $doc->getElementsByTagName("a");
	$title = $doc->getElementsByTagName("title");
	$href = array();
	$scheme = parse_url($url, PHP_URL_SCHEME);
	$output = "";
	$checked_links = array();
	if ($scheme == "http") {
		
		
		foreach ($linklist as $link) {
			$href = strtolower($link->getAttribute('href'));
			
			$href_link = trim(basename($href));
			$count = strcspn($href_link, ":");
			$find = str_split($href_link, $count+1);
			$key = $find[0];
			if ($key == "mailto:" || $key == "tel:" || $key == "javascript:") {
				#skip
			}else{
				if(isexternal($href) == 1){
					$output = $href."<br>";
				}else{
					$lk = ltrim($href_link, '.');
					$output = rtrim($url, '/')."/".rtrim($lk, '/')."<br>";
				}
			}
			if( in_array($output, $checked_links) ) { 
		       continue;
		    }
		    $checked_links[] = $output;
			echo $output;
		}

	}else if ($scheme == "https") {
		
		foreach ($linklist as $link) {
			$href = strtolower($link->getAttribute('href'));
			
			$href_link = trim(basename($href));
			$count = strcspn($href_link, ":");
			$find = str_split($href_link, $count+1);
			$key = $find[0];
			if ($key == "mailto:" || $key == "tel:" || $key == "javascript:") {
				#skip
			}else{
				if(isexternal($href) == 1){
					$output = $href."<br>";
				}else{
					$lk = ltrim($href_link, '.');
					$output = rtrim($url, '/')."/".rtrim($lk, '/')."<br>";
				}
			}
			if( in_array($output, $checked_links) ) { 
		       continue;
		    }
		    $checked_links[] = $output;
			echo $output;
		}
	}
	
}

function isexternal($url) {
  	$components = parse_url($url);
  	if ( empty($components['host']) ) return false;  // we will treat url like '/relative.php' as relative
  	if ( strcasecmp($components['host'], $url) === 0 ) return false; // url host looks exactly like the local host
  	return strrpos(strtolower($components['host']), '.'.$url) !== strlen($components['host']) - strlen('.'.$url); // check if the url host is a subdomain
}

echo check_all_links($url);
