<?php
namespace user;

use json\json_output;
use json\json_format;

class user_class implements json_format
{
    public $id;
    public $year;
    public $grade;
    public $class_no;
    
    function __construct($id ,$year ,$grade ,$class_no)
    {
        $this->id = $id;
        $this->year = $year;
        $this->grade = $grade;
        $this->class_no = $class_no;
    }
    
    public function get_json()
    {
        $data = 
            '{"id":"' . json_output::filter($this->id) . 
            '","year":"' . json_output::filter($this->year) .
            '","grade":"' . json_output::filter($this->grade) .
            '","class_no":"' . json_output::filter($this->class_no) . '"}';

        return $data;
    }
}

?>