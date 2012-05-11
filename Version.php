<?php


class Version {

	static $table = "versions";
	
	/**
	* Save the current state of the object
	**/
	public static function freeze($src) {
		$data = json_encode($src->original);
		$table = strtolower(get_class($src));
		$obj_id = $src->original['id'];
		return DB::table(Version::$table)->insert(array('data' => $data, 'object_table' => $table, 'object_id' => $obj_id));
	}
	
	/**
	* Load a saved version from the database
	**/
	public static function unfreeze($document_id) {
		$data = DB::table(Version::$table)->where_id($document_id)->first();
		$data->data = json_decode($data->data);
		return new $data->object_table($data->data);
	}
	
	/**
	* Get all saved versions for an specific object
	**/
	public static function getFrozenObjects($object_id, $object_table) {
		return DB::table(Version::$table)->where('object_id', '=', $object_id)->where('object_table', '=', $object_table)->get();
	}
	
	/**
	* Get the last saved version of an object
	*/
	public static function getLatestFreeze($object_id, $object_table) {
		return DB::table(Version::$table)->where('object_id', '=', $object_id)->where('object_table', '=', $object_table)->order_by('created_at', 'desc')->first();
	}

}

?>