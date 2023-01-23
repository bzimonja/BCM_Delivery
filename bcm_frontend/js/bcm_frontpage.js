  const { createApp } = Vue
        
        const board = createApp({    
          data() {
            return {
              message: "Works",
              statuses: [],
              status_overview:[],
              status_css_ids: ["n/a", "loading", "outbound", "returning", "maintenance", "other"],
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
          },
          mounted() {
            //get a list of statuses to generate the kanban lanes
            this.getStatuses();

            //get a list of all truck statuses to populate the lanes
            this.getStatusOverview();
          },  
        })
        board.mount('#board_app')