<?php

//  Here was the main bug which prevented the isharis's plugin from working in some server configurations
// (tinyMCE form just redirected to the site homepage).
//  A good practice is to locate the  WP loader and use the includes_url() function before loading needed resources.

// Ensure single declaration of function!
// Credits: http://wordpress.stackexchange.com/questions/32388/solutions-for-generating-dynamic-javascript-css
if(!function_exists('wp_locate_loader')):
    /**
     * Locates wp-load.php looking backwards on the directory structure.
     * It start from this file's folder.
     * Returns NULL on failure or wp-load.php path if found.
     *
     * @author EarnestoDev
     * @return string|null
     */
    function wp_locate_loader(){
        $increments = preg_split('~[\\\\/]+~', dirname(__FILE__));
        $increments_paths = array();
        foreach($increments as $increments_offset => $increments_slice){
            $increments_chunk = array_slice($increments, 0, $increments_offset + 1);
            $increments_paths[] = implode(DIRECTORY_SEPARATOR, $increments_chunk);
        }
        $increments_paths = array_reverse($increments_paths);
        foreach($increments_paths as $increments_path){
            if(is_file($wp_load = $increments_path.DIRECTORY_SEPARATOR.'wp-load.php')){
                return $wp_load;
            }
        }
        return null;
    }
endif;

// Now try to load wp-load.php and pull it in
if(!is_file($wp_loader = wp_locate_loader())){
    header("{$_SERVER['SERVER_PROTOCOL']} 403 Forbidden");
    header("Status: 403 Forbidden");
    echo 'Access denied!'; // Or whatever
    die;
}

require_once($wp_loader); // Pull it in
unset($wp_loader); // Cleanup variables

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Insert Tabs</title>
<style type='text/css' src='<?php echo includes_url('js/tinymce/themes/advanced/skins/wp_theme/dialog.css'); ?>'></style>
	<style type='text/css'>
	body { background: #f1f1f1; }
	#button-dialog { }
	#button-dialog div { padding: 10px 0; }
	#button-dialog label { display: block; margin: 0 8px 8px 0; color: #333; }
   #button-dialog input select,  #button-dialog input[type=text] { display: block; padding: 3px 5px; width: 90%; font-size: 1em; }
    #button-dialog textarea { display: block; padding: 3px 5px; width: 90%; font-size: 1em; }
	#button-dialog input[type=radio] { }
    #button-dialog input[type=submit] { padding: 5px; font-size: 1em; }
    #button-dialog input:disabled { background-color: #f1f1f1; }
	</style>
	
	<script type='text/javascript' src='<?php echo includes_url('js/jquery/jquery.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo includes_url('js/tinymce/tiny_mce_popup.js'); ?>'></script>

	
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#button-form').submit(function(e) {
            TabsDialog.insert(TabsDialog.local_ed);
		    e.preventDefault();
		});

        jQuery('input[name=type]').change(function() {
            var type = jQuery('input[name=type]:checked').val();
            if (type == 'classic') {
                jQuery('input#title').attr("disabled", true);
            } else {
                jQuery('input#title').removeAttr("disabled");
                jQuery('input#title').val(type[0].toUpperCase() + type.slice(1));
            }
        });

	var TabsDialog = {
			local_ed : 'ed',
			init : function(ed) {
				TabsDialog.local_ed = ed;
 				tinyMCEPopup.resizeToInnerSize();
			},
			insert : function insertButton(ed) {
                // Try and remove existing style / blockquote
				tinyMCEPopup.execCommand('mceRemoveNode', false, null);

				// set up variables to contain our input values
	var set = jQuery('select#set').val();
var titles = jQuery().val('input#titles');


				
				var output = '';
		 
				// setup the output of our shortcode
				output = '[tabs ';
				output +=' set="' + set + '"';
if (title)
output += '';

					output += ']'+TabsDialog.local_ed.selection.getContent() + '[/tabs]';
		
				tinyMCEPopup.execCommand('mceReplaceContent', false, output);

				// Return
				tinyMCEPopup.close();

				return false
			}
		};
		tinyMCEPopup.onInit.add(TabsDialog.init, TabsDialog);
	});
	</script>

</head>
<body>
	<div id="button-dialog">
		<form action="/" method="get" accept-charset="utf-8" id="button-form">
		
		<div>
		<label for="titles">Title</label>
		<input type="text" name="title" id="titles" value="" />
		
		
				</div>
			
			<div>
                <label for="set">Tab Style</label>
                <select name="set" id="set" size="1">
                <option value="1" selected="selected">1</option>
              <option value="2">2</option>
                <option value="3">3</option>
									
               </select>
			</div>

      
			<div>
				<input type='submit' value='Add a Button' />
			</div>
		</form>
	</div>
</body>
</html>