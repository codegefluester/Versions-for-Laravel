<?php


class Version {

	static $table = "versions";
	
	/**
	* Save the current state of the object
	**/
	public static function save($src) {
		$cfg = Config::get('version');
		$data = json_encode($src->original);
		$table = strtolower(get_class($src));
		$obj_id = isset($src->original['id']) ? $src->original['id'] : false;
		if($obj_id) return DB::table(Version::getVersionsTable())->insert(array('data' => $data, 'object_table' => $table, 'object_id' => $obj_id));
		return false;
	}
	
	/**
	* Load a saved version from the database
	**/
	public static function load($version_id) {
		$data = DB::table(Version::getVersionsTable())->where_id($version_id)->first();
		$data->data = json_decode($data->data);
		return new $data->object_table($data->data);
	}
	
	/**
	* Get all saved versions for an specific object
	**/
	public static function getAllVersions($obj) {
		return DB::table(Version::getVersionsTable())->where('object_id', '=', $obj->attributes['id'])->where('object_table', '=', strtolower(get_class($obj)))->get();
	}
	
	/**
	* Get the last saved version of an object
	*/
	public static function getLastSavedVersion($obj) {
		return DB::table(Version::getVersionsTable())->where('object_id', '=', $obj->attributes['id'])->where('object_table', '=', strtolower(get_class($obj)))->order_by('created_at', 'desc')->first();
	}
	
	public static function getVersionsTable() {
		$cfg = Config::get('version');
		return $cfg['table'];
	}

}

?>