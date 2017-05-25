<?php
/* render the layouts of template files */
    require_once realpath(dirname(__FILE__).'/../config.php');

    $page_title;

    function render_layout_with_layout_file($content_file, $variable = array())
    {
        $content_file_full_path = TEMPLATES_PATH.'/'.$content_file;

        // make sure passed in variables are in scope of the template
        // each key in the $variables array will become a variable
        if (count($variable) > 0)
        {
            foreach ($variable as $key => $value) {
                if (strlen($key) > 0)
                {
                    ${$key} = $value;
                }
            }
        }

        require_once TEMPLATES_PATH.'/header.php';

        echo '<div id=\'content\'>\n'
           .'\t<div class=\'container\'>\n';

       if (file_exists($content_file_full_path))
       {
           require_once $content_file_full_path;
       }

       else
       {
           /* if the file is not found a web application can handle this in various ways
           in this case an error page will be displayed */
           require_once TEMPLATES_PATH.'/error.php';
       }

       // close container div
       echo '\t</div>\n';

       // close content div
       echo '</div>\n';

       require_once TEMPLATES_PATH.'/footer.php';

    }
