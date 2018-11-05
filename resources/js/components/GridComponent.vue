<template>
    <!-- <div class="card mb-3"> -->
        <!-- <div class="card-body"> -->
        <div class="grid-bookings">
            <table class="table table-bordered table-condensed">
                <thead class="thead-dark">
                    <tr>
                        <th >
                        </th>
                        <th class="" v-for="col in cols" :key="col">
                            {{ col }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index_row) in rows" :key="row">
                        <th scope="row" class="table-dark">{{ row }}</th>
                        <td
                            v-for="(value, index_col) in cols.length" 
                            v-on:click="onClickUpdate(index_row, index_col)"
                            v-bind:class="contains(index_row, index_col)"
                            >
                            {{ cols[index_col] }}{{ row }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- </div> -->
    <!-- </div> -->
</template>
<script>
    export default {
        props: ['bookings', 'cols', 'rows', 'fecha_reserva'],
        data() {
            return {
                
            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        methods: {
            onClickUpdate(index_row, index_col, emit = true) {

                if (this.fecha_reserva != '') {
                    let date = moment(String(this.fecha_reserva), "DD-MM-YYYY").format('YYYY-MM-DD')
                    axios.get(`/reservas/disponibilidad/${date}/${index_row}/${index_col}`).then((response) => {
                        console.log('response availability', response);
                        if (response.data.disponibilidad > 0) {
                            alert('Ya existe una reserva para la fecha y ubicación seleccionada.\nPor favor intente en una nueva ubicación');
                        } else {
                            this.$emit('updateNewBooking', index_row, index_col);
                        }
                        // this.thoughts = response.data;
                    })
                } else {
                    alert('Por favor selecciona una fecha para verificar la disponibilidad de la ubicación');
                }
                // let found = this.existNewBooking(index_row, index_col);
                
                // if (found < 0) {
                //     let length = this.bookings.push({
                //         'col': this.cols[index_col],
                //         'index_col': index_col,
                //         'row': this.rows[index_row],
                //         'index_row': index_row
                //     });
                //     this.$set(this.bookings[length - 1], 'selected', !this.bookings[length - 1].selected)
                    
                // } else {
                //     this.bookings.splice(found, 1);
                    
                // }

                // if (emit)
            },
            contains: function(index_row, index_col) {
                // console.log('contains');
                let found = this.existNewBooking(index_row, index_col);
                
                return {
                    'booked' : (found < 0) ? false : true
                }
            },
            existNewBooking: function (index_row, index_col) {
                for(let i=0; i < this.bookings.length; i++){
                    if( this.bookings[i].index_col == index_col && this.bookings[i].index_row == index_row){
                        return i;
                    }
                }
                return -1;
            }
        },
        created() {
            this.$root.$on('UpdateGrid', (index_row, index_col) => {
                // your code goes here
                console.log(index_row, index_col);
                // this.onClickUpdate(index_row, index_col, false);
            })
        }
    }
</script>
