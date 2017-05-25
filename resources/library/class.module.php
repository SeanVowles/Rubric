<?php

    class Module
    {
        // local variable
        private $db;

        public function __construct($conn)
        {
            $this->db = $conn;
        }

        // add row to module table
        public function add_module($value='')
        {
            # code...
        }

        public function edit_module($value='')
        {
            # code...
        }

        public function delete_module($value='')
        {
            # code...
        }

        public function get_columns($value='')
        {
            # code...
        }

        public function get_table_contents($value='')
        {
            # code...
        }

    }
 ?>
