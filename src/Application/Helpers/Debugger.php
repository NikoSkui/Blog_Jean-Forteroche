<?php

function v($nom)
{

global $$nom;
echo '$'.$nom.' = ';var_dump($$nom); echo'<br />';
}