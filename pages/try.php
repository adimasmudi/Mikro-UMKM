<?php

echo "
if (window.confirm('Really go to another page?'))
{
    alert('message');
    window.location = 'login.php';
}
else
{
    die();
}
";


?>