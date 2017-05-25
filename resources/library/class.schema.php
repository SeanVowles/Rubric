<?php
    class Schema
    {
        // global variables of the schema
        public $status = "OK";
        public $message;
        public $table;
        public $row;
        public $rows_in_table;
        public $columns_in_table;
        public $data;

        private function set_response($data)
        {
            $reflection = new ReflectionClass(get_class($this));
            if(is_array($data)){
                foreach($data as $key => $value){
                    foreach($reflection->getProperties() as $property) {
                        if($property->name == $key){
                            $this->$key = $value;
                        }
                    }
                }
            }
        }

        public function get_response($data)
        {
            $this->set_response($data);
            $json = array();
            // reflection reports information about a class
            $reflection = new ReflectionClass(get_class($this));

            foreach($reflection->getProperties() as $property){
                $name = $property->name;
                if($this->$name != NULL || is_int($this->$name)) {
                    $json[$name] = $this->$name;
                }
            }

            return "\n" . json_encode($json,JSON_PRETTY_PRINT);
        }
    }
 ?>
