<?php
namespace App\Controllers\Admin;

use System\Controller;

class LoginController extends Controller
{
    /**
     * Display Login Form
     * 
     * @return mixed
     */
    public function index()
    {
        $loginModel = $this->load->model('login');
        if ( $loginModel->isLogged() )
            return $this->url->redirectTo('/admin');

        $data['errors'] = $this->errors;
        return $this->view->render('admin/users/login',$data);
    }
    /**
     * Submit Login form
     * 
     * @return mixed
     */
    public function submit() {
        if ( $this->isValid() ){
            $loginModel = $this->load->model('login');
            $loggedInUser = $loginModel->user();
            if ( $this->request->post('remeber') )
                $this->cookie->set('login',$loggedInUser->code);
            else
                $this->session->set('login',$loggedInUser->code);

            return $this->url->redirectTo('/admin');
        }else
            return $this->index();
    }

    /**
     * Check Login Data
     * 
     * @return boolean
     */
    private function isValid()
    {
        $email = $this->request->post('email');
        $pass  = $this->request->post('password');

        if ( !$email )
            $this->errors[] = 'Please Insert Email Address';
        elseif ( !filter_var($email,FILTER_VALIDATE_EMAIL) )
            $this->errors[] = 'Please Insert Valid Email Address';
        
        if ( !$email )
            $this->errors[] = 'Please Insert Password';
        
        if ( !$this->errors ){   
            $loginModel = $this->load->model('login');
            if ( !$loginModel->isVaildLogin($email, $pass) )
                $this->errors[] = 'Invalid Login Data';
        }

        return empty($this->errors);
    }

}