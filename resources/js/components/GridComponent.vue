<template>
    <!-- <div class="card mb-3"> -->
        <!-- <div class="card-body"> -->
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
        <!-- </div> -->
    <!-- </div> -->
</template>
<script>
    export default {
        props: ['new_bookings', 'cols', 'rows'],
        data() {
            return {
                
            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        methods: {
            onClickUpdate(index_row, index_col, emit = true) {
                let found = this.existNewBooking(index_row, index_col);
                
                if (found < 0) {
                    let length = this.new_bookings.push({
                        col: index_col,
                        row: index_row
                    });
                    this.$set(this.new_bookings[length - 1], 'selected', !this.new_bookings[length - 1].selected)
                    
                } else {
                    this.new_bookings.splice(found, 1);
                    
                }

                if (emit)
                    this.$emit('updateNewBooking', index_row, index_col);
            },
            contains: function(index_row, index_col) {
                console.log('contains');
                let found = this.existNewBooking(index_row, index_col);
                
                return {
                    'booked' : (found < 0) ? false : true
                }
            },
            existNewBooking: function (index_row, index_col) {
                for(let i=0; i < this.new_bookings.length; i++){
                    if( this.new_bookings[i].col == index_col && this.new_bookings[i].row == index_row){
                        return i;
                    }
                }
                return -1;
            }
        },
        created() {
            this.$root.$on('createImage', (index_row, index_col) => {
                // your code goes here
                console.log(index_row, index_col);
                console.log('ssssss');
                this.onClickUpdate(index_row, index_col, false);
            })
        }
    }
</script>
