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

    const USER_TABLE = 'user';
    const RECOMMEND_TABLE = 'recommend';

    public function register($user) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $user['gender'] = isset($user['gender']) ? $user['gender'] : null;
        $user['recommendCode'] = uniqid();

        if(isset($user['recommender'])){
            $recommender = $user['recommender'];
            unset($user['recommender']);
        }

        $result = $this->db->insert(self::USER_TABLE, $user);
        $id = $this->db->insert_id();
        $this->recommend($recommender, $id);
        return $result;
    }

    public function update($user, $id) {
        return $this->db->update(self::USER_TABLE, $user, array('id' => $id));
    }

    public function delete($id) {
        return $this->db->delete(self::USER_TABLE, array('id' => $id));
    }

    public function recommend($recommender, $id) {
        $result = $this->db->get_where(self::USER_TABLE, array('recommendCode' => $recommender));
        $row = $result->row();
        if($row) {
            $recommenderId = $row->id;
        } else {
            return false;
        }
        $this->db->where(array('recommender' => $recommenderId));
        $count = $this->db->count_all_results(self::RECOMMEND_TABLE);

        if($count < 5) {
            $bind = array(
                'recommender' => $recommenderId,
                'recommendee' => $id
            );

            return $result = $this->db->insert(self::RECOMMEND_TABLE, $bind);
        }
        return false;
    }

    public function get($id) {
        $result = $this->db->get_where(self::USER_TABLE, array('id' => $id));
        $row = $result->row();

        unset($row->password);
        return $row;
    }

    public function getList($page, $limit) {
        $offset = ($page-1) * $limit;

        $result = $this->db->get(self::USER_TABLE, $limit, $offset);
        $result = $result->result();

        foreach($result as $row){
            unset($row->password);
        }
        return $result;
    }
}