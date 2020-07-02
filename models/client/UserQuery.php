<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 13.10.19
 * Time: 0:22
 */

namespace app\models\client;


class UserQuery {
    public $type;

    public function prepare($builder)
    {
        if ($this->type !== null) {
            $this->andWhere(['type' => $this->type]);
        }
        return parent::prepare($builder);
    }


}