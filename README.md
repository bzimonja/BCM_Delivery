# BCM_Delivery
 BCM Delivery assignment for RQ 94266

 #DATABASE

 /database_files directory contains the following files:
    
    -bcm_delivery.sql - create and populate the database used for the assignment
    
    -bcm_delivery_create_db.sql - create an empty database
    
    -bcm_delivery_model.mwb - MySQL Workbench file used to design the database
    
    -bcm_delivery_EER_diagram.png - EER Diagram produced by MySQL Workbench

#BACKEND

/bcm_backend directory contains the Laravel framework project written in PHP for the 
  
  backend web service. 

The service has following entry points (appended to <server_host>/bcm_backend URL):

For any request type, the Read entry points are:

/public/api/driver/index - returns a JSON export of all rows in the driver table, as an array of objects:
 
    {"id":<driver_id>, "driver_first_name": <driver_first_name>, "driver_last_name": <driver_last_name>}

/public/api/status/index - returns a JSON export of all rows in the status table, as an array of objects:
 
    {"id": <status_id>, "status_label": <status_label>} , 
 
        where status_label is the display value users will see

/public/api/truck/index - returns a JSON export of all rows in the truck table, as an array of objects:
 
    {"id": <truck_id>, "status_label": <truck_label>} , 
 
        where truck_label is the display value users will see

/public/api/truck_status/index - returns a JSON export of all rows in the truck_status table, as an array of objects:
 
    {"id": <truck_status_id>, "note":<note>, "truck_id" :<truck_id>, "status_id": <status_id>, "driver_id":<driver_id>},
 
        where truck_id, status_id and driver_id are foreign keys into their respective tables

/public/api/status_overview/index - returns a JSON report of each truck's status, with both ids and labels for all the
 
     components as an array of objects:
 
     {"truck_id":<id in truck table>, "truck_label": <truck_label for that id>, 
 
        "status_id": <id in status table>, "status_label": <status_label for that id>, 
 
        "driver_id": <id in driver table>, "driver_first_name": <first_name for that id>, "driver_last_name": <last_name 

        for that id>}

For POST and PUT request types only, Create entry point is:

/public/api/truck/add - takes in a JSON input of format {"truck_label": "<new_truck_label>"}, and after verifying, 
        
        attempts to insert it into the database. If successful, it will attempt to create new truck_status entry with 

        that truck_id and status_id of 1 (leftmost status on the board). 
    
    Returns a JSON file in the format:
    
    {"code": <0 if success, positive int based on error>,
    
        "message": <corresponding error message>}

For POST and PUT request types only, Update entry point is:

/public/api/truck_status/update - takes in JSON input. The format is:
    
    {"id": <id in truck_status table>, "truck_id": <id in truck table>, 
    
      "driver_id": <id in driver table>, "status_id": <id in status table>, "notes": <free text string of 45 characters 

      or less> }
      
        -at least one of  id or truck_id is mandatory
      
        -at least one of status_id, driver_id or notes is mandatory 
    
    Returns a JSON file in the format:
    
    {"code": <0 if success, positive int based on error>,
    
        "message": <corresponding error message>} 

#FRONTEND

/bcm_frontend contains the HTML, CSS and JS files for the frontend

index.html shows the board of all the current trucks in their lane. 

/html/bob.html shows the status for an individual driver. He can see the other drivers in their lanes. 

If he chooses a new status from the dropdown, it will be updated and refreshed. 