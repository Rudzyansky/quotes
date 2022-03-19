<?php

use Config\AccessLevel;
use Database\QuoteInfo;
use Helper\Access;

Access::logged();
Access::requireLevelGreaterEquals(AccessLevel::MODERATOR);
QuoteInfo::resetAutoIncrement();
