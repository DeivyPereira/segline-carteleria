<?php

class MY_Model extends CI_Model {

	

	protected $_table_name = '';

    protected $_primary_key = 'id';

    protected $_primary_filter = 'intval';

    protected $_timestamps = FALSE;

    protected $_order_by = '';

    

    public $_direction = 'asc';

    public $rules = array();

    

    public $_table_fields_insert = array();


    /**
     * Support for soft deletes and this model's 'deleted' key
     */
    protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;
    protected $_temporary_only_deleted = FALSE;
    /**
     * The various callbacks available to the model. Each are
     * simple lists of method names (methods will be run on $this).
     */
    protected $before_create = array();
    protected $after_create = array();
    protected $before_update = array();
    protected $after_update = array();
    protected $before_get = array();
    protected $after_get = array();
    protected $before_delete = array();
    protected $after_delete = array();
    protected $callback_parameters = array();
    /**
     * Protected, non-modifiable attributes
     */
    protected $protected_attributes = array();
    /**
     * Relationship arrays. Use flat strings for defaults or string
     * => array to customise the class name and primary key
     */
    protected $belongs_to = array();
    protected $has_many = array();
    protected $_with = array();
    /**
     * Optionally skip the validation. Used in conjunction with
     * skip_validation() to skip data validation for any future calls.
     */
    protected $skip_validation = FALSE;
    /**
     * By default we return our results as objects. If we need to override
     * this, we can, or, we could use the `as_array()` and `as_object()` scopes.
     */
    protected $return_type = 'object';
    protected $_temporary_return_type = NULL;
    function __construct() {

        parent::__construct();
        $this->_temporary_return_type = $this->return_type;
        $this->_table_name = $this->_table_name.config_item('tablename_prefix');

    }

    

    

    public function getID(){

    	$this->db->limit(1);

    	return $this->db->get($this->_table_name)->row()->{$this->_primary_key};

    }




     public function hash($string) {

            

        return hash('md5', $string. config_item('encryption_key'));



    }

     

    /**

     * Funciton get:

     * 

     * 

     * @param numeric $id

     * @param bool $single =  si es verdadero trae un resultado tipo obj

     * @param Bool $result_array = si $single es falso  y result_array TRUE retorna un arreglo

     * de lo contrario trae los resultados en objetos

     */

    /*public function get($id = NULL, $single = FALSE, $result_array = FALSE){
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $this->db->where($this->soft_delete_key, (bool)$this->_temporary_only_deleted);
        }
        if ($id != NULL) {
            $id = $this->security_id($id);
            $this->db->where($this->_primary_key, $id);
            $method = 'row';
        }
        elseif ($single == TRUE && $result_array == TRUE) {
        	$method =  'row_array';
        }
        elseif ($single == TRUE) {
            $method = 'row';
        }
        else {
            $method = 'result';
        }
        if (!empty($this->_order_by)) {
            $this->db->order_by($this->_order_by, $this->_direction);
        }

        return $this->db->get($this->_table_name)->$method();
    }
*/
 /// New Get
    public function get($primary_value)
    {
        return $this->get_by($this->_primary_key, $primary_value);
    }
	/**

	 * 

	 * @param array $where .  es para buscar datos.

	 * @param bool $single 

	 * @param bool $result_array

	 */

    /*public function get_by($where, $single = FALSE, $result_array = FALSE){

        

        $this->db->where($where);

        return $this->get(NULL, $single, $result_array);

        

    }*/

	#save  insert and update

	/**

	 * 

	 * @param array() $data

	 * @param string $id

	 * @return string

	 */

    public function save($data, $id = NULL){



        #set timestamp

        if ($this->_timestamps) {

            $data_format = config_item('log_date_format');

            $now = date($data_format);

            $id || $data['created'] = $now;

            $data['modified'] = $now;

        }
        if ($this->soft_delete_key) {
            $id || $data['deleted'] = 0;
        }


        #insert

        if ($id === NULL) {

            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;

            $this->db->set($data);

            $this->db->insert($this->_table_name);

            $id =  $this->db->insert_id();

        }

        #update

        else {

            $id =  $this->security_id($id);

            $this->db->set($data);

            $this->db->where($this->_primary_key, $id);

            $this->db->update($this->_table_name);

        }



        return $id;

    }



    public function delete($id){
        $id = $this->security_id($id);
        if (!$id) {
            return FALSE;
        }
        /*

        if ($this->_protect_id != '') {

        	if ($id == $this->_protect_id)

        		return FALSE;

        }
        */
        $this->db->where($this->_primary_key, $id);
        $this->db->limit(1);
        if ($this->soft_delete)
        {
             $this->db->update($this->_table_name, array( $this->soft_delete_key => TRUE ));
        }
        else
        {
             $this->db->delete($this->_table_name);
        }
        return TRUE;
    }





    #security filter id

    private function security_id($id = NULL){

        $filter = $this->_primary_filter;



        if ($id === NULL) {

            

            $security_id = $filter($this->_primary_key);



           

        }

        else {



            $security_id = $filter($id); 

        }

        

            

        return $security_id; 

    }



    public function get_new($field_value = array()){

        

    	$fields = $this->_table_fields_insert;

        $getData = new stdClass();

        foreach ($fields as $v) {

        	

        	if (!empty($field_value) && isset($field_value[$v])){

        		$getData->$v = $field_value[$v];

        	}

        	else{

        		$getData->$v = '';

        	} 

        }

        

        return $getData;



    }

    public function num_rows(){

    	return $this->db->get($this->_table_name)->num_rows();

    }


