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
                        <td class="" 
                            v-for="(value, index_col) in cols.length" 
                            v-on:click="onClickUpdate(index_row, index_col)"
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
                // cols: this.cols,
                // rows: this.rows
                // new_bookings: [],
                // booking: [],
                // descripcion: ''
            }
        },
        mounted() {
            console.log('Component mounted.', this.new_bookings);
            console.log('this.rows',this.rows);
            console.log('this.cols', this.cols);
            console.log('Component mounted.');
            // var _a = function(){
                // var a = [];
                var cols = this.cols.length,
                    rows = this.rows.length;
                for(var i = 0; i < rows; i++){
                    this.new_bookings[i] = new Array(cols);
                    for(var j = 0; j < cols; j++){
                        this.new_bookings[i][j] = {
                            'selected' : false
                        };
                    }
                }
                // return a;
            // }
            // .push(_a)
        },
        methods: {
            
            /*isset_array: function (arr) {
                var i, max_i;
                for (i = 1, max_i = arguments.length; i < max_i; i++) {
                    arr = arr[arguments[i]];
                    if (arr === undefined) {
                        return false;
                    }
                }
                return true;
            },*/
            onClickUpdate(index_row, index_col) {
                // console.log(index_row, index_col);
                // const params = {
                //     descripcion: this.descripcion
                // };
                // axios.post('/thoughts', params)
                //     .then((response) => {
                //         console.log(response);
                //         this.descripcion = '';
                //         const thought = response.data;
                //         this.$emit('new', thought);
                //     });
                // if (this.isset_array(this.new_bookings, index_row, index_col)) {
                    // this.new_bookings[index_row][index_col].selected = !this.new_bookings[index_row][index_col].selected;
                    this.$set(this.new_bookings[index_row][index_col], 'selected', !this.new_bookings[index_row][index_col].selected)
                // } else {
                    // if (!this.new_bookings[index_row][index_col].selected) {
                        // this.new_bookings[index_row][index_col].selected = !this.new_bookings[index_row][index_col].selected;
                        // console.log(this.new_bookings);
                    // }
                // }
                // this.$set('new', thought);
                // @click="this.$set(item, 'selected', !item.selected)"

                // this.booking[index] = thought;

                this.$emit('updateNewBooking', index_row, index_col);
                // console.log(this.new_bookings);
            }
        }
    }
</script>
