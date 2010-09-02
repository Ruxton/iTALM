(function() {
	// Load plugin specific language pack

	tinymce.create('tinymce.plugins.ita', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			var buttons = {  };
			ed.addButton('ita', {
				title : 'iTunes',
				image : url + '/itunes.png',
				onclick : function() {
					jQuery("#ita-dialog").dialog({ autoOpen: false, width: 750, minWidth: 750, height: 420, minHeight: 350, maxHeight: 750, title: 'iTunes Affiliate Link Maker', resizable: false });
			
					// Show the dialog now that it's done being manipulated
					jQuery("#ita-dialog").dialog("open");
			
					// Focus the input field
					jQuery("#ita-dialog-input").focus();
				}
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : "iTunes Affiliate Link Maker",
				author : 'Greg Tangey',
				authorurl : 'http://ignite.digitalignition.net/',
				infourl : 'http://ignite.digitalignition.net/',
				version : "0.5.3"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('ita', tinymce.plugins.ita);
})();

function ita_ok() {
	jQuery("#ita-dialog").dialog("close");	
}