<?php
/**
 * Give it the $_SERVER array, it will give you the route name.
 * 
 * @param array $_SERVER
 * 
 * Example : if the route is "/index.php", gives "index" back
 */
function getRouteName(array $server){
    $route = $server['PHP_SELF'];
    $routeName = substr($route, 1, -4); 
    return $routeName;
}
//////////////////////////////////////////////USERS////////////////////////////////////////s

/**
 * @param array $inputs : all data fetched from users
 * 
 * @param string $columnName : for example : 'email', 'username' 
 * 
 * @param string $value : the value to be tested
 * 
 * Returns "true" if there's no duplicate found in the $inputs, false if it founds a duplicate
 */
function isUnique(array $inputs,string $columnName ,string $value):bool{
    foreach($inputs as $input){
        if($input[$columnName] === $value){
            return false;
        } 
    }
    return true;
}   

function verifyLogin(array $inputs,string $username, string $password):array{
    foreach($inputs as $i => $input){
        if($input['username'] === $username){
            $index = $i;
        }
    }
    if(empty($index)){
        return [
            false,
            'username'
        ];
    } else {
        $goodPassword = $inputs[$index]['password'];
        $result = password_verify($password, $goodPassword);
        return [
            $result,
            'password'
        ];
    }
}

////////////////////////////////////////POSTS////////////////////////////////////
function uploadImage(array $file,int $id)
{
    if(!is_dir(__DIR__."/users/images")){
        mkdir(__DIR__."/users/images");
    }

    $info = pathinfo($file['image']['name']);
    $ext = $info['extension']; // get the extension of the file
    $newname = "$id.".$ext; 

    $target = 'users/images/'.$newname;
    move_uploaded_file( $file['image']['tmp_name'], $target);
}