Versions for Laravel
====================

This is a bundle for the PHP Framework [**Laravel**](http://www.laravel.com "Laravel PHP Framework"). It let's you easily save the state of a Eloquent model aka a version into the database. You can also load "frozen" objects from the database at any time.

Usage
====================

**Save a version**  
```
<?php
// Retrieve an object from the database
$old_object = User::find(1);

// Save a version
if(Version::freeze($old_object)) {
    echo 'Version saved.';
}
?>
```

**Load all versions of an object**
```
<?php
$all = Version::getFrozenObjects(1, 'user');
print_r($all);
?>
```

**Load only the last saved version of an object**
```
<?php
$last_version = Version::getLatestFreeze(1, 'user');
?>
```

**Load a specific version of an object**
```
<?php
$oldest_version = Version::unfreeze(3);
?>
```