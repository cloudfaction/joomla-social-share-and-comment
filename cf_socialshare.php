<?php
/**
 * @author		M.J.Blokdijk (www.cloudfaction.nl)
 * @copyright	Copyright (C) 2014 M.J.Blokdijk. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


class plgContentCf_socialshare extends JPlugin
{
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onContentAfterDisplay($context, &$row, &$params, $page=0)
	{
		if ($context == 'com_content.article' || $context == 'com_content.featured' )
		{
			$html = '';

			//Get Params
			$excludedCategories = $this->params->def('excludedcategories');
            $facebookcomments = $this->params->get('facebookcomments','1');
			if($excludedCategories)
			{
				if(in_array($row->catid, $excludedCategories))
				{
					return;
				}
			}



if ($facebookcomments == 1) {$html = <<<EOD

<!-- AddThis Button BEGIN -->
<br><div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>


</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js" async="async"></script>
<!-- AddThis Button END -->


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-comments" data-href=
EOD;

 $html .= curPageURL();
 $html .= " data-width=100% data-numposts=5 data-colorscheme=light></div>";

}


if ($facebookcomments == 0) {$html = <<<EOD

<!-- AddThis Button BEGIN -->
<br><div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js" async="async"></script>
<!-- AddThis Button END -->

EOD;
}

        return $html;
		
		

		}
		return;
	}
}
