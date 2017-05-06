<?php

function user_count() {
    global $db;
    $results = $db->query("
        SELECT *
        FROM users
    ");

    $counter = 0;
    while($row = $results->fetchArray(SQLITE3_ASSOC)) {
        $counter++;
    }

    return $counter;
}

function initialize_users() {
        global $db;
        if(!user_exists('admin')){
          $default_pw_hash = sha1('admin');
          $name = 'ادمین';
          $db->query("
              INSERT INTO users (username, password, first_name, last_name) VALUES
              ('admin', '$default_pw_hash', '$name', '');
          ");
        }
}

function get_user($username) {
    if(!$username) {
        return null;
    }

    global $db;
    $result = $db->query("
        SELECT *
        FROM users
        WHERE username = '$username'
    ");

    $row = $result->fetchArray(SQLITE3_ASSOC);
    return $row;
}

function user_exists($username) {
    $user = get_user($username);
    return isset($user['id']);
}

function add_users($username, $password, $first_name, $last_name) {

    /*if(!$userdata['username']) {
        return;
    }
    $username = $userdata['username'];*/

    $password = sha1($password);
    if(!$last_name){
      $last_name = null;
    }

    global $db;
    if(!user_exists($username)) {
        $db->query("
            INSERT INTO users (username, password, first_name, last_name) VALUES
            ('$username', '$password', '$first_name', '$last_name');
        ");

    } else {
        $db->query("
            UPDATE users
            SET password = '$password', first_name = '$first_name', last_name = '$last_name'
            WHERE username = '$username';
        ");

    }
}

function update_user($userdata) {
    add_users($userdata);
}

function delete_user($username) {
    if(!user_exists($username)) {
        return;
    }

    global $db;
    $db->query("
        DELETE FROM users
        WHERE username = '$username';
    ");
}
