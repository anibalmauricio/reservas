<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- <div class="card mb-3"> -->
                <!-- <div class="card-body"> -->
                    <grid-component 
                        @updateNewBooking="addBooking"
                        :new_bookings="new_bookings"
                        :cols="cols"
                        :rows="rows"></grid-component>
                <!-- </div> -->
            <!-- </div> -->

            <!-- <div  class="card mb-3"> -->
                <!-- <div class="card-body"> -->
                    <ul class="list-group" v-if="bookings.length > 0">
                    <bookings-component 
                        v-for="(n_book, index) in bookings" 
                        :key="index" 
                        :bookings="n_book"
                        @delete="deleteBooking(index)"></bookings-component>
                    </ul>
                <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>
    
</template>

<script>
    export default {
        data() {
            return {
                cols: this.cols_range('A', 'J'),
                rows: this.rows_range(1, 5),
                new_bookings: [],
                bookings: []
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
            }
        }
    }
</script>
