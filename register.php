<?php

require_once 'core/init.php';

if(Input::exists()){
    if(Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 40
            ),
            'email' => array(
                'required' => true,
                'min' => 6,
                'max' => 50,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_sec' => array(
                'required' => true,
                'matches' => 'password'
            )

        ));

        if ($validation->passed()) {
            $user = new User();



            try{
                $user->create( array(
                    'email'    => Input::get('email'),
                    'password' => Hash::make(Input::get('password')),
                    'name'     => Input::get('name'),
                    'created_at'   => date('Y-m-d H:i:s')
                ));

                Session::flash('home', 'You have been registered and can now log in.');
                Redirect::to('index.php');

            } catch (Exception $e) {
                die($e->getMessage());
            }

        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}
?>

<form action=" " method="POST">
    <div class="field">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name">
    </div>
    <br>
    <div class="field">
        <label for="email">Email: </label>
        <input type="text" name="email" id="email"  autocomplete="off">
    </div>
    <br>
    <div class="field">
        <label for="password">Chose password: </label>
        <input type="password" name="password" id="password">
    </div>
    <br>
    <div class="field">
        <label for="password_sec">Enter password again: </label>
        <input type="password" name="password_sec" id="password_sec">
    </div>


    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    <input type="submit" value="Register">
</form>