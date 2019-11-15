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
            'rules' => 'trim|required|min_length[10]|callback__checkPassword'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required|callback__checkName',
        ),
        array(
            'field' => 'nickname',
            'label' => 'Nickname',
            'rules' => 'trim|required|callback__checkNickname',
        ),
        array(
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'trim|required|integer',
        )
    ),
    'update_form' => array
    (
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|callback__checkName',
        ),
        array(
            'field' => 'nickname',
            'label' => 'Nickname',
            'rules' => 'trim|callback__checkNickname',
        ),
        array(
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'trim|integer',
        )
    )
);