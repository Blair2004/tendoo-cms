<?php
function insertBeforeKey($array, $key, $data = null)
{
    if (($offset = array_search($key, array_keys($array))) === false) // if the key doesn't exist
    {
        $offset = 0; // should we prepend $array with $data?
        $offset = count($array); // or should we append $array with $data? lets pick this one...
    }

    return array_merge(array_slice($array, 0, $offset), (array) $data, array_slice($array, $offset));
}