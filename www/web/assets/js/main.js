Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        });
});

const drones = new Vue({
    el: "#main",
    data: {
        drones: [],
        baseURL: '//localhost:8000/api/',
        pages: [],
        last_page: 1,
        filter: {
            _id: '',
            name: '',
            status: ''
        },
        pagination: {
            _page: 1,
            _limit: 5
        },
        sort: {
            _sort: '',
            _order: ''
        }
    },
    methods: {
        getDrones () {
            this.last_page = 1;
            
            axios.get(this.baseURL+'drones', {
                params: {...this.filter, ...this.pagination, ...this.sort}
            })
            .then(response => {
                this.drones = [];
                for(let i = 0; i < response.data.result.length; i++){
                    this.drones.push(response.data.result[i]);
                }
                
                this.last_page = Math.ceil(response.data.total / this.pagination._limit);
                let pageStart = this.pagination._page - 2;
                if(pageStart <= 2){
                    pageStart = 1;
                }
                
                this.pages = [];
                for (let i = pageStart; i < pageStart+5 && i <= this.last_page; i++) {
                    this.pages.push(i);
                }
                
                this.total = response.data.total;
            });
            
            $('#main #table').show();
        },
        setPage(num) {
            this.pagination._page = num;
            this.getDrones();
        },
        getAbs(num) {
            return num.toString().split('.')[0];
        },
        getDec(num) {
            return num.toString().split('.')[1] ?? 0;
        },
        openDrone(id) {
            detail.view(id);
        },
        createDrone() {
            detail.view(0);
        },
        deleteDrone(id) {
            if(confirm("Do you really want to delete this drone?")){
                axios.delete(this.baseURL+'drones/'+id)
                .then(response => {
                    this.getDrones();
                    alert('Drone successfully deleted');
                });
            }
        },
        save () {
            this.pagination._page = 1;
			this.getDrones();
		}
    },
	computed: {
		drones () {
			return this.drones;
		}
	},
    created () {
        this.getDrones();
    }
});


const detail = new Vue({
    el: "#modalDetail",
    data: {
        drone: {
            id: 0,
            image: '',
            name: '',
            address: '',
            status: '',
            max_speed: 0,
            average_speed: 0,
            battery: 0,
        },
        baseURL: '//localhost:8000/api/',
    },
    methods: {
        getDetails (id) {
            this.drone = [];
            
            axios.get(this.baseURL+'drones/'+id)
            .then(response => {
                this.drone = response.data.result;
                $('#modalDetail').modal('show');
            });
        },
        view(id) {
            if(id != 0){
                this.getDetails(id);
            } else {
                this.drone = {
                    id: 0,
                    image: '',
                    name: '',
                    address: '',
                    status: '',
                    max_speed: 0,
                    average_speed: 0,
                    battery: 0,
                };
                $('#modalDetail').modal('show');
            }
        },
        save () {
            if(this.drone.id == 0){
                axios.post(this.baseURL+'drones', this.drone)
                .then(response => {
                    alert('Drone successfully created');
                    drones.getDrones();
                    $('#modalDetail').modal('hide');
                });
            } else {
                axios.put(this.baseURL+'drones/'+this.drone.id, this.drone)
                .then(response => {
                    alert('Drone successfully updated');
                    drones.getDrones();
                    $('#modalDetail').modal('hide');
                });
            }
		}
    },
	computed: {
		drone () {
			return this.drone;
		}
	}
});