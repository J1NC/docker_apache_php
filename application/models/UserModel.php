<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2019-11-13
 * Time: 오전 11:11
 */

class UserModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function register($user) {
        $user['recommendCode'] = uniqid();

        $sql = "  INSERT INTO User
                          (name, nickname, password, phone, email, gender, recommendCode)
                          VALUES
                          (?, ?, ?, ?, ?, ?, ?)
            ";

        $bind = array(
            $user['name'],
            $user['nickname'],
            password_hash($user['password'], PASSWORD_DEFAULT),
            $user['phone'],
            $user['email'],
            isset($user['gender']) ? $user['gender'] : null,
            $user['recommendCode']
        );

        $result = $this->db->query($sql, $bind);
        return $this->db->insert_id();
    }

    public function update($user, $id) {
        return $this->db->update('User', $user, array('id' => $id));
    }

    public function recommend($recommender, $id) {
        $sql = "SELECT id
                FROM User
                WHERE RecommendCode = ?";

        $result = $this->db->query($sql, array($recommender));
        $row = $result->row();
        $recommenderId = $row->id;

        $sql = "SELECT count(*) as cnt
                FROM Recommend
                WHERE Recommender = ?";

        $result = $this->db->query($sql, array($recommenderId));
        $row = $result->row();
        $count = $row->cnt;

        if($count < 5) {
            $sql = "INSERT INTO Recommend
                        (recommender, recommendee)
                        VALUES
                        (?, ?)";

            $bind = array(
                $recommenderId,
                $id
            );

            $result = $this->db->query($sql, $bind);

            return $result;
        }
        return false;
    }

    public function get($id) {
        $sql = "SELECT *
                FROM User
                WHERE id = ?";

        $result = $this->db->query($sql, array($id));
        $row = $result->row();

        return $row;
    }
}