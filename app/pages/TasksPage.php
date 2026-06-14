<?php

include_once("Page.php");
include_once(__DIR__ . "/../Models/Task.php");
include_once(app_path("models/InternalEvent.php"));

class TasksPage extends Page
{
    private Task $model;

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
        return "Tasks";
    }

    protected function passTableName(): string
    {
        return "Tasks";
    }

    protected function enterModelDataFromForm(): void
    {
        $this->setModel(new Task(
            intval($_POST["Id"] ?? "0"),
            $_POST["Title"] ?? "null",
            boolval($_POST["IsDone"] ?? "0"),
            $_POST["StartDateTime"] ?? "null",
            $_POST["Description"] ?? "null",
            $_POST["Deadline"] ?? "null",
            intval($_POST["InternalEventId"] ?? "0"),
            $_POST["Notes"] ?? "null",
            boolval($_POST["IsActive"] ?? "0")
        ));
    }

    protected function edit(): void
    {
        $query = "UPDATE " . $this->getTableName() . "
        SET
            Title = :Title,
            IsDone = :IsDone,
            StartDateTime = :StartDateTime,
            Description = :Description,
            Deadline = :Deadline,
            InternalEventId = :InternalEventId,
            Notes = :Notes,
            EditDateTime = CURDATE()
        WHERE Id = :Id";

        $query = self::openConnection()->prepare($query);

        $query->bindValue(":Title", $this->getModel()->getTitle());
        $query->bindValue(":IsDone", $this->getModel()->getIsDone());
        $query->bindValue(":StartDateTime", $this->getModel()->getStartDateTime());
        $query->bindValue(":Description", $this->getModel()->getDescription());
        $query->bindValue(":Deadline", $this->getModel()->getDeadline());
        $query->bindValue(":InternalEventId", $this->getModel()->getInternalEventId(), PDO::PARAM_INT);
        $query->bindValue(":Notes", $this->getModel()->getNotes());
        $query->bindValue(":Id", $this->getModel()->getId(), PDO::PARAM_INT);

        $query->execute();
    }

    protected function addNew(): void
    {
        $query = "INSERT INTO " . $this->getTableName() . "
        (
            Title, IsDone, StartDateTime, Description,
            Deadline, InternalEventId, CreationDateTime,
            EditDateTime, Notes, IsActive
        )
        VALUES
        (
            :Title, :IsDone, :StartDateTime, :Description,
            :Deadline, :InternalEventId, CURDATE(),
            CURDATE(), :Notes, 1
        )";

        $query = self::openConnection()->prepare($query);

        $query->bindValue(":Title", $this->getModel()->getTitle());
        $query->bindValue(":IsDone", $this->getModel()->getIsDone());
        $query->bindValue(":StartDateTime", $this->getModel()->getStartDateTime());
        $query->bindValue(":Description", $this->getModel()->getDescription());
        $query->bindValue(":Deadline", $this->getModel()->getDeadline());
        $query->bindValue(":InternalEventId", $this->getModel()->getInternalEventId(), PDO::PARAM_INT);
        $query->bindValue(":Notes", $this->getModel()->getNotes());

        $query->execute();
    }

    protected function generateViewAdd(): string
    {
        $events = self::openConnection()->query("SELECT * FROM InternalEvents WHERE IsActive = 1");

        $options = "";
        foreach ($events as $event) {
            $options .= '<option value="' . $event["Id"] . '">' . $event["Title"] . '</option>';
        }

        return '<div class="container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Create task</h4>
            </div>

            <div class="card-body">
                <form method="POST">
                    <div class="row gy-3">

                        <div class="col-md-12">
                            <label class="form-label">Title</label>
                            <input name="Title" class="form-control" maxlength="64" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Start date</label>
                            <input name="StartDateTime" class="form-control" type="date" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Deadline</label>
                            <input name="Deadline" class="form-control" type="date" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Internal event</label>
                            <select name="InternalEventId" class="form-select" required>
                                ' . $options . '
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="Description" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Notes</label>
                            <textarea name="Notes" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input name="IsDone" class="form-check-input" type="checkbox" id="IsDone">
                                <label class="form-check-label" for="IsDone">Task is done</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button name="' . self::ACTION . '" value="' . self::ADD_NEW . '" class="btn btn-primary">
                                Create
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>';
    }

    protected function generateViewEdit(): string
{
    $query = self::openConnection()->prepare("SELECT * FROM " . $this->getTableName() . " WHERE Id = :Id");
    $query->bindValue(":Id", $_POST["Id"], PDO::PARAM_INT);
    $query->execute();
    $model = $query->fetch();

    $events = self::openConnection()->query("SELECT * FROM InternalEvents WHERE IsActive = 1");

    $options = "";
    foreach ($events as $event) {
        $selected = $event["Id"] == $model["InternalEventId"] ? "selected" : "";
        $options .= '<option value="' . $event["Id"] . '" ' . $selected . '>' . $event["Title"] . '</option>';
    }

    $output = '<div class="container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Edit task</h4>
            </div>

            <div class="card-body">
                <form method="POST">
                    <input hidden name="Id" value="' . $model["Id"] . '">

                    <div class="row gy-3">

                        <div class="col-md-12">
                            <label class="form-label">Title</label>
                            <input name="Title" value="' . $model["Title"] . '" class="form-control" maxlength="64" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Start date</label>
                            <input name="StartDateTime" value="' . date("Y-m-d", strtotime($model["StartDateTime"])) . '" class="form-control" type="date" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Deadline</label>
                            <input name="Deadline" value="' . date("Y-m-d", strtotime($model["Deadline"])) . '" class="form-control" type="date" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Internal event</label>
                            <select name="InternalEventId" class="form-select" required>
                                ' . $options . '
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="Description" class="form-control" rows="4" required>' . $model["Description"] . '</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Notes</label>
                            <textarea name="Notes" class="form-control" rows="3">' . $model["Notes"] . '</textarea>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input name="IsDone" ' . ($model["IsDone"] ? "checked" : "") . ' class="form-check-input" type="checkbox" id="IsDone">
                                <label class="form-check-label" for="IsDone">Task is done</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button name="' . self::ACTION . '" value="' . self::EDIT . '" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>';

    return $output;
}

    protected function generateViewAll(): string
    {
        $query = self::openConnection()->query("
            SELECT 
                Tasks.*,
                InternalEvents.Title AS InternalEventTitle
            FROM Tasks
            INNER JOIN InternalEvents ON Tasks.InternalEventId = InternalEvents.Id
            WHERE Tasks.IsActive = 1
        ");

        $output = '<div class="container">
    <div class="row gy-3">';

        foreach ($query as $model) {
            $output .= '<div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <p class="card-title h5">' . $model["Title"] . '</p>
                <p><strong>Internal event: </strong>' . $model["InternalEventTitle"] . '</p>
                <p><strong>Description: </strong>' . $model["Description"] . '</p>
                <p><strong>Deadline: </strong>' . $model["Deadline"] . '</p>
                <p><strong>Done: </strong>' . ($model["IsDone"] ? "Yes" : "No") . '</p>
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