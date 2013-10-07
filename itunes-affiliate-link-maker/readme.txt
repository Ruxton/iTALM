=== iTunes Affiliate Link Maker (iTALM) ===
Contributors: ruxton
Donate link: http://ignite.digitalignition.net/articlesexamples/itunes-affiliate-link-plugin/
Tags: editor,linking,affiliate,itunes,itunes store,itunes affiliate
Requires at least: 3.6.0
Tested up to: 3.6.1
Stable tag: 0.6.3

The plugin will add a button to the visual editor to run the iTunes Link Generator and offers link masking to hide your affiliate junk.

== Description ==

Do you link to the iTunes Store with or without an affiliate program? this plugins for you!

The plugin adds an itunes button to the visual editor which when clicked bring forward a jquery
dialog containing a search for the iTunes store link maker.

After searching, clicking on any link will ask for a title for the link and insert it into the
content editor. iTALM also enables the ability to directly link to albums, something the
standard link generator does not normally do.

iTALM also keeps track of recently clicked links and offers them up for clicking prior to
searching, while also offering a link masking to hide your affiliate junk from captain smarty pants.

As of 0.5.3 it now supports search on entities, What does this mean for you?
* searching for iPhone/iPad apps individually and for software developers
* searching specifically by artist/album/track name
* search for movies by artists/studio
* columns change based on the entity being searched for

As of 0.6 we now ONLY support using the PHG affiliate, which everything seems to be moving to.

== Installation ==

This section describes how to install the plugin and get it working.

1. Unzip the contents of the zip file
2. Upload the `itunes-affiliate-link-maker` directory to the `/wp-content/plugins/` directory on your website
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Goto settings to setup the plugin

Upgrading from previous versions? backup prior to running the upgrade procedure.
0.5 and up now uses the [itunes] shorttag to drop links in, you can type them or search as per normal via
either editor.  Also if you're upgrading, please hit the reset link button next to the iTMS Link Generator URL
in the settings area if you'd like to search for Apps.

eg. [itunes url="<storeurl>" title="<alttag>"] outputs itunes link image with alt text
and [itunes url="<storeurl>" title="<alttag>" content="<string>"] outputs the string in content instead of the image

== Frequently Asked Questions ==

= Dude, seriously.. what goes in all these boxes? =

Ok it's not an easy question, i know what goes in them for me and some others, but some of yours are going to be different
otherwise you're going to be using someone elses affiliate details.  But heres the short version to your answer..

Affiliate ID - this is your iTunes/PHP Affiliate ID, you will see it in the top right hand corner when you login to the PHG affiliate area.

= Ok now what? =

Questions anyone? feature ideas? i've got some thoughts on where i'd like to take it, but your input is appreciated.

== Screenshots ==

1. Initial screen upon clicking the button, showing previously clicked links sorted with most recent at the top
2. After clicking the Manual URL link, the input box swaps to an entry for iTunes store URL's
3. Showing the screen after searching
4. Showing the screen after clicking a link inside the search or history results
5. The end result how it looks in the editor (if you don't have any text selected)

== Upgrading ==

If you've come from a previous version of iTALM and you're not doing a fresh install, there's a chance you've
done some monkey patching to side step previous installation issues.  For example, some of you modified the ita-version variable,
this is used to detect upgradability, if you're using 0.5.2 please set it to 0.1 before proceeding with the upgrade.  On this, future
versions from (0.5.3 forward) will set this to the current version number, it was supposed to just be a database version number, but
all these different version numbers are obviously confusing people (me included), so from now on everything to do with iTALM will carry
the version number of the plugin it came from (this includes the plugin for tinyMCE support).
