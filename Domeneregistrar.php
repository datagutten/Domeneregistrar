<?php
function domener($orgnr)
{

$brreg=file_get_contents('http://w2.brreg.no/enhet/sok/detalj.jsp;?orgnr='.$orgnr); //Hent info fra brreg
preg_match('^Navn/foretaksnavn:.*\<p\>(.*)\</p\>^Us',$brreg,$navn); //Finn navnet på organisjonen
echo "<h2>$orgnr - {$navn[1]}</h2>";

$data=file_get_contents('http://www.norid.no/domenenavnbaser/whois/?charset=UTF-8&query='.$orgnr); //Hent info om organisasjonsnummeret

preg_match_all('^NORID Handle.*\>(.*)\<.*\n.*Registrar Handle.*\>(.*)\<^',$data,$handles); //Finn alle NORID handles og registrar handles


for($i=0; $i<count($handles[1]); $i++)
{
	$norid=file_get_contents('http://www.norid.no/domenenavnbaser/whois/?charset=UTF-8&query='.$handles[1][$i]); //Hent info om NORID handle
	$reg=file_get_contents('http://www.norid.no/domenenavnbaser/whois/?charset=UTF-8&query='.$handles[2][$i]); //Hent info om registrar handle
	preg_match_all('^Domains.*\:(.*)\</pre\>^sU',$norid,$domene); //Finn domenet
	
	preg_match('^Registrar Name.*: (.*)^',$reg,$name); //Finn navnet på registrar
	preg_match('^Web Address.*: (.*)^',$reg,$web); //Finn registrarens webadresse
	
	echo "<p>";
	echo "<a href=\"{$web[1]}\">{$name[1]}</a>:<br>\n";
	echo trim(strip_tags($domene[1][0]))."<br>\n"; //Vis domenet
	echo "</p>";
}
}
?>
