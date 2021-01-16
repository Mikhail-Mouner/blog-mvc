<?php 
namespace App\Controllers;

use System\Controller;

class HomeController extends Controller
{
    
    public function index() {
        /*
        $id = $this->db->table('users')
                ->data([
                    'first_name' => 'Mi5a',
                    'email' => 'mi5a@yahoo.com',
                    ])
                ->insert()->lastID();
        */
        
        //pre($this->db->select('id,email')->from('users')->orderBy('id','DESC')->fetchAll());
        //$this->db->query('INSERT INTO users SET first_name = ?, email = ?','Mi5a','mi5a@yahoo.com');
        //$this->db->table('users')->truncate();
        pre($this->url->link('/home/test/'));
        $users = $this->load->model('Users');
        pre($users->all());
        //return $this->view->render('home');
    }

}