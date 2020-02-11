<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {

        $post = \App\User::find(1); //trouver le post avec l’id 1


        print_r($post);
        die;
//        echo $post->author->name; //affiche le nom de l’auteur

//        $users = \App\User::find(1)->posts; //get posts from user id 1
//        foreach ($posts as $post) {
//            //loop on posts
//        }



        return view('welcome');
    }
}
