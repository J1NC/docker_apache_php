<?php
$config = array
(
    'register_form' => array
    (
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|is_unique[User.email]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[10]|callback_check_password'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required|callback_check_name',
        ),
        array(
            'field' => 'nickname',
            'label' => 'Nickname',
            'rules' => 'trim|required|callback_check_nickname',
        ),
        array(
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'trim|required|integer',
        )
    )
);