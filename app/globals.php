<?php

function encodeId($id): string
{

    return base64_encode($id);
}

function decodeId($id): int
{
    return base64_decode($id);
}
