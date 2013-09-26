iTunes Affiliate Link Maker (iTalm)
====================================

Overview
--------

The plugin will add a button to the visual editor to run the iTunes Link Generator and offers link masking to hide your affiliate junk.

Why Would You Do This?
----------------------

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

Using iTalm
-----------

1. You can use ant to build a zip of the project `ant build` or alternatively;
2. Upload the `itunes-affiliate-link-maker` directory to the `/wp-content/plugins/` directory on your website
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Goto settings to setup the plugin

Upgrading from previous versions? backup prior to running the upgrade procedure.
0.5 and up now uses the [itunes] shorttag to drop links in, you can type them or search as per normal via
either editor.  Also if you're upgrading, please hit the reset link button next to the iTMS Link Generator URL
in the settings area if you'd like to search for Apps.

eg. `[itunes url="<storeurl>" title="<alttag>"]` outputs itunes link image with alt text
and `[itunes url="<storeurl>" title="<alttag>" content="<string>"]` outputs the string in content instead of the image


Meta
----

* Code: `git clone git://github.com/ruxton/iTALM.git`
* Home: <http://ignite.digitalignition.net/>