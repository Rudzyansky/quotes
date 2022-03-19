<?php

use Helper\Access;
use Helper\Page;

Access::unLogged();

Page::printDefaultWoLoader("Sign up", [
    'right' => '<a id="login">login</a>'
]);
