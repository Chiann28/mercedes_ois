<?php

require_once __DIR__ . "/../../framework/SQLCommands.php";
require_once "NewApplicationClass.php";


class EventsClass
{
  private $NewApplicationClass;

  public function __construct()
  {
    $this->NewApplicationClass = new NewApplicationClass();
  }

  public function GenerateEventNumber($client)
  {
    $SQL = new SQLCommands("mercedes_ois");

    do {
      $event_no = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

      $query = "SELECT event_no FROM events WHERE client = '$client' AND event_no = '$event_no' LIMIT 1";

      $exists = $SQL->SelectQuery($query);

    } while (!empty($exists));

    return $event_no;
  }


  public function DoPostEvent($user, $client, $params)
  {
    $SQL = new SQLCommands("mercedes_ois");

    $requiredFields = [
      "event_type",
      "event_name",
      "event_description",
      "start_date",
      "end_date",
      "location",
    ];

    $validated = $this->NewApplicationClass->validateRequiredFields($params, $requiredFields);


    if ($validated == false) {
      return [
        "result" => false,
        "message" => "Missing required fields",
      ];
    } else {

      $event_no = $this->GenerateEventNumber($client);
      $event_type = strtoupper($validated["event_type"]);
      $event_name = $validated["event_name"];
      $event_description = $validated["event_description"];
      $start_date = $validated["start_date"];
      $end_date = $validated["end_date"];
      $location = $validated["location"];


      $parameters = [
        'client' => $client,
        'event_no' => $event_no,
        'event_type' => $event_type,
        'event_name' => $event_name,
        'event_description' => $event_description,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'location' => $location,
        'initiated_by' => $user,
        'modifiedby' => $user
      ];
      $result = $SQL->InsertQuery('events', $parameters);
      if (!$result) {
        return ["result" => false, "message" => "Failed Posting Event",];
      } else {
        return ["result" => true, "message" => "Nice! Event Posted",];
      }

    }


  }

  public function DoUpdateEvent($params, $user)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $client = $params['client'];
    $event_no = $params['event_no'];
    $event_type = $params['event_type'];
    $event_name = $params['event_name'];
    $event_description = $params['event_description'];
    $start_date = $params['start_date'];
    $end_date = $params['end_date'];
    $location = $params['location'];

    $query = "UPDATE events 
    SET event_type = '$event_type', 
        event_name = '$event_name', 
        event_description = '$event_description',
        location = '$location',
        start_date = '$start_date',
        end_date = '$end_date',
        modifiedby = '$user'

      WHERE client = '$client' AND event_no = '$event_no' 
    ";
    $result = $SQL->UpdateQuery($query);
    if (!$result) {
      return ["result" => false, "message" => "Something Went Wrong. Event Update Failed.",];
    } else {
      return ["result" => true, "message" => "Event : $event_no Updated Successfuly",];
    }


  }

  public function DoDeleteEvent($client, $event_no)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $date = date('Y-m-d');

    $query = "UPDATE events 
    SET event_status = 'DELETED' 
    WHERE client = '$client' 
    AND event_no = '$event_no'
    ";
    $result = $SQL->UpdateQuery($query);


    if (!$result) {
      return ["result" => false, "message" => "Something Went Wrong",];
    } else {
      return ["result" => true, "message" => "Deleted Event No : " . $event_no,];
    }


  }

  public function DoCountEvents($client)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $date = date('Y-m-d');

    $query = "SELECT count(event_no)
     FROM events WHERE client = '$client'
    AND `start_date` >= '$date'
    AND event_status <> 'DELETED'
    ORDER BY start_date;
    ";
    $result = $SQL->SelectQuery($query);

    return $result;

  }

  public function DoCountPastEvents($client)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $date = date('Y-m-d');

    $query = "SELECT count(event_no)
     FROM events WHERE client = '$client'
    AND `start_date` < '$date'
    ORDER BY start_date;
    ";
    $result = $SQL->SelectQuery($query);

    return $result;

  }

  public function GetEvents($client)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $date = date('Y-m-d');

    $query = "SELECT *,
    DATE(start_date) AS date_start,
    DATE_FORMAT(start_date, '%h:%i %p') AS start_time,
    DATE_FORMAT(end_date, '%h:%i %p') AS end_time
     FROM events WHERE client = '$client'
    AND event_status <> 'DELETED'
    AND `start_date` >= '$date'
    ORDER BY start_date;
    ";
    $result = $SQL->SelectQuery($query);

    return $result;

  }

  public function GetPastEvents($client)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $date = date('Y-m-d');

    $query = "SELECT *,
    DATE(start_date) AS date_start,
    DATE_FORMAT(start_date, '%h:%i %p') AS start_time,
    DATE_FORMAT(end_date, '%h:%i %p') AS end_time
     FROM events WHERE client = '$client'
     AND event_status <> 'DELETED'
    AND `start_date` < '$date'
    ORDER BY start_date DESC
    ";
    $result = $SQL->SelectQuery($query);

    return $result;
  }

  public function DoCancelEvent($client, $event_no, $event_status)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $date = date('Y-m-d');

    $query = "UPDATE events SET event_status = '$event_status' WHERE client = '$client' AND event_no = '$event_no';
    ";
    $result = $SQL->UpdateQuery($query);

    return $result;
  }

  public function DoSetPastEventStatus($client)
  {
    $SQL = new SQLCommands("mercedes_ois");
    $date = date('Y-m-d');

    $query = "UPDATE events SET event_status = 'COMPLETED' 
    WHERE client = '$client' 
    AND start_date < '$date'
    AND event_status = 'ACTIVE'
    ";
    $result = $SQL->UpdateQuery($query);

    if (!$result) {
      return ["result" => false, "message" => "Something Went Wrong",];
    } else {
      return ["result" => true, "message" => "nice"];
    }
  }



}

?>