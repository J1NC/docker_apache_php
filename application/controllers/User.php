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
        if(strcmp($this->input->method(), 'post')) {
            $this->returnMsg(405, 'fail', 'Method Not Allowed');
            return;
        }

        $input = $this->input->post();
        if($this->form_validation->run('register_form') == FALSE) {
            $this->returnMsg(500,'fail', $this->form_validation->error_array());
        } else {
            $id = $this->UserModel->register($input);
            if($id > 0) {
                $this->returnMsg(200, 'success', 'Register Success');
            } else {
                $this->returnMsg(500, 'fail', 'Register Failed');
            }
        }
    }

    /**
     * 회원 정보 수정
     * @METHOD PUT
     * @MainURL /user/update/{id}
     * @Parameter id
     * @Body
     *      @Optional name, nickname, phone, gender(male or female)
     * @Response status, message
     */
    public function update($id){
        if(strcmp($this->input->method(), 'put')) {
            $this->returnMsg(405, 'fail', 'Method Not Allowed');
            return;
        }

        $user = $this->UserModel->get($id);
        $input = $this->input->input_stream();

        $this->form_validation->set_data($input);
        if($user) {
            if($this->form_validation->run('update_form') == FALSE) {
                $this->returnMsg(500,'fail', $this->form_validation->error_array());
            } else {
                if(isset($input['name'])) {
                    $user->name = $input['name'];
                }
                if(isset($input['nickname'])) {
                    $user->nickname = $input['nickname'];
                }
                if(isset($input['phone'])) {
                    $user->phone = $input['phone'];
                }
                if(isset($input['gender'])) {
                    $user->gender = $input['gender'];
                }

                $result = $this->UserModel->update($user, $id);
                if($result) {
                    $this->returnMsg(200, 'success', 'User Updated!');
                } else {
                    $this->returnMsg(500, 'fail', 'User Update Failed');
                }
            }
        } else {
            $this->returnMsg(500, 'fail', 'Id is Incorrect');
        }
    }

    /**
     * 회원 삭제
     * @METHOD DELETE
     * @MainURL /user/delete/{id}
     * @Parameter id
     * @Response status, message
     */
    public function delete($id) {
        if(strcmp($this->input->method(), 'delete')) {
            $this->returnMsg(405, 'fail', 'Method Not Allowed');
            return;
        }

        $user = $this->UserModel->get($id);
        if($user) {
            $result = $this->UserModel->delete($id);
            if($result) {
                $this->returnMsg(200, 'success', 'User Deleted');
            } else {
                $this->returnMsg(500, 'fail', 'User Delete Failed');
            }
        } else {
            $this->returnMsg(500, 'fail', 'Id is Incorrect');
        }
    }

    /**
     * 회원 한명 조회
     * @METHOD GET
     * @MainURL /user/get/{id}
     * @Parameter id
     * @Response status, message, data
     */
    public function get($id) {
        if(strcmp($this->input->method(), 'get')) {
            $this->returnMsg(405, 'fail', 'Method Not Allowed');
            return;
        }

        $user = $this->UserModel->get($id);
        if($user) {
            $this->returnMsg(200, 'success', 'User Found!', $user);
        } else {
            $this->returnMsg(500, 'fail', 'Id is Incorrect');
        }
    }

    /**
     * 회원 리스트 조회
     * @METHOD GET
     * @MainURL /user/getList/{page}/{limit}
     * @Parameter page, limit
     * @Response status, message, data
     */
    public function getList() {
        if(strcmp($this->input->method(), 'get')) {
            $this->returnMsg(405, 'fail', 'Method Not Allowed');
            return;
        }

        $page = (int) $this->uri->segment(3, 1);
        $limit = (int) $this->uri->segment(4, 10);

        $users = $this->UserModel->getList($page, $limit);
        if($users) {
            unset($users->password);
            $this->returnMsg(200, 'success', 'User Found!', $users);
        } else {
            $this->returnMsg(500, 'fail', 'No User Found');
        }
    }

    public function _checkName($name) {
        if(preg_match("/[0-9]/", $name))
            return false;

        if(preg_match("/[!#$%^&*()?+=\/]/", $name))
            return false;

        return true;
    }

    public function _checkPassword($password) {
        if(preg_match("/[a-z]/", $password)) {
            if (preg_match("/[A-Z]/", $password)) {
                if (preg_match("/[0-9]/", $password)) {
                    if (preg_match("/[!@#$%^&*()?+=\/]/", $password)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function _checkNickname($nickname) {
        return ctype_lower($nickname);
    }

    public function _checkGender($gender)
    {
        $genderList = array('male', 'female');
        if (!$gender){
            return true;
        } else {
            if(array_search($gender, $genderList) === false)
                return false;
        }
    }
    /**
     * @param $httpCode integer HTTP 응답 코드
     * @param $status string fail or success
     * @param $message string Message
     * @param $data mixed
     * @return mixed
     */
    private function returnMsg($httpCode, $status, $message, $data = null){
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header($httpCode)
            ->set_output(json_encode(array(
                'status' => $status,
                'message' => $message,
                'data' => $data
            )));
    }
}