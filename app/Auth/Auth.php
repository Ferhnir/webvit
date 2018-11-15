<?php

namespace App\Auth;

use App\Models\CharityAdmin;

class Auth
{

    public function check()
    {

        return isset($_SESSION['admin']);

    }

    public function admin()
    {

        if($this->check()){

            return CharityAdmin::find($_SESSION['admin']);
        
        } else {

            return null;

        }

    }

    public function attempt($email, $password)
    {

        $admin = CharityAdmin::where('email',$email)->first();

        if(!$admin)
        {
            return false;
        }

        if(password_verify($password, $admin->password))
        {
            $_SESSION['admin'] = $admin->id;
            return true;
        }

    }
    
    public function logout()
    {

        unset($_SESSION['admin']);

    }

    public function updatePassword($email, $new_password)
    {

        $admin = CharityAdmin::where('email',$email)->first();

        $admin->password = password_hash($new_password, PASSWORD_BCRYPT);
    
        $admin->save();

    }

}