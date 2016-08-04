<?php
require_once "singleton.class.php";

class woodb
{
    protected $opt = array(
        'op'        => '',
        'op_param'  => '',
        'from'      => 'FROM',
        'table'     => '',
        'where'     => '',
        'joins'     => '',
        'order'     => '',
        'groups'    => '',
        'having'    => '',
        'distinct'  => '',
        'limit'     => '',
        'offset'    => '',
    );
    protected $sql = '';

    protected $dbconf = array(
        'db'        => '',
        'db_type'   => '',
    );

    public function __construct() {}

    public function reset()
    {
        foreach($this->opt as $k) 
        {
            $this->opt[$k] = "";
        }
    }

    public function limit($limit, $offset = null)
    {
        if($limit !== null)
        {
            $this->opt['limit'] = 'LIMIT ' . $limit;
        }
        
        if($offset !== null) {
            $this->offset($offset);
        }

        return $this;
    }

    public function offset($offset, $limit = null) 
    {
        if($offset !== null) {
            $this->opt['offset'] = 'OFFSET ' . $$offset;
        }

        if($limit !== null) {
            $this->limit($limit);
        }

        return $this;
    }

    public function from($table, $reset = true)
    {
        if($reset)
        {
            $this->reset();
        }

        $this->opt['table'] = $table;
    }

    public function build_sql($sql, $input)
    {
        return strlen($input) > 0 ? ($sql . ' ' . $input) : $sql;
    }

    public function mock_sql($sql = null)
    {
        if(empty($this->opt['table']))
            throw new exception("table isnot specified yet!");

        $join = '';
        foreach($this->opt as $k => $v)
        {
            if(trim($k) === '' or trim($v) === null) continue;
            echo $k . " : " . $v ."\n";
            $join .= ' ' . $v;
        }
        //echo "JOIN: " .$join . "\n";
        $this->sql = $join;
        //$this->sql = trim(array_reduce($this->opt, array($this, 'build_sql')));
        return $this->sql;
    }

    public function parse_cond($field, $value, $join = '', $escapse = true)
    {
        if(is_string($field))
        {
            if($value == null) return $join . trim($field);

            //
        } else {
            throw new exception("unknown condition.");
        }
    }

    public function where($field, $value = null)
    {
        $join = empty($this->opt['where']) ? 'WHERE ' : '';
        $this->opt['where'] .= $this->parse_cond($field, $value, $join);
        return $this;
    }

    //public function select($fields = '*', $limit = null, $offset = null)
    public function select($fields = '*', $limit = null, $offset = null)
    {
        if(!$this->opt['table'])
        {
            throw new Exception('Table is not specified!');
        }

        $this->opt['op'] = 'SELECT';
        $this->opt['op_param'] = $fields;

        $fields = is_array($fields) ? implode(',', $fields) : $fields;
        $this->limit($limit, $offset);
        /*
        $this->mock_sql(array(
            "SELECT",
            $this->opt['distinct'],
            $fields,
            'FROM',
            $this->opt['table'],
            $this->opt['joins'],
            $this->opt['where'],
            $this->opt['groups'],
            $this->opt['having'],
            $this->opt['order'],
            $this->opt['limit'],
            $this->opt['offset']
        ));
        */
        //$this->mock_sql($this->opt);
        return $this;
    }
}

final class DBHandler extends Singleton
{
    private $handle;

    function init($host, $port, $username, $password, $dbname) 
    {
        $this->handle = new mysqli($host, $username, $password, $dbname, $port) 
                            or die("fail to connect mysql.");
    }

    function query($sql)
    {
        return $this->handle->query($sql);
    }

    function finish() {}
}
/*
$db = DBHandler::instance()->init("127.0.0.1", "3306", "root", "", "teamtalk");
var_dump($db);

$sql = "show tables";
$r = $db->query($sql);
var_dump($r);
*/

//var_dump($db ->query($sql));
/*
for($i = 0; $i < mysql_num_fields($result); $i++)
{
    echo  mysql_field_name($result, $i) . "\n";
}
*/

$db_config = array(
    "host" => "127.0.0.1", 
    "port" => "3306", 
    "username" => "test", 
    "password" => "123456"
);

//db
$db = new woodb();
$db->from('user');
$db->select('id, name, passwd');
$db->where('id = 900');
echo $db->mock_sql();

?>

