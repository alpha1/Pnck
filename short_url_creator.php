<?php
class shortUrlCreator {
//class shortUrlCreator extends module {
protected $suc_source;
protected $suc_medium;
protected $suc_term;
protected $suc_content;
protected $suc_name;
protected $suc_create_short;

protected $suc_original;
protected $suc_final;
protected $suc_short;
protected $suc_create_tablesetup;

function __construct($name){
$this->name = $name;
	if(isset($_POST['suc_submit'])){
		$this->processForm();
	} else {
		$this->formSetup();
	}
}

function processForm(){
	foreach($_POST as $key=>$value){
		if(property_exists($this, $key)){
			$this->{$key} = $value;
		}
	}
	$this->getInfoFromWordpress($this->suc_original);
	$this->generateUrl();
}
function generateUrl(){
if(isset($this->suc_original)){
$final_url = "";
	if(!empty($this->suc_source)){
	$final_url = $final_url .'?utm_source='. $this->suc_source;
			if(!empty($this->suc_name)){
			$final_url = $final_url .'&utm_campaign='. $this->suc_name;
				if(!empty($this->suc_medium)){
				$final_url = $final_url .'&utm_source='. $this->suc_source;
					}else {
					//invalid
					}
			} else {
			//invalid
			}
	} else {
	//invalid
	}
	if(!empty($this->suc_term)){
	$final_url = $final_url .'&utm_term='. $this->suc_term;
	}
	if(!empty($this->suc_content)){
	$final_url = $final_url .'&tm_content='. $this->suc_term;
	}
$this->suc_final = $this->suc_original .$final_url;
	if($this->suc_create_short){
	$temp = urlencode($this->suc_final);
	$this->suc_final = trim(file_get_contents("http://magx.us?url=$temp"));	
	}
	if($this->suc_create_tablesetup){
	$this->generateTable();
	} else {
	echo $this->suc_final;
	}
	
}
}
public function getInfoFromWordpress(){
    $str = file_get_contents($this->suc_original);
    if(strlen($str)>0){
        preg_match("/\<title\>(.*)\<\/title\>/",$str, $title);
		$title = explode("|", $title[1]);
		$this->suc_page_title = $title[0];
		$this->suc_author = "TEST AUTHOR";
		$this->suc_article_title = "TEST TITLE";
		//$title = $this->suc_article_title;
    }
}

public function generateTable(){
$this->getInfoFromWordpress();
$this->suc_final = trim($this->suc_final);
$this->suc_page_title = trim($this->suc_page_title);
$output = '<a href="'.$this->suc_final .'" target="_blank">'."\n".'<span class="title">'.$this->suc_page_title.'</span></a>'."\n By ".$this->suc_author;
echo htmlentities($output);
echo "\n";
echo htmlentities($this->generateShares());
}

public function formSetup(){
echo '<form method="post" action="">';
echo "Do the world a favor and leave off the WWW if possible <br>\n";
	echo '<label>Original URL:<span class="formhelp">No Spaces</span></label>';
	echo '<input type="url" name="'.$this->name .'_original" id="'.$this->name .'_original" placeholder="https://example.com" required value="">'."<br>\n";
	echo '<label>Campaign Name: <span class="formhelp">No Spaces</span></label>';
	echo '<input type="text" name="'.$this->name .'_name" id="'.$this->name .'_name" placeholder="product_promo" pattern="^[-\w-]{2,}$" value="">'."<br>\n";
	echo '<label>Campaign Source: <span class="formhelp">No Spaces</span></label>';
	echo '<input type="text" name="'.$this->name .'_source" id="'.$this->name .'_source"  placeholder="newletter3" pattern="^[-\w]{2,}$" value="">'."<br>\n";
	echo '<label>Campaign Medium:<span class="formhelp">No Spaces</span></label>';
	echo '<input type="text" name="'.$this->name .'_medium" id="'.$this->name .'_medium" placeholder="bannerad" pattern="^[-\w]{2,}$" value="">'."<br>\n";
	
	echo '<label>Campaign Term:<span class="formhelp">No Spaces</span></label>';
	echo '<input type="text" name="'.$this->name .'_term" id="'.$this->name .'_term" placeholder="paid keyword term" pattern="^[-\w]{2,}$" value="">'."<br>\n";
	
	echo '<label>Campaign Content:<span class="formhelp">No Spaces. Additional info to sort sources</span></label>';
	echo '<input type="text" name="'.$this->name .'_content" id="'.$this->name .'_content" placeholder="homepage-top" pattern="^[\w]{3,}$" value="">'."<br>\n";
	echo '<label>Short Url?</label>';
	echo '<input type="checkbox" name="'.$this->name .'_create_short" id="'.$this->name .'_create_short">'."<br>\n";
		echo '<label>Create Table setup?</label>';
	echo '<input type="checkbox" name="'.$this->name .'_create_tablesetup" id="'.$this->name .'_create_tablesetup">'."<br>\n";
	echo '<input type="submit" name="'.$this->name .'_submit" id="'.$this->name .'_submit" value="Create Analytized link">'."<br>\n";
echo '</form>';
}

public function generateShares(){
$encodedLink = urlencode($this->suc_final);
$title = $this->suc_article_title;
$facebook = '<a href="https://facebook.com/sharer.php?u='.$encodedLink.'" title="Share on Facebook"target="_blank"><img src="http://www.magazinexperts.com/conexec/email_images/facebook.png" border="0" alt="Share on Facebook" /></a>';
$tweet =  urlencode($title .' '. $this->suc_final . ' via @constructionmag');
$twitter = '<a href="http://twitter.com/?status='.$tweet.'" title="Share on Twitter"target="_blank"><img src="http://www.magazinexperts.com/conexec/email_images/twitter.png" border="0" alt="Twitter" /></a>';
$linkedin = '<a href="http://www.linkedin.com/shareArticle?mini=true&url='.$this->suc_final .'"title="Share on Linkedin"target="_blank"><img src="http://www.magazinexperts.com/conexec/email_images/linkedin.png" border="0" alt="Share on Linkedin" /></a>';
$share = $facebook ."\n $twitter \n $linkedin";
return $share;
}
}
?>