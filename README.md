Versions for Laravel
====================

This is a bundle for the PHP Framework [**Laravel**](http://www.laravel.com "Laravel PHP Framework"). It let's you easily save the state of an Eloquent model aka a version into the database. You can also load versions of objects from the database at any time. This is very hand if you want to create histories of your changed data. 

Usage
====================

**Save a version**  
```
<?php
// Retrieve an object from the database
$user = User::find(1);

// Save the current state of the User
if(Version::add($user)) {
    echo 'Version saved.';
}
?>
```

**Load all versions of an object**
```
<?php
// Retrieve an object from the database
$user = User::find(1);
$all = Version::all($user);
print_r($all);
?>
```

**Load only the last saved version of an object**
```
<?php
// Retrieve an object from the database
$user = User::find(1);
$latest = Version::latest($user);
?>
```

**Load a specific version of an object**
```
<?php
$some_version = Version::load(3);
?>
```


**Count how many versions an object has**
```
<?php
$user = User::find(1);
$count = Version::count($user);
?>
```

**Delete all versions of an object**
```
<?php
$user = User::find(1);
Version::deleteAll($user);
?>
```

**Delete a specific version**
```
<?php
Version::delete(5);
?>
```