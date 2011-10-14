<?php
class File extends Kohana_File{
static function destroy_directory($dir, $virtual = false)
  {
  	$ds = DIRECTORY_SEPARATOR;
  	$dir = substr($dir, -1) == $ds ? substr($dir, 0, -1) : $dir;
  	$dir = $virtual ? realpath(trim($dir,$ds)) : $dir;
  	
  	if (is_dir($dir) && $handle = opendir($dir))
  	{
  		while ($file = readdir($handle))
  		{
  			if ($file == '.' || $file == '..')
  			{
  				continue;
  			}
  			elseif (is_dir($dir.$ds.$file))
  			{
  				self::destroyDir($dir.$ds.$file);
  			}
  			else
  			{ 
  				unlink($dir.$ds.$file);
  			}
  		}
  		closedir($handle);
  		rmdir($dir);
  		return true;
  	}
  	else
  	{
  		return false;
  	}
  }
}

