<?php

namespace Francysk\Framework\Decorator;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

class File
{
    private $uploadDir;

    public function __construct()
    {
        $this->uploadDir = \COption::GetOptionString("main", "upload_dir", "upload");
    }

    public function decorateElement(array $row): array
    {
        $row["SRC"] = sprintf("/%s/%s/%s", $this->uploadDir, $row["SUBDIR"], $row["FILE_NAME"]);
        return $row;
    }
}
