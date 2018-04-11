#!/usr/bin/php
<?php
function get_imgs_url($html_str)
{
	$doc = new DOMDocument();
	libxml_use_internal_errors(true);
	if (!$doc->loadHTML($html_str))
		return (false);
	libxml_use_internal_errors(false);
	if (($imgs = $doc->getElementsByTagName('img')))
	{
		foreach ($imgs as $img)
			$ret[] = $img->getAttribute("src");
		return ($ret);
	}
	return (false);
}

function download_url($hosturl, $url)
{
	//check if url or uri
	if (!preg_match("/^https?:\/\/(www\.)?.+/", $url))
		$url = $hosturl . $url;
	//init url
	$ch = curl_init($url);
	
	$dir = parse_url($url,PHP_URL_HOST);
	if (!file_exists($dir) && !is_dir($dir)) 
		mkdir($dir);         
	$name = basename($url);
	
	$fp = fopen($dir . '/' . $name, 'wb');
	
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	
	fclose($fp);
}

if ($argc == 2)
{
	if (($hd = curl_init($argv[1])))
	{
		curl_setopt($hd, CURLOPT_RETURNTRANSFER, true);
		$html_str = curl_exec($hd);
		$urls = get_imgs_url($html_str);
		curl_close($hd);
		if ($urls)
		{
			foreach ($urls as $url)
				download_url($argv[1], $url);
		}
	}
}
?>
