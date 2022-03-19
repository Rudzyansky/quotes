<?php

use Config\AccessLevel;
use Helper\Access;

Access::logged();
Access::requireLevelGreaterEquals(AccessLevel::GUEST);

session_unset();
