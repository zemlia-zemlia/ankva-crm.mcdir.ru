<?php

namespace app\models;

class ObjectLogType
{
    const LOG_TYPE_STRING = 1;
    const LOG_TYPE_NUMBER = 2;
    const LOG_TYPE_DATE = 3;
    const LOG_TYPE_EMPTY = 4;
    const LOG_CATEGORY_OPERATION = 5;
    const LOG_CATEGORY_MODIFICATION = 6;
    const LOG_CATEGORY_CREATE = 7;
}