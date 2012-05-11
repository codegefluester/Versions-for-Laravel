<?php


/**
 * @category    Bundle
 * @package     Version
 * @license 	MIT License <http://www.opensource.org/licenses/mit>
 * 
 * @see  https://github.com/Aboalarm/Versions-for-Laravel
 */




class Version {


	static $table = "versions";


	/**
	* Get the table name, where we will save the versions
	* from the Laravel config
	*
	* @return string
	*/
	public static function getVersionsTable() {
		$cfg = Config::get('version');
		return $cfg['table'];
	}

	
	/**
	* Save a version of the current state of an object. 
	* Will automatically check for duplicates and won't save them. 
	* You can specify a name for the version if you want to. 
	*
	* @param string $src
	* @param string $name
	* @return bool
	*/
	public static function add($src, $name = '') {
		$data 	= json_encode($src->original);
		$table 	= strtolower(get_class($src));
		$obj_id = isset($src->original['id']) ? $src->original['id'] : false;

		if($obj_id)
		{
			$creation_date = date('Y-m-d H:i:s');

			try
			{
				return DB::table(Version::getVersionsTable())
				->insert(array(
					'data' => $data, 
					'object_table' => $table, 
					'object_id' => $obj_id, 
					'name' => $name, 
					'hash' => md5($data),
					'created_at' => $creation_date, 
					'updated_at' => $creation_date, 
					));	
				
			}
			catch (Exception $e)
			{
				return false;
			}
			
		} 

		return false;
	}


	
	/**
	* Loads a specific saved version by its primary key
	*
	* @param int $version_id
	* @return object
	*/
	public static function load($version_id) {
		$data = DB::table(Version::getVersionsTable())->where_id($version_id)->first();
		$data->data = json_decode($data->data);
		return new $data->object_table($data->data);
	}
	


	/**
	* Get all versions of an object
	*
	* @param string $obj
	* @return array
	*/
	public static function all($obj) {
		return DB::table(Version::getVersionsTable())->where('object_id', '=', $obj->attributes['id'])->where('object_table', '=', strtolower(get_class($obj)))->order_by('updated_at', 'desc')->get();
	}



	/**
	* How many versions are saved for a given object? 
	*
	* @param string $obj
	* @return int
	*/
	public static function count($obj) {
		return DB::table(Version::getVersionsTable())->where('object_id', '=', $obj->attributes['id'])->where('object_table', '=', strtolower(get_class($obj)))->count();
	}


	
	/**
	* Retrieve the most recent version of an object
	*
	* @param string $obj
	* @return object
	*/
	public static function latest($obj) {
		return DB::table(Version::getVersionsTable())->where('object_id', '=', $obj->attributes['id'])->where('object_table', '=', strtolower(get_class($obj)))->order_by('created_at', 'desc')->first();
	}



	/**
	* Delete a version of an object
	*
	* @param int $version_id
	* @return bool
	*/
	public static function delete($version_id) {
		return DB::table(Version::getVersionsTable())->delete($version_id);
	}


	/**
	* Delete all versions of an object
	*
	* @param string $obj
	* @return bool
	*/
	
	public static function deleteAll($obj) {
		return DB::table(Version::getVersionsTable())->where('object_id', '=', $obj->attributes['id'])->where('object_table', '=', strtolower(get_class($obj)))->delete();
	}
	
	
	

}

?>