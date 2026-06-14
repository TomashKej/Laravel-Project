<?php

include_once("Page.php");
include_once("../Models/InternalEvent.php");

class InternalEventsPage extends Page
{
    private InternalEvent $model;

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    protected function passTitle(): string
    {
        return "Internal events";
    }

    protected function passTableName(): string
    {
        return "InternalEvents";
    }

    protected function enterModelDataFromForm(): void
    {
        $this->setModel(new InternalEvent(
            intval($_POST["Id"] ?? "0"),
            $_POST["Title"] ?? "null",
            $_POST["Link"] ?? "null",
            boolval($_POST["IsPublic"] ?? "0"),
            boolval($_POST["IsCancelled"] ?? "0"),
            $_POST["EventDateTime"] ?? "null",
            $_POST["PublishDateTime"] ?? "null",
            $_POST["ShortDescription"] ?? "null",
            $_POST["ContentHTML"] ?? "null",
            $_POST["MetaDescription"] ?? "null",
            $_POST["MetaTags"] ?? "null",
            $_POST["Notes"] ?? "null",
            boolval($_POST["IsActive"] ?? "0")
        ));
    }

    protected function edit(): void
    {
        $query = "UPDATE " . $this->getTableName() . "
        SET
            Title = :Title,
            Link = :Link,
            IsPublic = :IsPublic,
            IsCancelled = :IsCancelled,
            ShortDescription = :ShortDescription,
            ContentHTML = :ContentHTML,
            PublishDateTime = :PublishDateTime,
            EventDateTime = :EventDateTime,
            MetaDescription = :MetaDescription,
            MetaTags = :MetaTags,
            Notes = :Notes,
            EditDateTime = CURDATE()
        WHERE Id = :Id";

        $query = self::openConnection()->prepare($query);

        $query->bindValue(":Title", $this->getModel()->getTitle());
        $query->bindValue(":Link", $this->getModel()->getLink());
        $query->bindValue(":IsPublic", $this->getModel()->getIsPublic());
        $query->bindValue(":IsCancelled", $this->getModel()->getIsCancelled());
        $query->bindValue(":ShortDescription", $this->getModel()->getShortDescription());
        $query->bindValue(":ContentHTML", $this->getModel()->getContentHTML());
        $query->bindValue(":PublishDateTime", $this->getModel()->getPublishDateTime());
        $query->bindValue(":EventDateTime", $this->getModel()->getEventDateTime());
        $query->bindValue(":MetaDescription", $this->getModel()->getMetaDescription());
        $query->bindValue(":MetaTags", $this->getModel()->getMetaTags());
        $query->bindValue(":Notes", $this->getModel()->getNotes());
        $query->bindValue(":Id", $this->getModel()->getId(), PDO::PARAM_INT);

        $query->execute();
    }

    protected function addNew(): void
    {
        $query = "INSERT INTO " . $this->getTableName() . "
        (
            Title, Link, IsPublic, IsCancelled,
            EditDateTime, PublishDateTime, EventDateTime,
            CreationDateTime, ShortDescription, ContentHTML,
            MetaTags, MetaDescription, Notes, IsActive
        )
        VALUES
        (
            :Title, :Link, :IsPublic, :IsCancelled,
            CURDATE(), :PublishDateTime, :EventDateTime,
            CURDATE(), :ShortDescription, :ContentHTML,
            :MetaTags, :MetaDescription, :Notes, 1
        )";

        $query = self::openConnection()->prepare($query);

        $query->bindValue(":Title", $this->getModel()->getTitle());
        $query->bindValue(":Link", $this->getModel()->getLink());
        $query->bindValue(":IsPublic", $this->getModel()->getIsPublic());
        $query->bindValue(":IsCancelled", $this->getModel()->getIsCancelled());
        $query->bindValue(":PublishDateTime", $this->getModel()->getPublishDateTime());
        $query->bindValue(":EventDateTime", $this->getModel()->getEventDateTime());
        $query->bindValue(":ShortDescription", $this->getModel()->getShortDescription());
        $query->bindValue(":ContentHTML", $this->getModel()->getContentHTML());
        $query->bindValue(":MetaTags", $this->getModel()->getMetaTags());
        $query->bindValue(":MetaDescription", $this->getModel()->getMetaDescription());
        $query->bindValue(":Notes", $this->getModel()->getNotes());

        $query->execute();
    }

