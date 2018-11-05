<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <grid-component 
                @updateNewBooking="addBooking"
                :bookings="bookings"
                :cols="cols"
                :rows="rows"></grid-component>

            <form 
                @submit.prevent="saveBooking" 
                v-if="bookings.length > 0">
                <input type="hidden" :value="totalPersonas" name="personas" >
                <div  class="card mb-3">
                    <div class="card-body">
                        <div class="form-group" v-if="codigo_reserva">
                            <label for="fecha_reserva" v-model="codigo_reserva">Reserva: {{codigo_reserva}}</label>
                        </div>
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
                        <button type="submit" class="btn btn-success">Guardar Reserva</button>
                        <a href="/reservas" class="btn btn-primary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</template>

<script>
    // Import required dependencies 
    // import 'bootstrap/dist/css/bootstrap.css';

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
                // new_bookings: [],
                bookings: [],
                date: new Date(),
                options: {
                    format: 'DD/MM/YYYY',
                    useCurrent: true,
                },
                fecha_reserva: '',
                personas: 0,
                attemptSubmit: false,
                isEditing: false,
                reserva: null,
                codigo_reserva: null
            }
        },
        mounted() {
            // console.log('Component mounted.');
            if (typeof window.__INITIAL_STATE__ !== 'undefined') {
                console.log(window.__INITIAL_STATE__);
                let initialState = window.__INITIAL_STATE__;
                this.fecha_reserva = moment(String(initialState.fecha_reserva), "YYYY-MM-DD").format('DD/MM/YYYY');
                let books = initialState.books;
                this.isEditing = true;
                this.reserva = initialState.id;
                this.codigo_reserva = initialState.codigo_reserva;
                for(let i=0; i < books.length; i++){
                    this.bookings.push({
                        'col': this.cols[books[i].col],
                        'index_col': books[i].col,
                        'row': this.rows[books[i].row],
                        'index_row': books[i].row
                    });
                }
            }

            console.log('bookings', this.bookings);
            // this.new_bookings = [{
            //         col: 0,
            //         row: 0
            //     }, {
            //         col: 6,
            //         row: 3
            // }];
            // axios.get('/thoughts').then((response) => {
            //     this.thoughts = response.data;
            // })
        },
        methods: {
            addBooking(index_row, index_col) {
                console.log('addBooking', index_row, index_col);
                let found = this.isExistBook(index_col, index_row);
                console.log(found, this.bookings);
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
                // console.log('this.bookings', this.bookings);
            },
            isExistBook : function(col, row){
                for(let i=0; i < this.bookings.length; i++){
                    if( this.bookings[i].index_col == col && this.bookings[i].index_row == row){
                        return i;
                    }
                }
                return -1;
            },
            deleteBooking(index) {
                this.bookings.splice(index, 1);
                console.log('deleteBooking', this.bookings);
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

                // console.log(params);
                // alert(this.isEditing);
                // return false;
                if (this.isEditing) {
                    axios.put(`/reserva/${this.reserva}`, params)
                        .then((response) => {
                            // console.log(response);
                            // this.descripcion = '';
                            const reserva = response.data;
                            window.location.href = "/reservas";
                        });
                } else {
                    axios.post('/reserva', params)
                        .then((response) => {
                            // console.log(response);
                            // this.descripcion = '';
                            const reserva = response.data;
                            window.location.href = "/reservas";
                        });
                }
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
