<?php
include "../connection.php";
include "../models/Event.php";


class EventController
{
  public $conn;

  // constructor
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  // Create
  public function create(Event $event)
  {

    $query = "INSERT INTO eventi (attendees, nome_evento, data_evento) VALUES (?, ?, ?)";

    $stmt = $this->conn->prepare($query);

    $stmt->bind_param('sss', $event->attendees, $event->name_event, $event->date_event);

    if ($stmt->execute()) {
      return true;
    } else {
      print_r($stmt->errorInfo());
      return false;
    }
  }

  // Show
  public function show($id)
  {
    $query = "SELECT * FROM eventi WHERE id=?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }


  // Update
  public function edit($id, Event $event)
  {
    $query = "UPDATE eventi SET attendees=?, nome_evento=?, data_evento=? WHERE id=?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('sssi', $event->attendees, $event->name_event, $event->date_event, $id);
    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Delete
  public function delete($id)
  {
    $query = "DELETE FROM eventi WHERE id= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}
