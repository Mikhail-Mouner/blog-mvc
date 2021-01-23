<?php
namespace App\Models;

use System\Model;

class LoginModel extends Model
{
    protected $table = 'users';
    protected $user ;
    
    /**
     * Determine if the given Login data is valid
     * 
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function isVaildLogin($email, $password)
    {
        $user = $this->from($this->table)->where('email = ?' ,$email)->fetch();
        if ( !$user )
            return false;
            
        $this->user = $user;
        return password_verify($password, $user->password);
    }

    /**
     * Get Logged In User Data
     * 
     * @return \stdClass
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Determine whether the user is logged in
     * 
     * @return boolean
     */
    public function isLogged()
    {
        if ($this->cookie->has('login')) 
            $code = $this->cookie->get('login');
        elseif ($this->session->has('login')) 
            $code = $this->session->get('login');
        else 
            $code = '';

        $user = $this->from($this->table)->where('code = ?', $code )->fetch();
        
        if (!$user)
            return false;
            
        $this->user = $user;
        return true;

    }
}
