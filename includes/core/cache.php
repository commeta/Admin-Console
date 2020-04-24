<?php

########################################################################


/**
 * Checks if a folder exist and return canonicalized absolute pathname (sort version)
 * @param string $folder the path being checked.
 * @return mixed returns the canonicalized absolute pathname on success otherwise FALSE is returned
 */
function folder_exist($folder){
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it a directory
    return ($path !== false AND is_dir($path)) ? $path : false;
}





########################################################################

/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */

function get_cached($sub_dir,$file = false){
	if(cachePageAndDB){
		if($file){
			if(file_exists(root_path."cache/db/".$sub_dir."/".$file)){
				return(unserialize(file_get_contents(root_path."cache/db/".$sub_dir."/".$file)));
			}
		} else {
			if(file_exists("cache/db/".$sub_dir)){
				return(unserialize(file_get_contents(root_path."cache/db/".$sub_dir)));
			}
		}
	}
	return(false);
}


########################################################################

/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */

function set_cached($sub_dir,$file = false,$data){ // dir!
	if(cachePageAndDB){
		if(folder_exist(root_path."cache/db") === false) @mkdir(root_path."cache/db");
		
		if($file){
			if(folder_exist(root_path."cache/db/".$sub_dir) === false) @mkdir(root_path."cache/db/".$sub_dir);
			file_put_contents(root_path."cache/db/".$sub_dir."/".$file, $data);
		} else {
			file_put_contents(root_path."cache/db/".$sub_dir, $data);
		}
	}
}


########################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */

function get_cached_page($file){
	if(cachePageAndDB){
		if(file_exists(root_path."cache/pages/".$file)){
			return(file_get_contents(root_path."cache/pages/".$file));
		} else {
			ob_start();
			return(false);
		}
	} else {
		return(false);
	}
}


########################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */

function set_cached_page($file){
	if(cachePageAndDB){
		if(folder_exist(root_path."cache/pages") === false) @mkdir(root_path."cache/pages");
		
		file_put_contents(root_path."cache/pages/".$file, strip_comments(ob_get_contents()));
		ob_end_flush();
	}
}


########################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */

function clean_cache(){
	if(cachePageAndDB){
		if(folder_exist(root_path."cache/db")) recursiveRemoveDir(root_path."cache/db");
		if(folder_exist(root_path."cache/pages")) recursiveRemoveDir(root_path."cache/pages");
	}
	return true;
}


########################################################################
/**
 * Validate international link.
 *
 * @param string $link Link to validate.
 *
 * @return array
 */
function recursiveRemoveDir($dir) {
	$includes = glob($dir.'/{,.}*', GLOB_BRACE);
	$systemDots = preg_grep('/\.+$/', $includes);
	foreach ($systemDots as $index => $dot) {
		unset($includes[$index]);
	}
	foreach ($includes as $include) {
		if(is_dir($include) && !is_link($include)) {
			recursiveRemoveDir($include);
		}
		else {
			unlink($include);
		}
	}
	rmdir($dir);
}

?>
