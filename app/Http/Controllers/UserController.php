<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller {

    public function getIndex()
    {
        return view('users.index')
            ->with('usuarios', $this->arrayUsers);
    }

    public function getShow($id)
    {
            return view('users.show')
                ->with('usuarios', $this->arrayUsers[$id])
                ->with('id', $id);
    }

    public function getCreate()
    {
        return view('users.create');
    }

    public function getEdit($id)
    {
            return view('users.edit')
                ->with('usuarios', $this->arrayUsers[$id])
                ->with('id', $id);
    }

        private $arrayUsers = [
            [
                'email' => 'user0@marcapersonalFP.es',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'password' => 'password0',
                'linkedin' => 'https://www.linkedin.com/in/user0'
            ],
            [
                'email' => 'user1@marcapersonalFP.es',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'password' => 'password1',
                'linkedin' => 'https://www.linkedin.com/in/user1'
            ],
            [
                'email' => 'user2@marcapersonalFP.es',
                'first_name' => 'Alice',
                'last_name' => 'Johnson',
                'password' => 'password2',
                'linkedin' => 'https://www.linkedin.com/in/user2'
            ],
            [
                'email' => 'user3@marcapersonalFP.es',
                'first_name' => 'Bob',
                'last_name' => 'Williams',
                'password' => 'password3',
                'linkedin' => 'https://www.linkedin.com/in/user3'
            ],
            [
                'email' => 'user4@marcapersonalFP.es',
                'first_name' => 'Eva',
                'last_name' => 'Brown',
                'password' => 'password4',
                'linkedin' => 'https://www.linkedin.com/in/user4'
            ],
            [
                'email' => 'user5@marcapersonalFP.es',
                'first_name' => 'Michael',
                'last_name' => 'Taylor',
                'password' => 'password5',
                'linkedin' => 'https://www.linkedin.com/in/user5'
            ],
            [
                'email' => 'user6@marcapersonalFP.es',
                'first_name' => 'Sophie',
                'last_name' => 'Miller',
                'password' => 'password6',
                'linkedin' => 'https://www.linkedin.com/in/user6'
            ],
            [
                'email' => 'user7@marcapersonalFP.es',
                'first_name' => 'David',
                'last_name' => 'Davis',
                'password' => 'password7',
                'linkedin' => 'https://www.linkedin.com/in/user7'
            ],
            [
                'email' => 'user8@marcapersonalFP.es',
                'first_name' => 'Emily',
                'last_name' => 'White',
                'password' => 'password8',
                'linkedin' => 'https://www.linkedin.com/in/user8'
            ],
            [
                'email' => 'user9@marcapersonalFP.es',
                'first_name' => 'Tom',
                'last_name' => 'Wilson',
                'password' => 'password9',
                'linkedin' => 'https://www.linkedin.com/in/user9'
            ],
        ];
}

