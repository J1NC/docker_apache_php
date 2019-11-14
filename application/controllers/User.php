<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2019-11-13
 * Time: 오전 11:08
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
    }

    /**
     * 회원 가입
     * @METHOD POST
     * @MainURL /user/register
     * @Body
     *      @Required name, nickname, phone, password, email
     *      @Optional gender(male or female), recommender
     * @Response status, message
     */

    public function register() {
        $input = $this->input->post();

        if($this->form_validation->run('register_form') == FALSE) {
            $this->returnMsg(500,'fail', $this->form_validation->error_array());
        } else {
            $id = $this->UserModel->register($input);
            if($id > 0){
                if(isset($input['recommender'])){
                    $this->UserModel->recommend($input['recommender'], $id);
                }
                $this->returnMsg(200, 'Success', 'Register Success');
            } else {
                $this->returnMsg(500, 'fail', 'Register Failed');
            }
        }
    }


    /**
     * @param $httpCode integer HTTP 응답 코드
     * @param $status string fail or success
     * @param $message string Message
     * @return mixed
     */
    private function returnMsg($httpCode, $status, $message){
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header($httpCode)
            ->set_output(json_encode(array(
                'status' => $status,
                'message' => $message
            )));
    }
}