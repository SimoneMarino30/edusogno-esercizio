<?php

class Event
{
  public $attendees;
  public $name_event;
  public $date_event;


  function __construct($attendees, $name_event, $date_event)
  {
    $this->attendees = $attendees;
    $this->name_event = $name_event;
    $this->date_event = $date_event;
  }

  // GETTERS&SETTERS
  public function getAttendees()
  {
    return $this->attendees;
  }

  public function getNAmeEvent()
  {
    return $this->name_event;
  }


  public function getDataEvent()
  {
    return $this->date_event;
  }
}
