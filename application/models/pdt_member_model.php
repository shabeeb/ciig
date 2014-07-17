<?php

if (!defined("BASEPATH"))
    exit('No direct script access allowed');

class Pdt_member_model extends CI_Model {

    /**
     * @var string
     * CMS Master table name
     */
    private $_table = 'pdt_member';
    private $_pk_field = 'member_id';
    private $list_colums = array('member_id', 'ig_id', 'card_number', 'first_name', 'last_name', 'dob', 'policy_start_date', 'policy_expiry_date', 'mobile_number', 'nationality_country_id', 'calling_country_id', 'gender', 'relationship', 'marital_status', 'email_address', 'emirates_id', 'labour_card', 'license', 'passport', 'last_updated_type', 'location', 'is_vip', 'status', 'reject_reason', 'is_active', 'created_on', 'created_by', 'last_modified_on', 'last_modified_by',);
    private $sort_colums_order = array('member_id', 'ig_id', 'card_number', 'first_name', 'last_name',);

    public function __construct() {

        parent::__construct();
        $this->load->database();
    }

    /**
     * Functon find by primery key
     * 
     * process  
     * 
     * @auther Shabeeb <me@faizshabeeb.com>
     * @createdon   : 2014-07-17 
     * @
     * 
     * @param type  id
     * @return type array
     * exceptions
     *
     * Created Usigng CIIgnator 
     * 
     */
    function findByPk($id) {

        $this->db->select("*");
        $this->db->from($this->_table);

        $this->db->where($this->_pk_field, $id);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = array_shift($query->result_array());

        return $result;
    }

    /**
     * Functon get_data
     * 
     * process for search result
     * 
     * @auther Shabeeb <me@faizshabeeb.com>
     * @createdon   : 2014-07-17 
     * @
     * 
     * @param type 
     * @return type
     * exceptions
     *
     * Created Usigng CIIgnator 
     * 
     */
    public function get_data($sort_num = 0, $sortby = "DESC", $limit, $start, $search = "") {

        $sort_field = $this->sort_colums_order[$sort_num];
        $this->db->select($this->sort_colums_order);
        $this->db->from($this->_table);

        $where = "is_active = 1";
        if (!empty($search)) {
            $search = mysql_escape_string($search);
        }


        $this->db->where($where, NULL, FALSE);
        $this->db->order_by($sort_field, $sortby);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();

        $result = $query->result_array();

        return $result;
    }

    function count_all_rows($search = "") {

        $this->db->select("COUNT(*) AS numrows");
        $this->db->from($this->_table);
        $where = "is_active = 1";
        if (!empty($search)) {
            //search condition      
        }


        $this->db->where($where, NULL, FALSE);
        return $this->db->get()->row()->numrows;
    }

}
