<?php

abstract class Page
{
    const ACTION = "action";
    const ADD_NEW = "addNew";
    const EDIT = "edit";
    const EDIT_VIEW = "editView";
    const CREATE_VIEW = "createView";
    const DELETE = "delete";

    private string $title;
    private string $tableName;

    public function __construct()
    {
        $this->title = $this->passTitle();
        $this->tableName = $this->passTableName();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTableName() : string
    {
        return $this->tableName;
    }

    protected abstract function passTitle(): string;
    protected abstract function passTableName(): string;

    protected abstract function enterModelDataFromForm(): void;
    protected abstract function generateViewAll(): string;
    protected abstract function generateViewEdit(): string;
    protected abstract function generateViewAdd(): string;
    protected abstract function edit(): void;
    protected abstract function addNew(): void;

    protected function generateHead(): string
    {
        return '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>' . $this->getTitle() . '</title>

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body>
            ';
                }

                protected function generateHeader(): string
                {
                    return '
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>' . $this->getTitle() . '</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST">
                            <button name="' . self::ACTION . '" value="' . self::CREATE_VIEW . '" class="btn btn-primary">Create new</button>
                            <button name="' . self::ACTION . '" value="" class="btn btn-primary">All</button>
                        </form>
                    </div>
                </div>

                <hr />
            ';
                }

                protected function generateFooter(): string
                {
                    return '
            </div>

            <script src="js/bootstrap.min.js"></script>
            </body>
            </html>
            ';
    }

    public static function openConnection(): ?PDO
    {
        try {
            return new PDO("mysql:host=localhost;dbname=phpadvanced", "root");
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    protected function delete(): void
    {
        if (!isset($_POST["Id"])) {
            return;
        }

        $query = "UPDATE " . $this->getTableName() . " SET IsActive = 0 WHERE Id = :Id";

        $connection = self::openConnection();

        if ($connection == null) {
            return;
        }

        $query = $connection->prepare($query);
        $query->bindValue(":Id", $_POST["Id"], PDO::PARAM_INT);
        $query->execute();
    }

    public function initialize(): void
    {
        //echo print_r($_POST);
        echo $this->generateHead();
        echo $this->generateHeader();

        switch ($_POST[self::ACTION] ?? "") {
            case self::CREATE_VIEW:
                echo $this->generateViewAdd();
                break;

            case self::EDIT_VIEW:
                echo $this->generateViewEdit();
                break;

            case self::EDIT:
                $this->enterModelDataFromForm();
                $this->edit();
                echo $this->generateViewAll();
                break;

            case self::ADD_NEW:
                $this->enterModelDataFromForm();
                $this->addNew();
                echo $this->generateViewAll();
                break;

            case self::DELETE:
                $this->delete();
                echo $this->generateViewAll();
                break;

            default:
                echo $this->generateViewAll();
                break;
        }

        echo $this->generateFooter();
    }
}
