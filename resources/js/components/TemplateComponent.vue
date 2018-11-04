<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <grid-component 
                @updateNewBooking="addBooking"
                :new_bookings="new_bookings"
                :cols="cols"
                :rows="rows"></grid-component>

            <form 
                @submit.prevent="saveBooking" 
                v-if="bookings.length > 0">
                <input type="hidden" :value="totalPersonas" name="personas" >
                <div  class="card mb-3">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="fecha_reserva">Fecha de la reserva:</label>
                            <date-picker v-model="fecha_reserva" :config="options" v-bind:class="{ 'is-invalid': attemptSubmit && missingBookingDate }"></date-picker>
                        </div>
                        <ul class="list-group">
                        <bookings-component 
                            v-for="(n_book, index) in bookings" 
                            :key="index" 
                            :bookings="n_book"
                            @delete="deleteBooking(index)"></bookings-component>
                        </ul>
                        <li class="list-group-item list-group-item-action active">Total Personas: {{ totalPersonas }}</li>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Reserva</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</template>

<script>
    // Import required dependencies 
    import 'bootstrap/dist/css/bootstrap.css';

    // Import this component
    import datePicker from 'vue-bootstrap-datetimepicker';

    // Import date picker css
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

    import moment from 'moment'

    export default {
        data() {
            return {
                cols: this.cols_range('A', 'J'),
                rows: this.rows_range(1, 5),
                new_bookings: [],
                bookings: [],
                date: new Date(),
                options: {
                    format: 'DD/MM/YYYY',
                    useCurrent: true,
                },
                fecha_reserva: '',
                personas: 0,
                attemptSubmit: false
            }
        },
        mounted() {
            console.log('Component mounted.');
            this.new_bookings = [{
                    col: 0,
                    row: 0
                }, {
                    col: 6,
                    row: 3
            }];
            this.bookings = [{
                'col': this.cols[0],
                'index_col': 0,
                'row': this.rows[0],
                'index_row': 0
            }, {
                'col': this.cols[6],
                'index_col': 6,
                'row': this.rows[3],
                'index_row': 3
            }];
            // axios.get('/thoughts').then((response) => {
            //     this.thoughts = response.data;
            // })
        },
        methods: {
            addBooking(index_row, index_col) {
                // console.log('addBooking', index_row, index_col);
                let found = this.isExistBook(this.cols[index_col], this.rows[index_row]);
                if (found >= 0) {
                    this.bookings.splice(found, 1);
                } else {
                    this.bookings.push({
                        'col': this.cols[index_col],
                        'index_col': index_col,
                        'row': this.rows[index_row],
                        'index_row': index_row
                    });
                }
                console.log('this.bookings', this.bookings);
            },
            isExistBook : function(col, row){
                for(let i=0; i < this.bookings.length; i++){
                    if( this.bookings[i].col == col && this.bookings[i].row == row){
                        return i;
                    }
                }
                return -1;
            },
            deleteBooking(index) {
                this.bookings.splice(index, 1);
                console.log('deleteBooking', this.new_bookings);
            },
            updateThought(index, thought) {
                this.bookings[index] = thought;
            },
            cols_range: function(start,stop) {
                var result=[];
                for (var idx=start.charCodeAt(0), end=stop.charCodeAt(0); idx <= end; ++idx){
                    result.push(String.fromCharCode(idx));
                }
                return result;
            },
            rows_range: function(start, end) {
                return Array(end - start + 1).fill().map((_, idx) => start + idx)
            },
            saveBooking: function(e) {
                
                this.attemptSubmit = true;

                if (this.missingBookingDate) {
                    e.preventDefault();
                    return false;
                }

                const params = {
                    fecha_reserva: moment(String(this.fecha_reserva), "DD-MM-YYYY").format('YYYY/MM/DD'),
                    books: this.bookings,
                    personas: this.totalPersonas
                };

                console.log(params);

                axios.post('/reserva', params)
                    .then((response) => {
                        console.log(response);
                        // this.descripcion = '';
                        const reserva = response.data;
                        this.$emit('new', reserva);
                    });
            }
        },
        components: {
            datePicker
        },
        computed: {
            totalPersonas: function () { return this.bookings.length },
            missingBookingDate: function () { return this.fecha_reserva === ''; },
        }
    }
</script>
