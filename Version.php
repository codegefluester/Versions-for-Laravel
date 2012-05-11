<?php


class Version {
	
	public static function freeze($src) {
		$data = json_encode($src->original);
		$table = strtolower(get_class($src));
		$obj_id = $src->original['id'];
		$doc = new Document();
		$doc->data = $data;
		$doc->object_table = $table;
		$doc->object_id = $obj_id;
		return $doc->save();
	}
	
	public static function unfreeze($document_id) {
		$data = Document::find($document_id);
		$data->data = json_decode($data->data);
		return new $data->object_table($data->data);
	}
	
	public static function getFrozenObjects($object_id, $object_table) {
		return Document::where('object_id', '=', $object_id)->where('object_table', '=', $object_table)->get();
	}

}

?>