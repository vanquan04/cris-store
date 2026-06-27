<?php
function getFieldbyID($model, $field, $id)
{
    $result = $model::select($field)
        ->where('id', $id)
        ->first();

    if ($result) {
        return $result->$field;
    }

    return null;
}
