{* Document-Type and Level is set *}
{doc_info DOCTYPE=XHTML LEVEL=Transitional}

{* doc_raw movement! -> everything in doc_raw is moved "as is" to header *}
{doc_raw}

{* Dublin Core Metatags *}
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
<meta name="DC.Title" content="Clansuite - just an eSport CMS" />
<meta name="DC.Creator" content="Tino Goratsch" />
<meta name="DC.Date" content="20070101" />
<meta name="DC.Identifier" content="http://www.clansuite.com/" />
<meta name="DC.Subject" content="Subject" />
<meta name="DC.Subject.Keyword " content="Subject.Keyword" />
<meta name="DC.Subject.Keyword" content="Subject.Keyword" />
<meta name="DC.Description" content="Description" />
<meta name="DC.Publisher" content="Publisher" />
<meta name="DC.Coverage" content="Coverage" />

{* Standard Metatags *}
<meta http-equiv="content-language" content="{$meta.language}" />
<meta name="author" content="{$meta.author}" />
<meta http-equiv="reply-to" content="{$meta.email}" />
<meta name="description" content="{$meta.description}" />
<meta name="keywords" content="{$meta.keywords}" />

{* Favicon Include *}
<link rel="shortcut icon" href="{$www_root_themes}/images/favicon.ico" />
<link rel="icon" href="{$www_root_themes}/images/animated_favicon.gif" type="image/gif" />

{* Inserts from index.php *}
<link rel="stylesheet" type="text/css" href="{$www_root_themes}/css/accessible.css" />
<link rel="stylesheet" type="text/css" href="{$www_root_themes}/css/ui.datepicker.css" />
<script type="text/javascript" src="{$www_root_themes}/javascript/jquery.js"></script>
<script type="text/javascript" src="{$www_root_themes}/javascript/jquery.dimensions.js"></script>
<script type="text/javascript" src="{$www_root_themes}/javascript/ui.accordion.js"></script>
<script type="text/javascript" src="{$www_root_themes}/javascript/ui.datepicker.js"></script>
<script type="text/javascript" src="{$www_root_themes}/javascript/accessible.js"></script>
{if isset($additional_head)} {$additional_head} {/if}
{if isset($redirect)} {$redirect} {/if}

{* set title - and apply -breadcrumb title="1"- to it *}
<title>{$std_page_title} - {breadcrumbs title="1" trail=$trail separator=" &raquo; " length=30}</title>
{* display cache time as comment *}
<!-- page cached on {$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"} -->
{/doc_raw}
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:80;"></div>
<div id="box">
	<div id="header">
		<h1 id="clansuite_title">Clansuite - just an eSports CMS</h1>
		<ul id="navigation">
			<li><a href="index.php?mod=news">News</a></li>
			<li><a href="index.php?mod=news&amp;action=archiv">Newsarchiv</a></li>
			<li><a href="index.php?mod=board">Board</a></li>
			<li><a href="index.php?mod=guestbook">Guestbook</a></li>
			<li><a href="index.php?mod=serverlist">Serverlist</a></li>
			<li><a href="index.php?mod=userslist">Userslist</a></li>
			<li><a href="index.php?mod=staticpages&amp;page=credits">Credits</a></li>
			<li><a href="index.php?mod=staticpages&amp;action=overview">Static Pages Overview</a></li>
		</ul>
	</div>
	<div id="breadcrumb">
		{* Breadcrumbs Navigation *}
		{include file='tools/breadcrumbs.tpl'}
	</div>
	<div id="sidebar">
		{* {mod name="account" func="login"} *}
		{* {mod name="shoutbox" func="show"} *}
		<h3>Lorem Ipsum</h3>
		<div class="content">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent pede quam, viverra ac, egestas eu, fringilla at, est. Curabitur ligula nunc, tempus adipiscing, posuere eget, posuere vitae, sem. Nam sed tellus ac sem tempor scelerisque. Nulla nec felis ut arcu porta adipiscing. Duis non mi id purus porttitor cursus. Etiam ac augue. Donec fermentum, elit non ultrices rhoncus, erat justo viverra velit, id facilisis nisl risus vel elit. Nullam posuere. Fusce pulvinar. Suspendisse tortor quam, vestibulum eget, dignissim a, elementum at, orci. Nunc placerat purus in nisi. Quisque placerat nunc a risus. Nullam imperdiet neque vitae arcu. Quisque imperdiet ullamcorper arcu. Phasellus vitae urna. In vehicula ultrices nunc.
		</div>
		<h3>Calendar</h3>
		<div id="calendar" class="content">
		</div>
		<h3>{t}Statistics{/t}</h3>
		<div id="counter" class="content">
    		<ul>
    			<li>
    				<strong>Online:</strong>{* {$stats|@var_dump}  *} {$stats.online}
    				<ul>
    					<li><strong>Users:</strong> {$stats.authed_users}</li>
    					<li><strong>Guests:</strong> {$stats.guest_users}</li>
    				</ul>
    				<strong>Who is online?</strong>
    				{if $stats.authed_users > 1}
    				<ul>
    					{foreach item=who from=$stats.whoisonline}
    					<li><a href="index.php?={$who.user_id}">{$who.nick} @ {$who.session_where}</a></li>
    					{/foreach}
    				</ul>
    				{elseif $stats.authed_users == 1}
    				<ul>
    					<li><a href="index.php?={$stats.whoisonline.0.user_id}">{$stats.whoisonline.0.nick}</a> @ {$stats.whoisonline.0.session_where}</li>
    				</ul>
    				{/if}
    			</li>
    			<li><strong>Today:</strong> {$stats.today_impressions}</li>
    			<li><strong>Yesterday:</strong> {$stats.yesterday_impressions}</li>
    			<li><strong>Month:</strong> {$stats.month_impressions}</li>
    			<li><strong>This Page:</strong> {$stats.page_impressions}</li>
    			<li><strong>Total Impressions:</strong> {$stats.all_impressions}</li>
    		</ul>
		</div>
	</div>
	<div id="content">
		{$content}
	</div>
	<div id="footer">
		<!-- Footer with Copyright, Theme-Copyright, tpl-timeing and db-querycount // -->
		{$copyright}<br />
		Theme: {* {$theme-copyright} *}
		<br/>
		{include file='server_stats.tpl'}
	</div>
</div>
{* Ajax Notification *}
<div id="ajax-bar">
    <img src="{$www_root_themes_core}/images/ajax/2.gif" alt="Ajax Notification Image" />
    &nbsp; Wait - while processing your request...
</div>