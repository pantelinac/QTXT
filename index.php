<?php
require_once 'core/init.php';


if(Session::exists('home')){
    echo '<p>' . Session::flash('home'). '</p>';
}


$user = new User();


    if($user->isLoggedIn()){
        //echo 'Loged in!';
        ?>
        <p>Hello <a href="#"><?php echo escape($user->data()->name); ?></a></p>
        <ul>
            <li><a href="logout.php">Log out</a></li>
        </ul>

        <?php

    } else {
        echo '<p>You need to <a href="login.php">login</a> or <a href="register.php">register</a></p>';
    }

    $search = DB::getInstance();
    $search->get('users',array('email','LIKE','%%'));

    if (!$search->count()){
        echo 'No result';
    } else {
        foreach ($search->results() as $userr){
           echo $userr->name;
           echo '<br>';
           echo $userr->email;
           echo '<br>';
        }
    }

?>




<form action="" method="post">
    <br>
    <div class="field">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search">
    </div>

    <input type="submit" value="Search">
</form>