    protected function generateViewAdd(): string
    {
        return '<div class="container">
    <form method="POST">
        <div class="row gy-3">
            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">label</i>
                        Title
                    </label>
                    <input name="Title" class="form-control validate">
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">link</i>
                        Link
                    </label>
                    <input name="Link" class="form-control validate">
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="row">
                    <div class="col-auto">
                        <label class="form-check-label">
                            <i class="material-icons-round align-middle">public</i>
                            Public
                        </label>
                    </div>
                    <div class="form-switch form-check col-auto">
                        <input name="IsPublic" class="form-check-input validate" type="checkbox">
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="row">
                    <div class="col-auto">
                        <label class="form-check-label">
                            <i class="material-icons-round align-middle">cancel</i>
                            Cancelled
                        </label>
                    </div>
                    <div class="form-switch form-check col-auto">
                        <input name="IsCancelled" class="form-check-input validate" type="checkbox">
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">event</i>
                        Event date
                    </label>
                    <input name="EventDateTime" class="form-control validate" type="date">
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">today</i>
                        Publish date
                    </label>
                    <input name="PublishDateTime" class="form-control validate" type="date">
                </div>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">description</i>
                    Short description
                </label>
                <textarea name="ShortDescription" class="form-control validate"></textarea>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">newspaper</i>
                    Content
                </label>
                <textarea name="ContentHTML" class="form-control validate"></textarea>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">feed</i>
                    Meta description
                </label>
                <textarea name="MetaDescription" class="form-control validate"></textarea>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">subtitles</i>
                    Meta tags
                </label>
                <textarea name="MetaTags" class="form-control validate"></textarea>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">notes</i>
                    Notes
                </label>
                <textarea name="Notes" class="form-control validate"></textarea>
            </div>

            <div class="col-sm-12">
                <button name="' . self::ACTION . '" value="' . self::ADD_NEW . '" class="btn btn-primary">Create</button>
            </div>
        </div>
    </form>
</div>';
    }

    protected function generateViewEdit(): string
    {
        $query = self::openConnection()->prepare("SELECT * FROM " . $this->getTableName() . " WHERE Id = :Id");
        $query->bindValue(":Id", $_POST["Id"], PDO::PARAM_INT);
        $query->execute();
        $model = $query->fetch();

        $output = '<div class="container">
    <form method="POST">
        <div class="row gy-3">
            <input hidden name="Id" value="' . $model["Id"] . '">

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">label</i>
                        Title
                    </label>
                    <input name="Title" value="' . $model["Title"] . '" class="form-control validate">
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">link</i>
                        Link
                    </label>
                    <input name="Link" value="' . $model["Link"] . '" class="form-control validate">
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="row">
                    <div class="col-auto">
                        <label class="form-check-label">
                            <i class="material-icons-round align-middle">public</i>
                            Public
                        </label>
                    </div>
                    <div class="form-switch form-check col-auto">
                        <input name="IsPublic" ' . ($model["IsPublic"] ? "checked" : "") . ' class="form-check-input validate" type="checkbox">
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="row">
                    <div class="col-auto">
                        <label class="form-check-label">
                            <i class="material-icons-round align-middle">cancel</i>
                            Cancelled
                        </label>
                    </div>
                    <div class="form-switch form-check col-auto">
                        <input name="IsCancelled" ' . ($model["IsCancelled"] ? "checked" : "") . ' class="form-check-input validate" type="checkbox">
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">event</i>
                        Event date
                    </label>
                    <input name="EventDateTime" value="' . date("Y-m-d", strtotime($model["EventDateTime"])) . '" class="form-control validate" type="date">
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">today</i>
                        Publish date
                    </label>
                    <input name="PublishDateTime" value="' . date("Y-m-d", strtotime($model["PublishDateTime"])) . '" class="form-control validate" type="date">
                </div>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">description</i>
                    Short description
                </label>
                <textarea name="ShortDescription" class="form-control validate">' . $model["ShortDescription"] . '</textarea>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">newspaper</i>
                    Content
                </label>
                <textarea name="ContentHTML" class="form-control validate">' . $model["ContentHTML"] . '</textarea>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">feed</i>
                    Meta description
                </label>
                <textarea name="MetaDescription" class="form-control validate">' . $model["MetaDescription"] . '</textarea>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">subtitles</i>
                    Meta tags
                </label>
                <textarea name="MetaTags" class="form-control validate">' . $model["MetaTags"] . '</textarea>
            </div>

            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">notes</i>
                    Notes
                </label>
                <textarea name="Notes" class="form-control validate">' . $model["Notes"] . '</textarea>
            </div>

            <div class="col-sm-12">
                <button name="' . self::ACTION . '" value="' . self::EDIT . '" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </form>
</div>';

        return $output;
    }

    protected function generateViewAll(): string
    {
        $query = self::openConnection()->query("SELECT * FROM " . $this->getTableName() . " WHERE IsActive = 1");

        $output = '<div class="container">
    <div class="row gy-3">';

        foreach ($query as $model) {
            $output .= '<div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <p class="card-title h5">' . $model["Title"] . '</p>
                <p><strong>' . $model["ShortDescription"] . '</strong></p>
                ' . $model["ContentHTML"] . '
            </div>
            <div class="card-footer">
                <form method="POST">
                    <input hidden name="Id" value="' . $model["Id"] . '">
                    <button name="' . self::ACTION . '" value="' . self::EDIT_VIEW . '" class="btn btn-primary">Edit</button>
                    <button name="' . self::ACTION . '" value="' . self::DELETE . '" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>';
        }

        $output .= '</div>
</div>';

        return $output;
    }
}