    public function list_fields(){

    	return $this->db->list_fields($this->_table_name);

    }


//NEW


    /**
     * Fetch an array of records based on an array of primary values.
     */
    public function get_many($values)
    {
        $this->db->where_in($this->_primary_key, $values);
        return $this->get_all();
    }
    /**
     * Fetch an array of records based on an arbitrary WHERE call.
     */
    public function get_many_by()
    {
        $where = func_get_args();

        $this->_set_where($where);
        return $this->get_all();
    }

    /* --------------------------------------------------------------
     * RELATIONSHIPS
     * ------------------------------------------------------------ */
    public function with($relationship)
    {
        $this->_with[] = $relationship;
        if (!in_array('relate', $this->after_get))
        {
            $this->after_get[] = 'relate';
        }
        return $this;
    }
    public function relate($row)
    {
        if (empty($row))
        {
            return $row;
        }
        foreach ($this->belongs_to as $key => $value)
        {
            if (is_string($value))
            {
                $relationship = $value;
                $options = array( '_primary_key' => $value . '_id', 'model' => $value . '_model' );
            }
            else

            {
                $relationship = $key;
                $options = $value;
            }
            if (in_array($relationship, $this->_with))
            {
                $this->load->model($options['model'], $relationship . '_model');
                if (is_object($row))
                {
                    $row->{$relationship} = $this->{$relationship . '_model'}->get($row->{$options['_primary_key']});
                }
                else
                {
                    $row[$relationship] = $this->{$relationship . '_model'}->get($row[$options['_primary_key']]);
                }
            }
        }
        foreach ($this->has_many as $key => $value)
        {
            if (is_string($value))
            {
                $relationship = $value;
                $options = array( '_primary_key' => singular($this->_table_name) . '_id', 'model' => singular($value) . '_model' );
            }
            else
            {
                $relationship = $key;
                $options = $value;
            }
            if (in_array($relationship, $this->_with))
            {
                $this->load->model($options['model'], $relationship . '_model');
                if (is_object($row))
                {
                    $row->{$relationship} = $this->{$relationship . '_model'}->get_many_by($options['_primary_key'], $row->{$this->_primary_key});
                }
                else
                {
                    $row[$relationship] = $this->{$relationship . '_model'}->get_many_by($options['_primary_key'], $row[$this->_primary_key]);
                }
            }
        }
        return $row;
    }


    public function trigger($event, $data = FALSE, $last = TRUE)
    {
        if (isset($this->$event) && is_array($this->$event))
        {
            foreach ($this->$event as $method)
            {
                if (strpos($method, '('))
                {
                    preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);
                    $method = $matches[1];
                    $this->callback_parameters = explode(',', $matches[3]);
                }
                $data = call_user_func_array(array($this, $method), array($data, $last));
            }
        }
        return $data;
    }
 
    public function get_by()
    {
        $where = func_get_args();
        /*
        if ( $this->soft_delete && $this->_temporary_with_deleted === FALSE)
        {
            $this->db->where($this->soft_delete_key, (bool)$this->_temporary_only_deleted);
        }
        */
        $this->_set_where($where);
        $this->trigger('before_get');
        $row = $this->db->get($this->_table_name)
            ->{$this->_return_type()}();
        $this->_temporary_return_type = $this->return_type;
        $row = $this->trigger('after_get', $row);
        $this->_with = array();
        return $row;
    }
    /**
     * Set WHERE parameters, cleverly
     */
    protected function _set_where($params)
    {
        if (count($params) == 1 && is_array($params[0]))
        {
            foreach ($params[0] as $field => $filter)
            {
                if (is_array($filter))
                {
                    $this->db->where_in($field, $filter);
                }
                else
                {
                    if (is_int($field))
                    {
                        $this->db->where($filter);
                    }
                    else
                    {
                        $this->db->where($field, $filter);
                    }
                }
            }
        }
        else if (count($params) == 1)
        {
            $this->db->where($params[0]);
        }
        else if(count($params) == 2)
        {
            if (is_array($params[1]))
            {
                $this->db->where_in($params[0], $params[1]);
            }
            else
            {
                $this->db->where($params[0], $params[1]);
            }
        }
        else if(count($params) == 3)
        {
            $this->db->where($params[0], $params[1], $params[2]);
        }
        else
        {
            if (is_array($params[1]))
            {
                $this->db->where_in($params[0], $params[1]);
            }
            else
            {
                $this->db->where($params[0], $params[1]);
            }
        }
    }
    /**
     * Return the method name for the current return type
     */
    protected function _return_type($multi = FALSE)
    {
        $method = ($multi) ? 'result' : 'row';
        return $this->_temporary_return_type == 'array' ? $method . '_array' : $method;
    }

    public function get_all()
    {
        $this->trigger('before_get');
        /*
        if ( $this->soft_delete && $this->_temporary_with_deleted === FALSE)
        {
            $this->db->where($this->soft_delete_key, (bool)$this->_temporary_only_deleted);
        }
        */
        $result = $this->db->get($this->_table_name)
            ->{$this->_return_type(1)}();
        $this->_temporary_return_type = $this->return_type;
        foreach ($result as $key => &$row)
        {
            $row = $this->trigger('after_get', $row, ($key == count($result) - 1));
        }
        $this->_with = array();
        return $result;
    }
    /**
     * Protect attributes by removing them from $row array
     */
    public function protect_attributes($row)
    {
        foreach ($this->protected_attributes as $attr)
        {
            if (is_object($row))
            {
                unset($row->$attr);
            }
            else
            {
                unset($row[$attr]);
            }
        }
        return $row;
    }
}