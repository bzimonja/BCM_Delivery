const { createApp } = Vue
        
        const board = createApp({    
          data() {
            return {
              //driver_id should be set by authentication mechanism,but we use a value
              //  to simplify the assignment.
              driver_id: 1,
              statuses: [],
              status_overview:[],
              status_css_ids: ["n/a", "loading", "outbound", "returning", "maintenance", "other"],
              error: "",
            }
          },
          methods: {
            getStatuses() {
              fetch('/bcm_backend/public/api/status/index')
              .then(response=>response.json())
              .then(data=>this.statuses=data);
            },
            
            getStatusOverview(){
              fetch('/bcm_backend/public/api/status_overview/index')
              .then(response=>response.json())
              .then(data=>this.status_overview=data);
            },

            getCurrentDriverName(driver_id){
              var driver_name = "";
              
              for (i=0; i< this.status_overview.length;i++){
                var status = this.status_overview[i];
                if(status.driver_id == driver_id){
                  driver_name = status.driver_first_name + " " + status.driver_last_name;
                }
              }
              return(driver_name);
            },
            getCurrentDriverStatusLabel(driver_id){
              var driver_status = 0;
              
              for (i=0; i< this.status_overview.length;i++){
                var status = this.status_overview[i];
                if(status.driver_id == driver_id){
                  driver_status = status.status_label;
                }
              }
              return(driver_status);
            },
            getCurrentDriverStatusId(driver_id){
              var driver_status = 0;
              
              for (i=0; i< this.status_overview.length;i++){
                var status = this.status_overview[i];
                if(status.driver_id == driver_id){
                  driver_status = status.status_id;
                }
              }
              return(driver_status);
            },
            getCurrentDriverTruckId(driver_id){
              var driver_truck = 0;
              
              for (i=0; i< this.status_overview.length;i++){
                var status = this.status_overview[i];
                if(status.driver_id == driver_id){
                  driver_truck = status.truck_id;
                }
              }
              return(driver_truck);
            },
            changeDriverStatus(event){
              //get the status from dropdown and POST it
              //  do nothing if status isn't 1-5.
              var message_response="";              
              new_status = event.target.value;
              if (new_status <1 || new_status > 5)
              {
                return;
              }
              driver_id = this.driver_id;
              //find the truck_id driver is associated with 
              truck_id = this.getCurrentDriverTruckId(driver_id);
              fetch("/bcm_backend/public/api/truck_status/update", {
                  method: 'POST',
                  headers: {
                    "Content-Type": "application/json",
                    
                  },
                  body: JSON.stringify({
                    "truck_id": truck_id,
                    "driver_id": driver_id,
                    "status_id": new_status 
                  })
                }).then(response=> response.json())
                .then(data=> message_response);
                if (message_response.code == 0)
                {
                    return;
                }
                else
                {
                  this.error = message_response;
                }
                
              }
          },
          computed: {

          },
          mounted() {
            //get a list of statuses to generate the kanban lanes
            this.getStatuses();

            //get a list of all truck statuses to populate the lanes
            this.getStatusOverview();

            
          },  
        })
        board.mount('#driver_app')