<?php   

    /*
    *Base controller
    *loads models & views
    */

    class Controller{


        public function model($model)
        {
            require_once '../app/models/' . $model . '.php';

            return new $model(); //new Post();   
        }

        public function view($view, $data = [])
        {
            if(file_exists('../app/views/' . $view . '.php'))
            {
                require_once '../app/views/' . $view . '.php';
            }
            else {
                die("View not exists");
            }
        }


    }