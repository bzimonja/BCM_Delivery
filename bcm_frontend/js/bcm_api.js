 
export function getStatuses() {
              fetch('/bcm_backend/public/api/status/index')
              .then(response=>response.json());
              return(data);
            };

export function  getStatusOverview(){
              fetch('/bcm_backend/public/api/status_overview/index')
              .then(response=>response.json());
              return(data);
            };
