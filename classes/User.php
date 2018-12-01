<?php
class User {
    private $_db,
        $_data,
        $_sessionName,
        $_isLoggedIn;

    public function __construct($user = null){
        $this->_db = DB::getInstance();
        $this ->_sessionName = Config::get('session/session_name');

        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);
                if($this->find($user)){
                    $this->_isLoggedIn = true;
                } else {
                    //proces logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields){
        if(!$this->_db->insert('users', $fields)){
            throw new Exception('There was problem creating an account.');
        }
    }

//find users by email or id
    public function find($user = null){
        if($user){
            $fild = (is_numeric($user)) ? 'id' : 'email';
            $data = $this->_db;
            $data->get('users', array($fild, '=', $user));

            if($data->count()){
                //$this->_data = $data->first();
                $this->_data = $data->results()[0];
                //echo 'var data je puna';
                return true;
            }
        }
        return false;
    }

    public function login($email = null, $password = null){

        $user = $this->find($email);



        if($user){

            if(password_verify($password,$this->data()->password)){
                Session::put($this->_sessionName, $this->data()->id);
                return true;
            }

        }

        return false;
    }

    public function logout(){
        Session::delete($this->_sessionName);
    }

    public function data(){
        return $this->_data;
    }

    public function isLoggedIn (){
        return $this->_isLoggedIn;
    }
}