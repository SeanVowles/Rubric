<?php
    class Table_Rows extends RecursiveIteratorIterator
    {
        public function __construct($it)
        {
            parent::__construct($it, self::LEAVES_ONLY);
        }

        public function current()
        {
            return '<td>'.parent::current().'</td>';
        }

        public function begin_chilren()
        {
            echo '<tr>';
        }

        public function end_children()
        {
            echo '</tr>'.'\n';
        }
    }
?>
