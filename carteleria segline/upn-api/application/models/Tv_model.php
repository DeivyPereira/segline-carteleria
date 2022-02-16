<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tv_model extends MY_Model
{
    protected $_table_name = 'tv';
    public $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_timestamps = true;
    protected $soft_delete = true;
    protected $_order_by = '';

    public $belongs_to = array();
    public $_direction = 'asc';
}