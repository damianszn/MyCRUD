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
 * @param array $inputs : all data fetched from db
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

function verifyLogin(array $inputs, string $username, string $password):array{
    foreach($inputs as $i => $input){
        if($input['username'] == $username){
            $index = $i;
        }
    }
    if(!isset($index)){
        var_dump($index);
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
function uploadImage(array $file, $id)
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

function pagesByPosts(int $posts):int{
    if($posts < 5){
        return 1;
    } elseif($posts % 5 == 0) {
        $result = $posts/5;
        return $result;
    } else {
        $result = $posts/5+1;
        return $result;
    }
}

function listOfPosts(array $data, int $indexMin, int $indexMax){
    $list = '';
    for($i = $indexMin; $i <= $indexMax; $i++){
        if(isset($data[$i])){
            $postData = $data[$i];

            $id = $postData['id'];
            $title = $postData['title'];
            $article = $postData['article'] ?? '';
            $ext = $postData['imageExt'];
            $picPath = $id.$ext;

            $list .= <<<HTML
            <a href="view.php?id=${id}">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">$title</h5>
                        <pre class="card-text">$article</pre>
                        <p class="card-text"><small class="text-muted"></small></p>
                    </div>
                    <img style='width:30vw' src='/users/images/${picPath}' class="card-img-top rounded mx-auto d-block">
                    <br>
                </div><br>
            </a>
HTML;
        }
    }
    return $list;
}

function postDetails(array $post){
    $output = '';
    $postDetails = [
        $post['artistName'],
        $post['albumName'],
        $post['songName']
    ];
    if($post['artistName'] != '' && $post['albumName'] != '' && $post['songName'] != ''){
        $output .= <<<HTML
        <div class="col-md-8">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">${post['artistName']}</li>
                    <li class="list-group-item">${post['albumName']}</li>
                    <li class="list-group-item">${post['songName']}</li>
                </ul>
            </div>
        </div>
HTML;
        return $output;
    }
    elseif($post['artistName'] != '' || $post['albumName'] != '' || $post['songName'] != ''){
        $output .= <<<HTML
        <div class="col-md-8">
            <div class="card-body">
                <ul class="list-group list-group-flush">
HTML;
        foreach($postDetails as $postDetail){
            if($postDetail !== ''){
                $output .= <<<HTML
                    <li class="list-group-item">${postDetail}</li>
HTML;
            }
        }
        $output .= <<<HTML
                </ul>
            </div>
        </div>
HTML;
        return $output;
    }
    else{
        return null;
    }
}

function postDetailsNoPic(array $post){
    $output = '';
    $postDetails = [
        $post['artistName'],
        $post['albumName'],
        $post['songName']
    ];
    if($post['artistName'] != '' && $post['albumName'] != '' && $post['songName'] != ''){
        $output .= <<<HTML
        <div class="col-md">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">${post['artistName']}</li>
                    <li class="list-group-item">${post['albumName']}</li>
                    <li class="list-group-item">${post['songName']}</li>
                </ul>
            </div>
        </div>
HTML;
        return $output;
    }
    elseif($post['artistName'] != '' || $post['albumName'] != '' || $post['songName'] != ''){
        $output .= <<<HTML
        <div class="col-md">
            <div class="card-body">
                <ul class="list-group list-group-flush">
HTML;
        foreach($postDetails as $postDetail){
            if($postDetail !== ''){
                $output .= <<<HTML
                    <li class="list-group-item">${postDetail}</li>
HTML;
            }
        }
        $output .= <<<HTML
                </ul>
            </div>
        </div>
HTML;
        return $output;
    }
    else{
        return null;
    }
}